@extends('layouts.clean')

@section('title', 'Editar receta')

@section('content')

<main class="create-recipe-container">

    {{-- Botón volver --}}
    <a href="{{ route('profile.recipes') }}" class="back-btn">← Volver</a>

    <h1>Editar receta</h1>

    <form action="{{ route('recipes.update', $recipe->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="create-form">

        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="form-group">
            <label for="title">Título de la receta *</label>
            <input type="text" id="title" name="title" 
                   value="{{ old('title', $recipe->title) }}" required>
        </div>

        {{-- Imagen --}}
        <div class="form-group">
            <label for="image">Imagen (opcional)</label>
            <input type="file" id="image" name="image" accept="image/*">

            @if($recipe->image)
                <p style="margin-top:10px;">Imagen actual:</p>
                <img src="{{ asset('storage/' . $recipe->image) }}" 
                     style="width:150px; border-radius:10px;">
            @endif
        </div>

        {{-- Preparación --}}
        <div class="form-group">
            <label for="description">Preparación *</label>
            <textarea id="description" name="description" rows="6" required>{{ old('description', $recipe->description) }}</textarea>
        </div>

        <div class="selects">

            {{-- INGREDIENTES --}}
            <div class="form-group" id="select">
                <label>Ingredientes (mínimo 2) *</label>
                <input class="buscador" type="text" id="ingredients-search" placeholder="Buscar ingrediente...">

                <div class="options-list" id="ingredients-list">
                    @foreach($ingredients as $ingredient)
                        <label class="option-item">
                            <span>{{ $ingredient->name }}</span>
                            <input type="checkbox" 
                                   name="ingredients[]" 
                                   value="{{ $ingredient->id }}"
                                   {{ $recipe->ingredients->contains($ingredient->id) ? 'checked' : '' }}>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- TIPOS DE COMIDA --}}
            <div class="form-group" id="select">
                <label>Tipo de comida (máximo 3) *</label>
                <input class="buscador" type="text" id="foodtypes-search" placeholder="Buscar tipo de comida...">

                <div class="options-list" id="foodtypes-list">
                    @foreach($foodTypes as $type)
                        <label class="option-item">
                            <span>{{ $type->name }}</span>
                            <input type="checkbox" 
                                   name="food_type_id[]" 
                                   value="{{ $type->id }}"
                                   {{ $recipe->foodType->contains($type->id) ? 'checked' : '' }}>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- DIETAS --}}
            <div class="form-group" id="select">
                <label>Dietas (opcional)</label>
                <input class="buscador" type="text" id="diets-search" placeholder="Buscar dieta...">

                <div class="options-list" id="diets-list">
                    @foreach($diets as $diet)
                        <label class="option-item">
                            <span>{{ $diet->name }}</span>
                            <input type="checkbox" 
                                   name="diets[]" 
                                   value="{{ $diet->id }}"
                                   {{ $recipe->diets->contains($diet->id) ? 'checked' : '' }}>
                        </label>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Botón guardar --}}
        <button type="submit" class="btn-primary">Guardar cambios</button>

    </form>

</main>

{{-- Scripts idénticos al create --}}
<script>
    function attachSearch(inputId, listId) {
        const input = document.getElementById(inputId);
        const list = document.getElementById(listId);

        if (!input || !list) return;

        input.addEventListener('input', () => {
            const term = input.value.toLowerCase();
            const items = list.querySelectorAll('.option-item');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }

    attachSearch('ingredients-search', 'ingredients-list');
    attachSearch('foodtypes-search', 'foodtypes-list');
    attachSearch('diets-search', 'diets-list');

    // Límite máximo 3 tipos de comida
    const foodTypeCheckboxes = document.querySelectorAll('#foodtypes-list input[type="checkbox"]');
    foodTypeCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const checked = Array.from(foodTypeCheckboxes).filter(c => c.checked);
            if (checked.length > 3) {
                cb.checked = false;
                alert('Solo puedes seleccionar hasta 3 tipos de comida.');
            }
        });
    });

    // Validación mínima 2 ingredientes
    const form = document.querySelector('.create-form');
    const ingredientCheckboxes = document.querySelectorAll('#ingredients-list input[type="checkbox"]');

    form.addEventListener('submit', (e) => {
        const checkedIngredients = Array.from(ingredientCheckboxes).filter(c => c.checked);
        if (checkedIngredients.length < 2) {
            e.preventDefault();
            alert('Selecciona al menos 2 ingredientes.');
        }
    });
</script>

@endsection
