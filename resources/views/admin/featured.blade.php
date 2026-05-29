@extends('layouts.clean')

@section('title', 'Admin - Recetas Destacadas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<main class="admin-catalog-container">

    <a href="{{ route('home') }}" class="back-btn">← Volver</a>

    <h1><i class="bi bi-star-fill"></i> Recetas Destacadas</h1>

    @if(session('success'))
        <div class="admin-flash success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <p class="featured-hint">
        Las recetas marcadas con <i class="bi bi-star-fill" style="color:#ff8800"></i> aparecen en la página de inicio.
        Actualmente hay <strong>{{ $allRecipes->where('is_featured', true)->count() }}</strong> destacadas.
    </p>

    <input class="buscador" type="text" placeholder="Buscar receta..." oninput="filterFeatured(this)" style="max-width:360px; margin-bottom:16px;">

    <div class="featured-list" id="featured-list">
        @forelse($allRecipes as $recipe)
            <div class="featured-item" data-title="{{ strtolower($recipe->title) }}">

                <div class="featured-item-info">
                    @if($recipe->image)
                        <img src="{{ \Storage::url($recipe->image) }}" class="featured-thumb" alt="{{ $recipe->title }}">
                    @else
                        <div class="featured-thumb featured-thumb-placeholder"><i class="bi bi-image"></i></div>
                    @endif
                    <div>
                        <span class="featured-title">{{ $recipe->title }}</span>
                        <span class="featured-author">
                            por {{ $recipe->user?->name ?? '—' }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-heart-fill" style="color:#e74c3c; font-size:11px;"></i>
                            {{ $recipe->likes_count }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('admin.recipes.feature', $recipe) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn-feature {{ $recipe->is_featured ? 'active' : '' }}"
                        title="{{ $recipe->is_featured ? 'Quitar de destacadas' : 'Añadir a destacadas' }}">
                        <i class="bi {{ $recipe->is_featured ? 'bi-star-fill' : 'bi-star' }}"></i>
                        {{ $recipe->is_featured ? 'Destacada' : 'Destacar' }}
                    </button>
                </form>

            </div>
        @empty
            <p class="catalog-empty">No hay recetas todavía.</p>
        @endforelse
    </div>

</main>

<script>
(function () {
    window.filterFeatured = function(input) {
        const term = input.value.toLowerCase();
        document.querySelectorAll('#featured-list .featured-item').forEach(item => {
            item.style.display = item.dataset.title.includes(term) ? '' : 'none';
        });
    };
})();
</script>

@endsection
