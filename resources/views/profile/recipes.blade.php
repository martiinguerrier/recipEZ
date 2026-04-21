<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipEZ</title>

    <link rel="stylesheet" href="{{ asset('css/profilerecipes.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/Favicon RecipEZ.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>


<body>
    <div id="inicio"></div>
    <header class="navbar">
        <div class="nav-left">
            <a href="/"><img src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo"></a>
            <div class="rrss">
                <i class="bi-instagram"></i>
                <i class="bi-facebook"></i>
                <i class="bi-tiktok"></i>
                <i class="bi-youtube"></i>
            </div>
        </div>

        <div class="nav-center">
            <div class="search-container">
                <input type="text" placeholder="Buscar recetas, ingredientes, usuarios . . ." class="search-input">
                <i class="bi bi-search"></i>
                <button class="filter-btn"><b>☰</b></button>
            </div>
        </div>

        <div class="nav-right">
            <div class="profile-icon">
                <a href="/profile">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-small">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                </a>
            </div>

            <span>{{ auth()->user()->name }}</span>

            <a href="{{ route('profile.edit') }}" class="btn-secondary">AJUSTES DE PERFIL</a>

        </div>
    </header>

    <main class="profile-container">

        <h1>Mis Recetas</h1>

        <div class="recetas-grid">

            {{-- Tarjeta especial para añadir receta --}}
            <a href="{{ route('recipes.create') }}" class="add-tarjeta">
                <div class="add-contenido">
                    <i class="bi bi-plus-lg"></i>
                    <span>Añadir receta</span>
                </div>
            </a>

            @forelse($recipes as $recipe)
                <div class="receta-tarjeta">

                    <div class="receta-image">
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                        <div class="overlay"><span>VER</span></div>
                    </div>

                    <h3>{{ $recipe->title }}</h3>

                    <div class="receta-actions">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="btn-small">Ver</a>
                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-small">Editar</a>

                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger-small">Eliminar</button>
                        </form>
                    </div>

                </div>
            @empty
                <p class="no-recetas">Todavía no has creado ninguna receta.</p>
            @endforelse

        </div>

    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div><img class="logoBlanco" src="{{ asset('img/logoBlanco.webp') }}" alt="RecipEZ"></div>
                <div class="volver"><a href="#inicio"><button class="volver-btn"><b>VOLVER ARRIBA</b></button></a></div>
            </div>
            <div class="footer-mid">
                <div>
                    <h3>Navegación</h3>
                    <ul>
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/login">Iniciar sesión</a></li>
                        <li><a href="/register">Registrarse</a></li>
                        <li>Cerrar sesión</li>
                    </ul>
                </div>
                <div>
                    <h3>Redes Sociales</h3>
                    <ul>
                        <li>Instagram</li>
                        <li>Facebook</li>
                        <li>Tik Tok</li>
                        <li>YouTube</li>
                    </ul>
                </div>
                <div>
                    <h3>Información Legal</h3>
                    <ul>
                        <li>Condiciones de uso</li>
                        <li>Aviso de cookies</li>
                        <li>Configuración de cookies</li>
                        <li>Declaración de Accesibilidad</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy 2026 RecipEZ - Todos los derechos reservados</span>
            </div>
        </div>
    </footer>

</body>


</html>