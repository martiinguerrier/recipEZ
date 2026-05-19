@extends('layouts.clean')

@section('title', 'RecipEZ - ' . $user->name)

@section('content')

<main class="profile-container">

    {{-- Cabecera del perfil --}}
    <div class="public-profile-header">
        <div class="public-profile-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="public-avatar-img">
            @else
                <i class="bi bi-person-circle"></i>
            @endif
        </div>
        <h1 class="public-profile-name">{{ $user->name }}</h1>
        <p class="public-profile-count">{{ $recipes->count() }} {{ $recipes->count() === 1 ? 'receta' : 'recetas' }}</p>
    </div>

    {{-- Grid de recetas --}}
    <div class="recetas-grid">

        @forelse($recipes as $recipe)
            <div class="receta-tarjeta" data-id="{{ $recipe->id }}">

                <div class="receta-image">
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                    <div class="overlay"><span>VER</span></div>
                </div>

                <h3>{{ $recipe->title }}</h3>

                <div class="receta-actions">
                    <div class="likes1">
                        <i class="bi bi-heart-fill"></i>
                        <div class="likes" id="likes-{{ $recipe->id }}">
                            {{ $recipe->likes->count() }}
                        </div>
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

    window.toggleLikeModal = function (recipeId) {
        @auth
        fetch(`/recipes/${recipeId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
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
                    ? `<i class="bi bi-heart-fill" style="color: red;"></i>`
                    : `<i class="bi bi-heart"></i>`;
            }
        });
        @else
        window.location.href = '/login';
        @endauth
    }
</script>

@endsection
