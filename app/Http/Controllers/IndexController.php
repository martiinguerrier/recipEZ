<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class IndexController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('is_featured', true)
            ->with('user', 'likes')
            ->latest()
            ->get();

        return view('index', compact('recipes'));
    }
}
