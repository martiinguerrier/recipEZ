<div class="modal-recipe-layout">

    {{-- Imagen a la izquierda --}}
    <div class="modal-left">
        @if($recipe->image)
            <img class="modal-image" src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
        @endif
    </div>

    {{-- Contenido a la derecha --}}
    <div class="modal-right">

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

</div>