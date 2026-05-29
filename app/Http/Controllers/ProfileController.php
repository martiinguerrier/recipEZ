<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'Perfil actualizado correctamente.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:10240']
        ]);

        $path = $request->file('avatar')->store('avatars', 'r2');

        // Guardar ruta en la BD
        $user = Auth::user();
        $user->avatar = $path;
        $user->save();

        return back()->with('status', 'Avatar actualizado correctamente');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function recipes()
    {
        $recipes = auth()->user()->recipes;
        return view('profile.recipes', compact('recipes'));
    }

    public function saved()
    {
        $recipes = auth()->user()->savedRecipes()->with('user', 'likes')->latest('recipe_saves.created_at')->get();
        return view('profile.saved', compact('recipes'));
    }

    public function following()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');
        $recipes = \App\Models\Recipe::with('user', 'likes')
                    ->whereIn('user_id', $followingIds)
                    ->latest()
                    ->get();
        return view('profile.following', compact('recipes'));
    }

    /**
     * Perfil público de cualquier usuario.
     */
    public function show(User $user)
    {
        // Si el usuario autenticado visita su propio perfil, redirigir a su gestión de recetas
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('profile.recipes');
        }

        $recipes = $user->recipes;
        return view('profile.show', compact('user', 'recipes'));
    }

}
