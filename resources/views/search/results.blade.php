@extends('layouts.clean')

@section('title', 'RecipEZ - Resultados')

@section('content')

<main class="profile-container">

    {{-- Cabecera de resultados --}}
    <div class="results-header">
        @if(str_starts_with($q, '@'))
            <h1>Usuarios para <em>"{{ $q }}"</em></h1>
            <p class="results-count">{{ $users->count() }} {{ $users->count() === 1 ? 'usuario encontrado' : 'usuarios encontrados' }}</p>
        @else
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
        @endif
    </div>

    {{-- Grid de usuarios --}}
    @if(str_starts_with($q, '@'))
        <div class="recetas-grid">
            @forelse($users as $user)
                <a href="/users/{{ $user->id }}" class="receta-tarjeta user-card">
                    <div class="receta-image">
                        @if($user->avatar)
                            <img src="{{ \Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <div class="user-avatar-placeholder"><i class="bi bi-person-circle"></i></div>
                        @endif
                        <div class="overlay"><span>VER</span></div>
                    </div>
                    <h3>{{ $user->name }}</h3>
                </a>
            @empty
                <p class="no-recetas">No se han encontrado usuarios con ese nombre.</p>
            @endforelse
        </div>

    {{-- Grid de recetas --}}
    @else
        <div class="recetas-grid">
            @forelse($recipes as $recipe)
                <div class="receta-tarjeta" data-id="{{ $recipe->id }}">

                    <div class="receta-image">
                        <img src="{{ \Storage::url($recipe->image) }}" alt="{{ $recipe->title }}">
                        <div class="overlay"><span>VER</span></div>
                    </div>

                    <h3>{{ $recipe->title }}</h3>

                    <div class="receta-actions">
                        <div class="card-author">
                            <a href="/users/{{ $recipe->user_id }}" onclick="event.stopPropagation()">
                                @if($recipe->user?->avatar)
                                    <img src="{{ \Storage::url($recipe->user->avatar) }}" class="card-author-avatar" alt="{{ $recipe->user->name }}">
                                @else
                                    <i class="bi bi-person-circle"></i>
                                @endif
                                <span>{{ $recipe->user?->name }}</span>
                            </a>
                        </div>
                        <div class="card-right-actions">
                            <div class="likes1">
                                <span id="card-like-{{ $recipe->id }}" class="card-like-btn"
                                      onclick="event.stopPropagation(); toggleLike({{ $recipe->id }})">
                                    @auth
                                        @if($recipe->likedBy(auth()->user()))
                                            <i class="bi bi-heart-fill" style="color:red;"></i>
                                        @else
                                            <i class="bi bi-heart"></i>
                                        @endif
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endauth
                                </span>
                                <span class="likes" id="likes-{{ $recipe->id }}">{{ $recipe->likes->count() }}</span>
                            </div>
                            @auth
                            <span id="card-save-{{ $recipe->id }}" class="card-save-btn"
                                  onclick="event.stopPropagation(); toggleSave({{ $recipe->id }})">
                                @if($recipe->savedBy(auth()->user()))
                                    <i class="bi bi-bookmark-fill" style="color:#ff8800;"></i>
                                @else
                                    <i class="bi bi-bookmark"></i>
                                @endif
                            </span>
                            @endauth
                        </div>
                    </div>

                </div>
            @empty
                <p class="no-recetas">No se han encontrado recetas con los criterios indicados.</p>
            @endforelse
        </div>
    @endif

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

    window.toggleSave = function(recipeId) {
        @auth
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
        @else
        window.location.href = '/login';
        @endauth
    }
    window.toggleSaveModal = window.toggleSave;

    window.toggleLike = function(recipeId) {
        @auth
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
        @else
        window.location.href = '/login';
        @endauth
    }
    window.toggleLikeModal = window.toggleLike;
</script>

@endsection
