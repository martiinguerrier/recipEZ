<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\FoodType;
use App\Models\Diet;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Mostrar todas las recetas del usuario (no lo usas porque ya tienes profile.recipes)
     */
    public function index()
    {
        $recipes = auth()->user()->recipes;
        return view('profile.recipes', compact('recipes'));
    }

    /**
     * Formulario para crear una nueva receta
     */
    public function create()
    {
        $ingredients = Ingredient::all();
        $foodTypes = FoodType::all();
        $diets = Diet::all();

        return view('recipes.create', compact('ingredients', 'foodTypes', 'diets'));
    }


    /**
     * Guardar una nueva receta
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',

            // Imagen obligatoria
            'image' => 'required|image|max:2048',

            // Ingredientes: obligatorio, mínimo 2
            'ingredients' => 'required|array|min:2',
            'ingredients.*' => 'exists:ingredients,id',

            // Tipo de comida: obligatorio, máximo 3
            'food_type_id' => 'required|array|max:3',
            'food_type_id.*' => 'exists:food_types,id',

            // Dietas: opcional
            'diets' => 'nullable|array',
            'diets.*' => 'exists:diets,id',
        ]);

        // Subir imagen si existe
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'r2');
        }

        // Asignar receta al usuario autenticado
        $validated['user_id'] = auth()->id();

        // Crear receta
        $recipe = Recipe::create($validated);

        // Relacionar ingredientes (many-to-many)
        $recipe->ingredients()->sync($validated['ingredients']);

        // Relacionar tipo de comida (many-to-many aunque uses máximo 3)
        $recipe->foodType()->sync($validated['food_type_id']);

        // Relacionar dietas (many-to-many)
        if (!empty($validated['diets'])) {
            $recipe->diets()->sync($validated['diets']);
        }

        return redirect()->route('profile.recipes')
            ->with('status', 'Receta creada correctamente.');
    }


    /**
     * Mostrar una receta concreta
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show-modal', compact('recipe'));
    }

    /**
     * Formulario para editar una receta
     */
    public function edit(Recipe $recipe)
    {
        abort_unless($recipe->user_id === auth()->id() || auth()->user()?->isAdmin(), 403);

        $ingredients = Ingredient::all();
        $foodTypes = FoodType::all();
        $diets = Diet::all();

        return view('recipes.edit', compact('recipe', 'ingredients', 'foodTypes', 'diets'));
    }


    /**
     * Actualizar una receta
     */
    public function update(Request $request, Recipe $recipe)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|array|min:2',
            'food_type_id' => 'required|array|max:3',
            'diets' => 'nullable|array',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp,avif|max:4096',
            'ingredients.*' => 'exists:ingredients,id',
            'food_type_id.*' => 'exists:food_types,id',
            'diets.*' => 'exists:diets,id',

        ]);

        // Imagen nueva (si se sube)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'r2');
            $validated['image'] = $path;
        }

        // Actualizar receta
        $recipe->update($validated);

        // Sincronizar relaciones
        $recipe->ingredients()->sync($validated['ingredients']);
        $recipe->foodType()->sync($validated['food_type_id'] ?? []);
        $recipe->diets()->sync($validated['diets'] ?? []);


        return redirect()->route('profile.show', $recipe->user_id)
            ->with('success', 'Receta actualizada correctamente');
    }


    /**
     * Eliminar una receta
     */
    public function destroy(Recipe $recipe)
    {
        abort_unless($recipe->user_id === auth()->id() || auth()->user()?->isAdmin(), 403);

        $ownerId = $recipe->user_id;
        $recipe->delete();

        return redirect()->route('profile.show', $ownerId)
            ->with('status', 'Receta eliminada correctamente.');
    }
}
