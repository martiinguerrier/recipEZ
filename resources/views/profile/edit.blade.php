<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipEZ</title>

    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/Favicon RecipEZ.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-left">
            <a href="/"><img src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo"></a>
        </div>

        <div class="nav-right">
            <div class="profile-icon">
                <a href="/profile">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-header">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                </a>
            </div>

            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </header>

    <main class="profile-container">

        <h1>Configuración de Perfil</h1>

        @if (session('status'))
            <div class="status-box">
                {{ session('status') }}
            </div>
        @endif

        <div class="profile-sections">

            <section class="profile-card">
                <h2>Avatar</h2>

                <div class="avatar-preview">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-large">
                    @else
                        <i class="bi bi-person-circle avatar-large"></i>
                    @endif
                </div>

                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                    @csrf
                    <label for="avatar">Subir nuevo avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*">
                    <button type="submit" class="btn">Guardar Avatar</button>
                </form>
            </section>

            <section class="profile-card">
                <h2>Información de la Cuenta</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <label for="name">Nombre de usuario</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>

                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>

                    <button type="submit" class="btn">Guardar Cambios</button>
                </form>
            </section>

            <section class="profile-card">
                <h2>Cambiar Contraseña</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <label for="current_password">Contraseña actual</label>
                    <input type="password" name="current_password" id="current_password" required>

                    <label for="password">Nueva contraseña</label>
                    <input type="password" name="password" id="password" required>

                    <label for="password_confirmation">Repetir nueva contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>

                    <button type="submit" class="btn">Actualizar Contraseña</button>
                </form>
            </section>

            <section class="profile-card">
                <h2>Eliminar Cuenta</h2>

                <p>Esta acción no se puede deshacer.</p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <label for="password_delete">Introduce tu contraseña para confirmar</label>
                    <input type="password" name="password" id="password_delete" required>

                    <button type="submit" class="btn-danger">Eliminar Cuenta</button>
                </form>
            </section>

        </div>

    </main>

</body>
</html>
