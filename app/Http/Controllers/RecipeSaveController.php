<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeSave;

class RecipeSaveController extends Controller
{
    public function toggle($id)
    {
        $recipe   = Recipe::findOrFail($id);
        $user     = auth()->user();
        $existing = RecipeSave::where('user_id', $user->id)
                              ->where('recipe_id', $id)
                              ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['saved' => false]);
        }

        RecipeSave::create(['user_id' => $user->id, 'recipe_id' => $id]);
        return response()->json(['saved' => true]);
    }
}
