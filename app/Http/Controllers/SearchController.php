<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Búsqueda completa con filtros → devuelve vista de resultados.
     */
    public function results(Request $request)
    {
        $q           = trim($request->input('q', ''));
        $ingredients = array_filter((array) $request->input('ingredients', []));
        $foodTypes   = array_filter((array) $request->input('food_types', []));
        $diets       = array_filter((array) $request->input('diets', []));

        $query = Recipe::query();

        if ($q !== '') {
            $query->where('title', 'LIKE', "%{$q}%");
        }
        if (!empty($ingredients)) {
            $query->whereHas('ingredients', fn($q) => $q->whereIn('ingredients.id', $ingredients));
        }
        if (!empty($foodTypes)) {
            $query->whereHas('foodType', fn($q) => $q->whereIn('food_types.id', $foodTypes));
        }
        if (!empty($diets)) {
            $query->whereHas('diets', fn($q) => $q->whereIn('diets.id', $diets));
        }

        $recipes = $query->latest()->get();

        return view('search.results', compact('recipes', 'q', 'ingredients', 'foodTypes', 'diets'));
    }

    /**
     * Búsqueda rápida en tiempo real → devuelve JSON para el dropdown del navbar.
     */
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['recipes' => [], 'users' => []]);
        }

        $recipes = Recipe::where('title', 'LIKE', "%{$q}%")
            ->limit(3)
            ->get(['id', 'title', 'image']);

        $users = User::where('name', 'LIKE', "%{$q}%")
            ->limit(2)
            ->get(['id', 'name', 'avatar']);

        return response()->json([
            'recipes' => $recipes->map(fn($r) => [
                'id'    => $r->id,
                'title' => $r->title,
                'image' => $r->image ? asset('storage/' . $r->image) : null,
            ]),
            'users' => $users->map(fn($u) => [
                'id'     => $u->id,
                'name'   => $u->name,
                'avatar' => $u->avatar ? asset('storage/' . $u->avatar) : null,
            ]),
        ]);
    }
}
