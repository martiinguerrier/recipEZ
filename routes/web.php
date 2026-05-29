<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeLikeController;
use App\Http\Controllers\RecipeSaveController;
use App\Http\Controllers\ShoppingListController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminCatalogController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\AdminUserController;

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
    Route::get('/featured', [AdminCatalogController::class, 'featured'])->name('admin.featured');
    Route::post('/recipes/{recipe}/feature', [AdminCatalogController::class, 'toggleFeatured'])->name('admin.recipes.feature');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('admin.users.toggle');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
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
    Route::get('/profile/following', [ProfileController::class, 'following'])->name('profile.following');

    // Seguir usuarios
    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');

    // Lista de la compra
    Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping.index');
    Route::post('/shopping-list/recipe/{recipe}', [ShoppingListController::class, 'addFromRecipe'])->name('shopping.add');
    Route::delete('/shopping-list/{item}', [ShoppingListController::class, 'remove'])->name('shopping.remove');
    Route::delete('/shopping-list', [ShoppingListController::class, 'clear'])->name('shopping.clear');
    Route::post('/shopping-list/send', [ShoppingListController::class, 'sendEmail'])->name('shopping.send');
});

// Ruta pública para ver el modal de una receta
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Perfil público de cualquier usuario
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Buscador en tiempo real (JSON para dropdown)
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Búsqueda completa con filtros (vista de resultados)
Route::get('/explore', [SearchController::class, 'results'])->name('search.results');

// RUTA TEMPORAL - ELIMINAR DESPUÉS DE USARLA
Route::get('/make-admin-a7f3k9', function () {
    $user = App\Models\User::where('email', 'admin@recipez.com')->first();
    if (!$user) return 'Usuario no encontrado.';
    $user->is_admin = true;
    $user->save();
    return 'Hecho. ' . $user->email . ' ahora es admin. ELIMINA ESTA RUTA.';
});

// Páginas legales
Route::get('/condiciones-de-uso', fn() => view('legal.condiciones'))->name('legal.condiciones');
Route::get('/aviso-de-cookies', fn() => view('legal.cookies'))->name('legal.cookies');
Route::get('/configuracion-de-cookies', fn() => view('legal.configuracion-cookies'))->name('legal.configuracion-cookies');
Route::get('/accesibilidad', fn() => view('legal.accesibilidad'))->name('legal.accesibilidad');

// Rutas de autenticación generadas por Breeze
require __DIR__ . '/auth.php';