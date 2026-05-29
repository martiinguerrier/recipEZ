@extends('layouts.clean')

@section('title', 'Admin - Gestión de Usuarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .users-table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        .users-table th, .users-table td { padding: .75rem 1rem; text-align: left; border-bottom: 1px solid #eee; }
        .users-table th { background: #f8f8f8; font-weight: 600; font-size: .85rem; text-transform: uppercase; color: #888; }
        .users-table tr:hover td { background: #fafafa; }
        .badge-admin { background: #ff6b35; color: #fff; font-size: .75rem; padding: .2rem .55rem; border-radius: 20px; font-weight: 600; }
        .badge-user  { background: #e0e0e0; color: #666; font-size: .75rem; padding: .2rem .55rem; border-radius: 20px; }
        .user-avatar-sm { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; vertical-align: middle; margin-right: .5rem; }
        .search-bar { display: flex; gap: .75rem; margin-top: 1.5rem; }
        .search-bar input { flex: 1; padding: .6rem 1rem; border: 1px solid #ddd; border-radius: 8px; font-size: .95rem; }
        .search-bar button { padding: .6rem 1.2rem; background: #ff6b35; color: #fff; border: none; border-radius: 8px; cursor: pointer; }
        .btn-toggle-admin { padding: .35rem .85rem; border: none; border-radius: 6px; cursor: pointer; font-size: .85rem; font-weight: 600; }
        .btn-toggle-admin.make   { background: #ff6b35; color: #fff; }
        .btn-toggle-admin.revoke { background: #e0e0e0; color: #555; }
    </style>
@endpush

@section('content')

<main class="admin-catalog-container">

    <a href="{{ route('home') }}" class="back-btn">← Volver</a>

    <h1><i class="bi bi-people-fill"></i> Gestión de Usuarios</h1>

    @if(session('success'))
        <div class="admin-flash success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-flash error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <form class="search-bar" method="GET" action="{{ route('admin.users') }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre o email...">
        <button type="submit"><i class="bi bi-search"></i> Buscar</button>
    </form>

    <table class="users-table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Recetas</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        @if($user->avatar)
                            <img src="{{ \Storage::url($user->avatar) }}" class="user-avatar-sm" alt="">
                        @else
                            <i class="bi bi-person-circle" style="font-size:1.5rem; vertical-align:middle; margin-right:.5rem; color:#ccc"></i>
                        @endif
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span style="font-size:.75rem; color:#aaa">(tú)</span>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge-admin"><i class="bi bi-shield-fill-check"></i> Admin</span>
                        @else
                            <span class="badge-user">Usuario</span>
                        @endif
                    </td>
                    <td>{{ $user->recipes_count ?? $user->recipes->count() }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf
                                @if($user->is_admin)
                                    <button class="btn-toggle-admin revoke"
                                            onclick="return confirm('¿Quitar admin a {{ $user->name }}?')">
                                        <i class="bi bi-shield-x"></i> Quitar admin
                                    </button>
                                @else
                                    <button class="btn-toggle-admin make"
                                            onclick="return confirm('¿Hacer admin a {{ $user->name }}?')">
                                        <i class="bi bi-shield-plus"></i> Hacer admin
                                    </button>
                                @endif
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center; padding:2rem; color:#aaa">No se encontraron usuarios.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:1.5rem">
        {{ $users->links() }}
    </div>

</main>

@endsection
