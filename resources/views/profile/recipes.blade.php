@extends('layouts.clean')

@section('title', 'RecipEZ - ' . auth()->user()->name)

@section('content')


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

                        <div class="card-right-actions">
                            <div class="likes1">
                                <span id="card-like-{{ $recipe->id }}" class="card-like-btn"
                                      onclick="event.stopPropagation(); toggleLike({{ $recipe->id }})">
                                    @if($recipe->likedBy(auth()->user()))
                                        <i class="bi bi-heart-fill" style="color:red;"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </span>
                                <span class="likes" id="likes-{{ $recipe->id }}">{{ $recipe->likes->count() }}</span>
                            </div>
                            <span id="card-save-{{ $recipe->id }}" class="card-save-btn"
                                  onclick="event.stopPropagation(); toggleSave({{ $recipe->id }})">
                                @if($recipe->savedBy(auth()->user()))
                                    <i class="bi bi-bookmark-fill" style="color:#ff8800;"></i>
                                @else
                                    <i class="bi bi-bookmark"></i>
                                @endif
                            </span>
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

            // Función reutilizable para abrir el modal dado un ID de receta
            function abrirModal(recipeId) {
                fetch(`/recipes/${recipeId}`)
                    .then(res => res.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        modal.style.display = 'flex';
                        setTimeout(() => {
                            modal.classList.add('show');
                            modal.querySelector('.modal-content').classList.add('show');
                        }, 10);
                    });
            }

            // Abrir modal desde el buscador del navbar
            window.addEventListener('openRecipeModal', (e) => {
                abrirModal(e.detail.id);
            });

            // Abrir modal solo al hacer click en la imagen
            document.querySelectorAll('.receta-tarjeta').forEach(card => {
                card.querySelector('.receta-image').addEventListener('click', () => {
                    abrirModal(card.dataset.id);
                });
            });

        });

        window.toggleSave = function(recipeId) {
            fetch(`/recipes/${recipeId}/save`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => res.json())
            .then(data => {
                const icon = data.saved
                    ? `<i class="bi bi-bookmark-fill" style="color:#ff8800;"></i>`
                    : `<i class="bi bi-bookmark"></i>`;
                const cardBtn = document.getElementById(`card-save-${recipeId}`);
                if (cardBtn) cardBtn.innerHTML = icon;
                const modalBtn = document.getElementById(`modal-save-btn-${recipeId}`);
                if (modalBtn) modalBtn.innerHTML = icon;
            });
        }
        window.toggleSaveModal = window.toggleSave;

        window.toggleLike = function(recipeId) {
            fetch(`/recipes/${recipeId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => res.json())
            .then(data => {
                const heartIcon = data.liked
                    ? `<i class="bi bi-heart-fill" style="color:red;"></i>`
                    : `<i class="bi bi-heart"></i>`;
                const cardBtn = document.getElementById(`card-like-${recipeId}`);
                if (cardBtn) cardBtn.innerHTML = heartIcon;
                const cardCount = document.getElementById(`likes-${recipeId}`);
                if (cardCount) cardCount.innerHTML = data.count;
                const modalBtn = document.getElementById(`modal-like-btn-${recipeId}`);
                if (modalBtn) modalBtn.innerHTML = heartIcon;
                const modalCount = document.getElementById(`modal-likes-count-${recipeId}`);
                if (modalCount) modalCount.innerText = data.count;
            });
        }
        window.toggleLikeModal = window.toggleLike;




    </script>


@endsection