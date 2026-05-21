@extends('layouts.clean')

@section('title', 'RecipEZ - Resultados')

@section('content')

<main class="profile-container">

    {{-- Cabecera de resultados --}}
    <div class="results-header">
        @if($q !== '' && (count($ingredients) + count($foodTypes) + count($diets)) > 0)
            <h1>Resultados para <em>"{{ $q }}"</em> con filtros</h1>
        @elseif($q !== '')
            <h1>Resultados para <em>"{{ $q }}"</em></h1>
        @elseif((count($ingredients) + count($foodTypes) + count($diets)) > 0)
            <h1>Recetas filtradas</h1>
        @else
            <h1>Todas las recetas</h1>
        @endif

        <p class="results-count">{{ $recipes->count() }} {{ $recipes->count() === 1 ? 'receta encontrada' : 'recetas encontradas' }}</p>
    </div>

    {{-- Grid de resultados --}}
    <div class="recetas-grid">

        @forelse($recipes as $recipe)
            <div class="receta-tarjeta" data-id="{{ $recipe->id }}">

                <div class="receta-image">
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                    <div class="overlay"><span>VER</span></div>
                </div>

                <h3>{{ $recipe->title }}</h3>

                <div class="receta-actions">
                    <div class="card-author">
                        <a href="/users/{{ $recipe->user_id }}" onclick="event.stopPropagation()">
                            @if($recipe->user?->avatar)
                                <img src="{{ asset('storage/' . $recipe->user->avatar) }}" class="card-author-avatar" alt="{{ $recipe->user->name }}">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                            <span>{{ $recipe->user?->name }}</span>
                        </a>
                    </div>
                    <div class="likes1">
                        <i class="bi bi-heart-fill"></i>
                        <span class="likes" id="likes-{{ $recipe->id }}">{{ $recipe->likes->count() }}</span>
                    </div>
                </div>

            </div>
        @empty
            <p class="no-recetas">No se han encontrado recetas con los criterios indicados.</p>
        @endforelse

    </div>

    {{-- Modal --}}
    <div id="recipe-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <button class="modal-close"></button>
            <div id="modal-body"></div>
        </div>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const modal     = document.getElementById('recipe-modal');
        const modalBody = document.getElementById('modal-body');
        const closeBtn  = document.querySelector('.modal-close');

        closeBtn.addEventListener('click', cerrarModal);
        modal.addEventListener('click', e => { if (e.target === modal) cerrarModal(); });

        function cerrarModal() {
            modal.classList.remove('show');
            modal.querySelector('.modal-content').classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                modalBody.innerHTML = '';
            }, 250);
        }

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

        window.addEventListener('openRecipeModal', e => abrirModal(e.detail.id));

        document.querySelectorAll('.receta-tarjeta').forEach(card => {
            card.addEventListener('click', () => abrirModal(card.dataset.id));
        });

    });

    window.toggleLikeModal = function (recipeId) {
        @auth
        fetch(`/recipes/${recipeId}/like`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(res => res.json())
        .then(data => {
            const modalCount = document.getElementById(`modal-likes-count-${recipeId}`);
            if (modalCount) modalCount.innerText = data.count;

            const cardLikes = document.getElementById(`likes-${recipeId}`);
            if (cardLikes) cardLikes.innerHTML = data.count;

            const btn = document.getElementById(`modal-like-btn-${recipeId}`);
            if (btn) {
                btn.innerHTML = data.liked
                    ? `<i class="bi bi-heart-fill" style="color:red;"></i>`
                    : `<i class="bi bi-heart"></i>`;
            }
        });
        @else
        window.location.href = '/login';
        @endauth
    }
</script>

@endsection
