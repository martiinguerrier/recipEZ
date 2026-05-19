<div class="modal-recipe-layout">

    {{-- Imagen a la izquierda --}}
    <div class="modal-left">
        @if($recipe->image)
            <img class="modal-image" src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
        @endif
    </div>

    {{-- Contenido a la derecha --}}
    <div class="modal-right">

        <div class="modal-top-right">
            <h2 class="modal-title">{{ $recipe->title }}</h2>
            <div class="likes1">
                <span id="modal-like-btn-{{ $recipe->id }}" class="modal-like-icon"
                    onclick="toggleLikeModal({{ $recipe->id }})">
                    @if(auth()->check() && $recipe->likedBy(auth()->user()))
                        <i class="bi bi-heart-fill"></i>
                    @else
                        <i class="bi bi-heart"></i>
                    @endif
                </span>

                <span id="modal-likes-count-{{ $recipe->id }}" class="modal-likes-count">
                    {{ $recipe->likes->count() }}
                </span>
            </div>
        </div>


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

</div>