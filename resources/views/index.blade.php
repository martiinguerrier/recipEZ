<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipEZ</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('img/Favicon RecipEZ.png') }}">
</head>

<body class="recip">

    <div id="inicio"></div>
    <header class="navbar">
        <div class="nav-left">
            <img src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo">
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

            @auth
            <div class="profile-icon">
                <a href="/profile">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-small">
                    @else
                    <i class="bi bi-person-circle"></i>
                    @endif
                </a>
            </div>

            <a href="/profile"><span>{{ auth()->user()->name }}</span></a>
            @endauth

            @guest
            <div class="profile-icon">
                <a href="/login"><i class="bi bi-person-circle"></i></a>
            </div>
            <a href="/login"><span>Sign in/up</span></a>
            @endguest

        </div>


    </header>

    <div class="hero">
        <img src="{{ asset('img/Título RecipEZ-rosanegro.webp') }}" alt="">
        <h1>Descubre y Comparte Recetas de Forma Sencilla</h1>
    </div>

    <main>
        <div class="destacadas">
            <h1>Recetas Destacadas de la Semana</h1>
            <div class="viñetas">

                <div class="destacado" id="milanesanapolitana">
                    <div class="destacado-top">
                        <div class="destacado-top-top">
                            <div class="destacado-user">
                                <i class="bi bi-person-circle"></i>
                                <span class="username">locosxelasado<i class="bi bi-patch-check-fill"></i></span>
                            </div>
                            <div class="opciones">
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>
                        </div>
                        <div class="destacado-titulo">
                            <h1>Milanesa a la napolitana</h1>
                        </div>
                    </div>

                    <div class="destacado-bottom"></div>


                </div>

                <div class="destacado" id="tartaespinaca">
                    <div class="destacado-top">
                        <div class="destacado-top-top">
                            <div class="destacado-user">
                                <i class="bi bi-person-circle"></i>
                                <span class="username">monilo3</i></span>
                            </div>
                            <div class="opciones">
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>
                        </div>
                        <div class="destacado-titulo">
                            <h1>Tarta de espinaca y huevo</h1>
                        </div>
                    </div>

                    <div class="destacado-bottom"></div>
                </div>


                <div class="destacado" id="torrijas">
                    <div class="destacado-top">
                        <div class="destacado-top-top">
                            <div class="destacado-user">
                                <i class="bi bi-person-circle"></i>
                                <span class="username">abuela_cocinera</span>
                            </div>
                            <div class="opciones">
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>
                        </div>
                        <div class="destacado-titulo">
                            <h1>Torrijas Caseras</h1>
                        </div>
                    </div>

                    <div class="destacado-bottom"></div>
                </div>


                <div class="destacado" id="lentejasboniato">
                    <div class="destacado-top">
                        <div class="destacado-top-top">
                            <div class="destacado-user">
                                <i class="bi bi-person-circle"></i>
                                <span class="username">karlosarguinano<i class="bi bi-patch-check-fill"></i></span>
                            </div>
                            <div class="opciones">
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>
                        </div>
                        <div class="destacado-titulo">
                            <h1>Lentejas con Boniato</h1>
                        </div>
                    </div>

                    <div class="destacado-bottom"></div>
                </div>
            </div>
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