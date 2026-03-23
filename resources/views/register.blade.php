<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/Favicon RecipEZ.png') }}">
    <title>RecipEZ</title>
</head>

<body class="recip">

    <header>
        <div class="cabecera">
            <a href="/"><img class="cabecera" src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo"></a>
        </div>
    </header>

    <div class="login-container">
        <div class="login-box">
            <h1>Crear Cuenta</h1>

            {{-- Mostrar errores --}}
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Tu correo..." required>

                <label for="name">Nombre de Usuario</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Tu nombre de usuario..." required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       placeholder="Tu contraseña..." required>

                <label for="password_confirmation">Repite la Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Repite tu contraseña..." required>

                <button type="submit" class="login-btn">Crear Cuenta</button>
            </form>

            <p class="register-link">¿Ya tienes una cuenta? <a href="/login">Inicia sesión aquí</a></p>
        </div>
    </div>

</body>

</html>
