@extends('layouts.clean')

@section('title', 'Perfil Personal')

@section('content')


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
                    <div class="receta-tarjeta" data-id="{{ $recipe->id }}">

                        <div class="receta-image">
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                            <div class="overlay"><span>VER</span></div>
                        </div>

                        <h3>{{ $recipe->title }}</h3>

                        <div class="receta-actions">
                            <div class="delEdit">
                                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-small"><i
                                        class="bi bi-pencil-square"></i></a>

                                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger-small"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>

                            <div class="likes1">
                                <i class="bi bi-heart-fill"></i>
                                <div class="likes" id="likes-{{ $recipe->id }}">
                                    {{ $recipe->likes->count() }}
                                </div>
                            </div>


                        </div>

                    </div>

                @empty
                    <p class="no-recetas">Todavía no has creado ninguna receta.</p>
                @endforelse

            </div>

            <div id="recipe-modal" class="modal-overlay" style="display:none;">
                <div class="modal-content">
                    <button class="modal-close"></button>
                    <div id="modal-body">
                        <!-- Aquí se cargará la receta -->
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const modal = document.getElementById('recipe-modal');
            const modalBody = document.getElementById('modal-body');
            const closeBtn = document.querySelector('.modal-close');

            // Cerrar modal
            closeBtn.addEventListener('click', () => {
                cerrarModal();
            });

            // Cerrar modal al hacer clic fuera
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    cerrarModal();
                }
            });

            // Función para cerrar con animación
            function cerrarModal() {
                modal.classList.remove('show');
                const content = modal.querySelector('.modal-content');
                content.classList.remove('show');

                setTimeout(() => {
                    modal.style.display = 'none';
                    modalBody.innerHTML = '';
                }, 250);
            }

            // Abrir modal al hacer click en una receta
            document.querySelectorAll('.receta-tarjeta').forEach(card => {
                card.addEventListener('click', () => {
                    const recipeId = card.dataset.id;

                    fetch(`/recipes/${recipeId}`)
                        .then(res => res.text())
                        .then(html => {

                            // Insertar contenido
                            modalBody.innerHTML = html;

                            // Mostrar modal
                            modal.style.display = 'flex';

                            // Animación suave
                            setTimeout(() => {
                                modal.classList.add('show');
                                modal.querySelector('.modal-content').classList.add('show');
                            }, 10);
                        });
                });
            });

        });

        window.toggleLikeModal = function (recipeId) {
            console.log('CLICK LIKE MODAL', recipeId);

            fetch(`/recipes/${recipeId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {

                    // Contador del modal
                    const modalCount = document.getElementById(`modal-likes-count-${recipeId}`);
                    if (modalCount) {
                        modalCount.innerText = data.count;
                    }

                    // Contador de la tarjeta
                    const cardLikes = document.getElementById(`likes-${recipeId}`);
                    if (cardLikes) {
                        cardLikes.innerHTML = data.count;
                    }

                    // Corazón del modal
                    const btn = document.getElementById(`modal-like-btn-${recipeId}`);
                    if (btn) {
                        btn.innerHTML = data.liked ? `<i class="bi bi-heart-fill" style="color: red;"></i>`
                            : `<i class="bi bi-heart"></i>`;
                    }
                });
        }




    </script>


@endsection