<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {
        $admin = User::where('is_admin', true)->firstOrFail();
        $recipes = $admin->recipes()->with('user')->latest()->get();

        return view('index', compact('recipes'));
    }
}
