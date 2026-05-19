<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
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
