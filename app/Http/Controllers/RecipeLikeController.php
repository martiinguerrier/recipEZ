<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeLike;
use App\Models\Recipe;;

class RecipeLikeController extends Controller
{
    public function toggle($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user = auth()->user();

        $existing = RecipeLike::where('user_id', $user->id)
            ->where('recipe_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'liked' => false,
                'count' => $recipe->likes()->count()
            ]);
        }

        RecipeLike::create([
            'user_id' => $user->id,
            'recipe_id' => $id
        ]);

        return response()->json([
            'liked' => true,
            'count' => $recipe->likes()->count()
        ]);
    }
}

