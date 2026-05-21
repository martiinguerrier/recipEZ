<div class="modal-recipe-layout">

    {{-- Imagen a la izquierda --}}
    <div class="modal-left">
        @if($recipe->image)
            <img class="modal-image" src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
        @endif
    </div>

    {{-- Contenido a la derecha --}}
    <div class="modal-right-wrapper">

        <div class="modal-right">

            {{-- Autor --}}
            <a href="/users/{{ $recipe->user_id }}" class="modal-author">
                @if($recipe->user?->avatar)
                    <img src="{{ asset('storage/' . $recipe->user->avatar) }}" class="modal-author-avatar" alt="{{ $recipe->user->name }}">
                @else
                    <i class="bi bi-person-circle modal-author-icon"></i>
                @endif
                <span>{{ $recipe->user?->name }}</span>
            </a>

            <h2 class="modal-title">{{ $recipe->title }}</h2>

            {{-- Ingredientes --}}
            <div class="modal-section">
                <h3>Ingredientes</h3>
                <ul class="modal-ingredients">
                    @foreach($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->name }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Preparación --}}
            <div class="modal-section">
                <h3>Preparación</h3>
                <p class="modal-description">{!! nl2br(e($recipe->description)) !!}</p>
            </div>

        </div>

        {{-- Like button al fondo --}}
        <div class="modal-footer">
            <span id="modal-like-btn-{{ $recipe->id }}" class="modal-like-icon"
                onclick="toggleLikeModal({{ $recipe->id }})">
                @if(auth()->check() && $recipe->likedBy(auth()->user()))
                    <i class="bi bi-heart-fill" style="color:red;"></i>
                @else
                    <i class="bi bi-heart"></i>
                @endif
            </span>
            <span id="modal-likes-count-{{ $recipe->id }}" class="modal-likes-count">
                {{ $recipe->likes->count() }}
            </span>
        </div>

    </div>

</div>
