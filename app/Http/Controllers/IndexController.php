<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {
        // Obtener usuario admin
        $admin = User::where('name', 'admin')->firstOrFail();

        // Obtener sus recetas
        $recipes = $admin->recipes()->latest()->get();

        return view('index', compact('recipes'));
    }
}
