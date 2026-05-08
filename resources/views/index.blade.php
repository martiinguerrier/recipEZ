@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div class="hero">
        <img src="{{ asset('img/Título RecipEZ-rosanegro.webp') }}" alt="">
        <h1>Descubre y Comparte Recetas de Forma Sencilla</h1>
    </div>

    <main>
        <div class="destacadas">
            <h1>Recetas Destacadas de la Semana</h1>
            <div class="viñetas">

                <div class="destacado" id="milanesanapolitana">
                    <div class="overlay">
                        <span>VER</span>
                    </div>
                    <div class="destacado-top">
                        <div class="destacado-top-top">
                            <div class="destacado-user">
                                <i class="bi bi-person-circle"></i>
                                <span class="username">locosxelasado<i class="bi bi-patch-check-fill"></i></span>
                            </div>
                            <div class="opciones">
                                <i class="bi bi-heart"></i>
                            </div>
                        </div>
                        <div class="destacado-titulo">
                            <h1>Milanesa a la napolitana</h1>
                        </div>
                    </div>

                    <div class="destacado-bottom"></div>


                </div>

                <div class="destacado" id="tartaespinaca">
                    <div class="overlay">
                        <span>VER</span>
                    </div>
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
                    <div class="overlay">
                        <span>VER</span>
                    </div>
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
                    <div class="overlay">
                        <span>VER</span>
                    </div>
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


                <div class="destacado" id="lentejasboniato">
                    <div class="overlay">
                        <span>VER</span>
                    </div>
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


                <div class="destacado" id="lentejasboniato">
                    <div class="overlay">
                        <span>VER</span>
                    </div>
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

@endsection