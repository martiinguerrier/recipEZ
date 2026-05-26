<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeLikeController;
use App\Http\Controllers\RecipeSaveController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminCatalogController;

Route::get('/', [IndexController::class, 'index'])->name('home');


// Dashboard protegido por auth + verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Panel admin (solo administradores)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/indexadmin', fn() => view('admin.indexadmin'))->name('admin.index');
    Route::get('/catalog', [AdminCatalogController::class, 'index'])->name('admin.catalog');
    Route::post('/catalog/{type}', [AdminCatalogController::class, 'store'])->name('admin.catalog.store');
Route::delete('/catalog/{type}/{id}', [AdminCatalogController::class, 'destroy'])->name('admin.catalog.destroy');
});

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Mis recetas (vista personalizada)
    Route::get('/profile/recipes', [ProfileController::class, 'recipes'])->name('profile.recipes');

    // CRUD de recetas (excepto show, que es público)
    Route::resource('recipes', RecipeController::class)->except(['show']);

    // Likes
    Route::post('/recipes/{id}/like', [RecipeLikeController::class, 'toggle'])->name('recipes.like');

    // Guardados
    Route::post('/recipes/{id}/save', [RecipeSaveController::class, 'toggle'])->name('recipes.save');
    Route::get('/profile/saved', [ProfileController::class, 'saved'])->name('profile.saved');
});

// Ruta pública para ver el modal de una receta
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Perfil público de cualquier usuario
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Buscador en tiempo real (JSON para dropdown)
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Búsqueda completa con filtros (vista de resultados)
Route::get('/explore', [SearchController::class, 'results'])->name('search.results');

// Rutas de autenticación generadas por Breeze
require __DIR__ . '/auth.php';