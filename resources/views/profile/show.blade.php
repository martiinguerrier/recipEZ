@extends('layouts.clean')

@section('title', 'RecipEZ - ' . $user->name)

@section('content')

<main class="profile-container">

    {{-- Cabecera del perfil --}}
    <div class="public-profile-header">
        <div class="public-profile-avatar">
            @if($user->avatar)
                <img src="{{ \Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="public-avatar-img">
            @else
                <i class="bi bi-person-circle"></i>
            @endif
        </div>
        <h1 class="public-profile-name">{{ $user->name }}</h1>

        <div class="public-profile-stats">
            <span><strong>{{ $recipes->count() }}</strong> {{ $recipes->count() === 1 ? 'receta' : 'recetas' }}</span>
            <span><strong>{{ $user->followers()->count() }}</strong> seguidores</span>
            <span><strong>{{ $user->following()->count() }}</strong> siguiendo</span>
        </div>

        @auth
            <form method="POST" action="{{ route('users.follow', $user) }}" style="margin-top:.75rem">
                @csrf
                @if(auth()->user()->isFollowing($user))
                    <button class="btn-follow following">
                        <i class="bi bi-person-check-fill"></i> Siguiendo
                    </button>
                @else
                    <button class="btn-follow">
                        <i class="bi bi-person-plus"></i> Seguir
                    </button>
                @endif
            </form>
        @endauth
    </div>

    {{-- Grid de recetas --}}
    <div class="recetas-grid">

        @forelse($recipes as $recipe)
            <div class="receta-tarjeta" data-id="{{ $recipe->id }}">

                <div class="receta-image">
                    <img src="{{ \Storage::url($recipe->image) }}" alt="{{ $recipe->title }}">
                    <div class="overlay"><span>VER</span></div>
                </div>

                <h3>{{ $recipe->title }}</h3>

                <div class="receta-actions">
                    @if(auth()->user()?->isAdmin())
                    <div class="delEdit">
                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn-small"
                           onclick="event.stopPropagation()">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST"
                              onclick="event.stopPropagation()">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger-small"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                    @endif
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
            <p class="no-recetas">Este usuario todavía no ha publicado ninguna receta.</p>
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

        // Abrir modal desde el buscador del navbar
        window.addEventListener('openRecipeModal', e => abrirModal(e.detail.id));

        // Abrir modal al hacer click en una tarjeta
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
