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
            <a href="/"><img class="cabecera" src="{{ asset('img/Título RecipEZ-rosanegro.webp') }}" alt="RecipEZ" class="logo"></a>
        </div>
    </header>

    <div class="login-container">
        <div class="login-box">
            <h1>Iniciar Sesión</h1>

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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       placeholder="Tu correo..." required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       placeholder="Tu contraseña..." required>

                <button type="submit" class="login-btn">Entrar</button>
            </form>

            <p class="register-link">¿No tienes cuenta? <a href="/register">Regístrate aquí</a></p>
        </div>
    </div>

</body>

</html>
