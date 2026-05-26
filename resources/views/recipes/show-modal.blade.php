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

            {{-- Tags: tipo de comida + dietas --}}
            @if($recipe->foodType->count() || $recipe->diets->count())
            <div class="modal-tags">
                @foreach($recipe->foodType as $ft)
                    <span class="modal-tag modal-tag-food">{{ $ft->name }}</span>
                @endforeach
                @foreach($recipe->diets as $diet)
                    <span class="modal-tag modal-tag-diet">{{ $diet->name }}</span>
                @endforeach
            </div>
            @endif

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

        {{-- Footer: like + guardar --}}
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

            @auth
            <span id="modal-save-btn-{{ $recipe->id }}" class="modal-save-icon"
                onclick="toggleSaveModal({{ $recipe->id }})">
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
