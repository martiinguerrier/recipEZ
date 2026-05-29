<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                                  ->orWhere('email', 'like', "%$search%"))
                     ->orderBy('name')
                     ->paginate(20)
                     ->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes modificar tu propio rol.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $msg = $user->is_admin
            ? "{$user->name} ahora es administrador."
            : "{$user->name} ya no es administrador.";

        return back()->with('success', $msg);
    }
}
