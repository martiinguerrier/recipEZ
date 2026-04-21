<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Dashboard protegido por auth + verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Panel admin (solo usuarios autenticados)
Route::get('/admin/indexadmin', function () {
    return view('admin.indexadmin');
})->middleware('auth')->name('admin.index');

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Mis recetas (vista personalizada)
    Route::get('/profile/recipes', [ProfileController::class, 'recipes'])->name('profile.recipes');

    // CRUD de recetas
    Route::resource('recipes', RecipeController::class);
});

// Rutas de autenticación generadas por Breeze
require __DIR__.'/auth.php';
