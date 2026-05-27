@extends('layouts.clean')

@section('title', 'Admin - Gestión de Catálogo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<main class="admin-catalog-container">

    <a href="{{ route('home') }}" class="back-btn">← Volver</a>

    <h1><i class="bi bi-shield-fill-check"></i> Gestión de Catálogo</h1>

    @if(session('success'))
        <div class="admin-flash success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="admin-flash error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="catalog-selects">

        {{-- ── INGREDIENTES ─────────────────────────────── --}}
        <div class="form-group">
            <label>
                <i class="bi bi-basket2" style="color:#ff8800"></i>
                Ingredientes
                <span class="label-badge">{{ $ingredients->count() }}</span>
            </label>

            <input class="buscador" type="text" placeholder="Buscar ingrediente..."
                   oninput="filterList(this, 'list-ingredients')">

            <div class="options-list" id="list-ingredients">
                @forelse($ingredients as $item)
                    <div class="catalog-item-wrapper">
                        <div class="option-item">
                            <span>{{ $item->name }}</span>
                            <form action="{{ route('admin.catalog.destroy', ['ingredients', $item->id]) }}"
                                  method="POST" style="display:contents;"
                                  onsubmit="return confirm('¿Eliminar «{{ $item->name }}»?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm del" title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="catalog-empty">No hay ingredientes todavía.</p>
                @endforelse
            </div>

            <form action="{{ route('admin.catalog.store', 'ingredients') }}" method="POST" class="add-item-form">
                @csrf
                <input type="text" name="name" placeholder="Nuevo ingrediente..." maxlength="100" autocomplete="off">
                <button type="submit" class="btn-add-item">
                    <i class="bi bi-plus-lg"></i> Añadir
                </button>
            </form>
        </div>

        {{-- ── TIPOS DE COMIDA ───────────────────────────── --}}
        <div class="form-group">
            <label>
                <i class="bi bi-egg-fried" style="color:#ff8800"></i>
                Tipos de comida
                <span class="label-badge">{{ $foodTypes->count() }}</span>
            </label>

            <input class="buscador" type="text" placeholder="Buscar tipo de comida..."
                   oninput="filterList(this, 'list-foodtypes')">

            <div class="options-list" id="list-foodtypes">
                @forelse($foodTypes as $item)
                    <div class="catalog-item-wrapper">
                        <div class="option-item">
                            <span>{{ $item->name }}</span>
                            <form action="{{ route('admin.catalog.destroy', ['food_types', $item->id]) }}"
                                  method="POST" style="display:contents;"
                                  onsubmit="return confirm('¿Eliminar «{{ $item->name }}»?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm del" title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="catalog-empty">No hay tipos de comida todavía.</p>
                @endforelse
            </div>

            <form action="{{ route('admin.catalog.store', 'food_types') }}" method="POST" class="add-item-form">
                @csrf
                <input type="text" name="name" placeholder="Nuevo tipo de comida..." maxlength="100" autocomplete="off">
                <button type="submit" class="btn-add-item">
                    <i class="bi bi-plus-lg"></i> Añadir
                </button>
            </form>
        </div>

        {{-- ── DIETAS ────────────────────────────────────── --}}
        <div class="form-group">
            <label>
                <i class="bi bi-heart-pulse" style="color:#ff8800"></i>
                Dietas
                <span class="label-badge">{{ $diets->count() }}</span>
            </label>

            <input class="buscador" type="text" placeholder="Buscar dieta..."
                   oninput="filterList(this, 'list-diets')">

            <div class="options-list" id="list-diets">
                @forelse($diets as $item)
                    <div class="catalog-item-wrapper">
                        <div class="option-item">
                            <span>{{ $item->name }}</span>
                            <form action="{{ route('admin.catalog.destroy', ['diets', $item->id]) }}"
                                  method="POST" style="display:contents;"
                                  onsubmit="return confirm('¿Eliminar «{{ $item->name }}»?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm del" title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="catalog-empty">No hay dietas todavía.</p>
                @endforelse
            </div>

            <form action="{{ route('admin.catalog.store', 'diets') }}" method="POST" class="add-item-form">
                @csrf
                <input type="text" name="name" placeholder="Nueva dieta..." maxlength="100" autocomplete="off">
                <button type="submit" class="btn-add-item">
                    <i class="bi bi-plus-lg"></i> Añadir
                </button>
            </form>
        </div>

    </div>

</main>

<script>
(function () {
    function filterList(input, listId) {
        const term = input.value.toLowerCase();
        document.querySelectorAll('#' + listId + ' .catalog-item-wrapper').forEach(wrapper => {
            const text = wrapper.querySelector('.option-item span').textContent.toLowerCase();
            wrapper.style.display = text.includes(term) ? '' : 'none';
        });
    }

    window.filterList = filterList;
})();
</script>

@endsection
