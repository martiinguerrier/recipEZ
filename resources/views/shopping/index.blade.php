@extends('layouts.clean')

@section('title', 'RecipEZ – Lista de la compra')

@section('content')
<main class="profile-container shopping-container">

    <h1><i class="bi bi-cart4"></i> Lista de la compra</h1>

    {{-- Mensaje de estado --}}
    @if (session('status'))
        <div class="shopping-status">{{ session('status') }}</div>
    @endif

    @if ($items->isEmpty())
        <p class="shopping-empty">Tu lista está vacía. Añade ingredientes desde el modal de cualquier receta.</p>
    @else
        {{-- Acciones globales --}}
        <div class="shopping-actions">
            {{-- Enviar por email --}}
            <form action="{{ route('shopping.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn-shopping-send">
                    <i class="bi bi-envelope"></i> Pedir lista de la compra
                </button>
            </form>

            {{-- Vaciar lista --}}
            <form action="{{ route('shopping.clear') }}" method="POST"
                  onsubmit="return confirm('¿Vaciar toda la lista?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-shopping-clear">
                    <i class="bi bi-trash3"></i> Vaciar lista
                </button>
            </form>
        </div>

        {{-- Ítems --}}
        <ul class="shopping-list">
            @foreach ($items as $item)
                <li class="shopping-item">
                    <span class="shopping-item-name">{{ $item->ingredient->name }}</span>

                    <form action="{{ route('shopping.remove', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="shopping-remove-btn" title="Eliminar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

</main>

<style>
.shopping-container {
    max-width: 860px;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    padding: 0 20px;
    box-sizing: border-box;
    align-items: stretch;   /* anula el align-items:center heredado de main */
}

.shopping-container h1 {
    font-size: 2rem;
    color: #222;
    margin-bottom: 24px;
    text-align: center;
}

.shopping-status {
    background: #d4f8d4;
    color: #1b7a1b;
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 22px;
    text-align: center;
    font-weight: 600;
}

.shopping-empty {
    text-align: center;
    color: #999;
    font-size: 15px;
    margin-top: 40px;
}

/* ── Acciones ── */
.shopping-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 28px;
    width: 100%;
}

.btn-shopping-send {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ff8800;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 20px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    font-family: inherit;
}
.btn-shopping-send:hover { background: #e07500; }

.btn-shopping-clear {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    color: #e74c3c;
    border: 1.5px solid #e74c3c;
    border-radius: 10px;
    padding: 11px 20px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    font-family: inherit;
}
.btn-shopping-clear:hover { background: #e74c3c; color: #fff; }

/* ── Lista ── */
.shopping-list {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.shopping-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border: 1.5px solid #ffd4b0;
    border-radius: 12px;
    padding: 13px 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    transition: box-shadow 0.15s;
}
.shopping-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }

.shopping-item-name {
    font-size: 15px;
    color: #b34700;
    font-weight: 600;
}

.shopping-remove-btn {
    background: transparent;
    border: none;
    color: #ccc;
    font-size: 14px;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 6px;
    transition: color 0.15s, background 0.15s;
    display: flex;
    align-items: center;
}
.shopping-remove-btn:hover { color: #e74c3c; background: #ffeaea; }

/* ── Responsive ── */
@media (max-width: 520px) {
    .shopping-list {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .shopping-container h1 { font-size: 1.5rem; }
    .shopping-actions { flex-direction: column; }
    .btn-shopping-send,
    .btn-shopping-clear { width: 100%; justify-content: center; }
}
</style>

@endsection
