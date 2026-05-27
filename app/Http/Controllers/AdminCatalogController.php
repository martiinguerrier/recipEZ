<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\FoodType;
use App\Models\Diet;
use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminCatalogController extends Controller
{
    private array $map = [
        'ingredients' => Ingredient::class,
        'food_types'  => FoodType::class,
        'diets'       => Diet::class,
    ];

    public function index()
    {
        return view('admin.catalog', [
            'ingredients' => Ingredient::orderBy('name')->get(),
            'foodTypes'   => FoodType::orderBy('name')->get(),
            'diets'       => Diet::orderBy('name')->get(),
            'allRecipes'  => Recipe::with('user')->orderBy('title')->get(),
        ]);
    }

    public function featured()
    {
        return view('admin.featured', [
            'allRecipes' => Recipe::with('user')
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->get(),
        ]);
    }

    public function toggleFeatured(Recipe $recipe)
    {
        $recipe->is_featured = !$recipe->is_featured;
        $recipe->save();

        $msg = $recipe->is_featured
            ? '«' . $recipe->title . '» añadida a recetas destacadas.'
            : '«' . $recipe->title . '» eliminada de recetas destacadas.';

        return back()->with('success', $msg);
    }

    public function store(Request $request, string $type)
    {
        $class = $this->resolve($type);
        $table = (new $class)->getTable();
        $request->validate(['name' => "required|string|max:100|unique:{$table},name"]);
        $class::create(['name' => $request->name]);
        return back()->with('success', 'Elemento añadido correctamente.');
    }

    public function destroy(string $type, int $id)
    {
        $class = $this->resolve($type);
        $item  = $class::findOrFail($id);
        $item->recipes()->detach();
        $item->delete();
        return back()->with('success', 'Elemento eliminado correctamente.');
    }

    private function resolve(string $type): string
    {
        abort_unless(isset($this->map[$type]), 404);
        return $this->map[$type];
    }
}
