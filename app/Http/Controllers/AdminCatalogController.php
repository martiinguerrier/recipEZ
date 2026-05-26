<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\FoodType;
use App\Models\Diet;
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
        ]);
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
