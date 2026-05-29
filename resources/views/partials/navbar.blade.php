@php
    $filterIngredients   = \App\Models\Ingredient::orderBy('name')->get();
    $filterFoodTypes     = \App\Models\FoodType::orderBy('name')->get();
    $filterDiets         = \App\Models\Diet::orderBy('name')->get();
    $selectedIngredients = array_map('strval', (array) request()->input('ingredients', []));
    $selectedFoodTypes   = array_map('strval', (array) request()->input('food_types', []));
    $selectedDiets       = array_map('strval', (array) request()->input('diets', []));
@endphp

<div id="inicio"></div>
<header class="navbar">
    <div class="nav-left">
        <a href="/"><img src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo"></a>
        <div class="rrss">
            <a href="https://www.instagram.com/recipez.es/" target="_blank" rel="noopener"><i class="bi-instagram"></i></a>
            <a href="https://www.facebook.com/profile.php?id=61590708171380" target="_blank" rel="noopener"><i class="bi-facebook"></i></a>
            <a href="https://www.tiktok.com/@recipez.es?lang=es" target="_blank" rel="noopener"><i class="bi-tiktok"></i></a>
            <a href="https://www.youtube.com/@RecipEZ-ComparteyDescubreRecet" target="_blank" rel="noopener"><i class="bi-youtube"></i></a>
        </div>
    </div>

    <div class="nav-center">
        <div class="search-wrapper">

            <form id="search-form" action="/explore" method="GET">
                <div class="search-container">
                    <input type="text" id="search-input" name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar recetas o @usuario . . ."
                        class="search-input" autocomplete="off">

                    {{-- Lupa = ejecuta búsqueda completa --}}
                    <button type="submit" class="search-submit-btn" title="Buscar">
                        <i class="bi bi-search"></i>
                    </button>

                    {{-- Botón de filtros --}}
                    <button type="button" id="filter-toggle-btn" class="filter-btn" title="Filtros">
                        <i class="bi bi-filter"></i>
                        <span id="filter-active-badge" class="filter-active-badge" style="display:none;"></span>
                    </button>
                </div>

                {{-- ── Panel de filtros ─────────────────────────────── --}}
                <div id="filter-panel" class="filter-panel" style="display:none;">

                    {{-- Ingredientes --}}
                    <div class="fp-accordion">
                        <button type="button" class="fp-accordion-header" data-target="fp-ingredients">
                            <span><i class="bi bi-basket2"></i> Ingredientes</span>
                            <span class="fp-badge" id="badge-ingredients" style="display:none;"></span>
                            <i class="bi bi-chevron-down fp-chevron"></i>
                        </button>
                        <div class="fp-accordion-body" id="fp-ingredients" style="display:none;">
                            <input type="text" class="fp-search-input" placeholder="Buscar ingrediente...">
                            <div class="fp-options-list">
                                @foreach($filterIngredients as $item)
                                    <label class="fp-option-item">
                                        <span>{{ $item->name }}</span>
                                        <input type="checkbox" name="ingredients[]" value="{{ $item->id }}"
                                            @checked(in_array((string)$item->id, $selectedIngredients))>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tipo de comida --}}
                    <div class="fp-accordion">
                        <button type="button" class="fp-accordion-header" data-target="fp-foodtypes">
                            <span><i class="bi bi-egg-fried"></i> Tipo de comida</span>
                            <span class="fp-badge" id="badge-foodtypes" style="display:none;"></span>
                            <i class="bi bi-chevron-down fp-chevron"></i>
                        </button>
                        <div class="fp-accordion-body" id="fp-foodtypes" style="display:none;">
                            <input type="text" class="fp-search-input" placeholder="Buscar tipo de comida...">
                            <div class="fp-options-list">
                                @foreach($filterFoodTypes as $item)
                                    <label class="fp-option-item">
                                        <span>{{ $item->name }}</span>
                                        <input type="checkbox" name="food_types[]" value="{{ $item->id }}"
                                            @checked(in_array((string)$item->id, $selectedFoodTypes))>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Dieta --}}
                    <div class="fp-accordion">
                        <button type="button" class="fp-accordion-header" data-target="fp-diets">
                            <span><i class="bi bi-heart-pulse"></i> Dieta</span>
                            <span class="fp-badge" id="badge-diets" style="display:none;"></span>
                            <i class="bi bi-chevron-down fp-chevron"></i>
                        </button>
                        <div class="fp-accordion-body" id="fp-diets" style="display:none;">
                            <input type="text" class="fp-search-input" placeholder="Buscar dieta...">
                            <div class="fp-options-list">
                                @foreach($filterDiets as $item)
                                    <label class="fp-option-item">
                                        <span>{{ $item->name }}</span>
                                        <input type="checkbox" name="diets[]" value="{{ $item->id }}"
                                            @checked(in_array((string)$item->id, $selectedDiets))>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Pie del panel --}}
                    <div class="fp-footer">
                        <button type="button" id="fp-clear-btn" class="fp-clear-btn">Limpiar filtros</button>
                        <button type="submit" class="fp-apply-btn">Buscar <i class="bi bi-search"></i></button>
                    </div>

                </div>{{-- /filter-panel --}}
            </form>

            {{-- Dropdown tiempo real (fuera del form) --}}
            <div id="search-dropdown" class="search-dropdown" style="display:none;"></div>

        </div>
    </div>

    <div class="nav-right">

        @auth
            <div class="nav-right-top" id="user-menu-wrapper">
                <div class="profile-avatar-wrapper">
                    <div class="profile-icon">
                        <a href="{{ route('profile.recipes') }}">
                            @if(auth()->user()->avatar)
                                <img src="{{ \Storage::url(auth()->user()->avatar) }}" class="avatar-small">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        </a>
                        <span class="avatar-username-mobile">Perfil</span>
                    </div>

                    <button class="user-menu-btn" id="user-menu-btn" title="Menú">
                        <b><i class="bi bi-gear"></i></b>
                    </button>
                </div>

                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-label">Mi cuenta</div>
                    <a href="{{ route('profile.edit') }}" class="user-dropdown-item">
                        <i class="bi bi-person"></i> Gestión de cuenta
                    </a>
                    <a href="{{ route('profile.saved') }}" class="user-dropdown-item">
                        <i class="bi bi-bookmark"></i> Recetas guardadas
                    </a>
                    <a href="{{ route('shopping.index') }}" class="user-dropdown-item">
                        <i class="bi bi-cart3"></i> Lista de la compra
                    </a>
                    <form class="user-dropdown-item" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="user-dropdown-item user-dropdown-logout">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>

                    @if(auth()->user()->isAdmin())
                        <div class="user-dropdown-divider"></div>
                        <div class="user-dropdown-label">Administración</div>
                        <a href="{{ route('admin.catalog') }}" class="user-dropdown-item">
                            <i class="bi bi-tags"></i> Gestionar catálogo
                        </a>
                        <a href="{{ route('admin.featured') }}" class="user-dropdown-item">
                            <i class="bi bi-star"></i> Recetas destacadas
                        </a>
                        <a href="{{ route('admin.users') }}" class="user-dropdown-item">
                            <i class="bi bi-people"></i> Gestionar usuarios
                        </a>
                    @endif
                </div>
            </div>

            <a href="{{ route('profile.recipes') }}"><span>{{ auth()->user()->name }}</span></a>
        @endauth

        @guest
            <div class="profile-icon">
                <a href="/login"><i class="bi bi-person-circle"></i></a>
            </div>
            <a href="/login"><span>Sign in/up</span></a>
        @endguest

    </div>

</header>

<script>
(function () {

    // ── Dropdown en tiempo real ──────────────────────────────────────────
    const input    = document.getElementById('search-input');
    const dropdown = document.getElementById('search-dropdown');
    let dropTimer;

    input.addEventListener('input', () => {
        clearTimeout(dropTimer);
        const q = input.value.trim();

        // "@" solo o vacío → cerrar
        if (q.length < 2) { cerrarDropdown(); return; }

        // "@x" necesita al menos 1 carácter tras la arroba
        if (q.startsWith('@') && q.length < 2) { cerrarDropdown(); return; }

        dropTimer = setTimeout(() => {
            fetch(`/search?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => renderDropdown(data));
        }, 300);
    });

    function renderDropdown(data) {
        cerrarFiltros();

        const noResults = data.recipes.length === 0 && data.users.length === 0;
        if (noResults) {
            dropdown.innerHTML = '<div class="search-no-results">Sin resultados</div>';
            dropdown.style.display = 'block';
            return;
        }

        let html = '';

        if (data.recipes.length) {
            html += '<div class="search-section-label">Recetas</div>';
            data.recipes.forEach(r => {
                const img = r.image
                    ? `<img src="${r.image}" class="search-thumb" alt="${r.title}">`
                    : `<div class="search-thumb search-thumb-placeholder"><i class="bi bi-image"></i></div>`;
                html += `<div class="search-item" data-type="recipe" data-id="${r.id}">
                    ${img}
                    <div class="search-info">
                        <span class="search-name">${r.title}</span>
                        <span class="search-sub">Receta</span>
                    </div>
                </div>`;
            });
        }

        if (data.users.length) {
            html += '<div class="search-section-label">Usuarios</div>';
            data.users.forEach(u => {
                const img = u.avatar
                    ? `<img src="${u.avatar}" class="search-thumb search-thumb-round" alt="${u.name}">`
                    : `<div class="search-thumb search-thumb-placeholder search-thumb-round"><i class="bi bi-person"></i></div>`;
                html += `<div class="search-item" data-type="user" data-id="${u.id}">
                    ${img}
                    <div class="search-info">
                        <span class="search-name">${u.name}</span>
                        <span class="search-sub">Usuario</span>
                    </div>
                </div>`;
            });
        }

        dropdown.innerHTML = html;
        dropdown.style.display = 'block';

        dropdown.querySelectorAll('.search-item[data-type="recipe"]').forEach(el => {
            el.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('openRecipeModal', { detail: { id: el.dataset.id } }));
                cerrarDropdown();
            });
        });

        dropdown.querySelectorAll('.search-item[data-type="user"]').forEach(el => {
            el.addEventListener('click', () => {
                window.location.href = `/users/${el.dataset.id}`;
            });
        });
    }

    function cerrarDropdown() {
        dropdown.style.display = 'none';
        dropdown.innerHTML = '';
    }

    // ── Panel de filtros ─────────────────────────────────────────────────
    const filterBtn   = document.getElementById('filter-toggle-btn');
    const filterPanel = document.getElementById('filter-panel');

    filterBtn.addEventListener('click', () => {
        const isOpen = filterPanel.style.display !== 'none';
        if (isOpen) {
            cerrarFiltros();
        } else {
            cerrarDropdown();
            filterPanel.style.display = 'block';
            filterBtn.classList.add('fp-btn-active');
        }
    });

    function cerrarFiltros() {
        filterPanel.style.display = 'none';
        filterBtn.classList.remove('fp-btn-active');
    }

    // Acordeón
    document.querySelectorAll('.fp-accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const body   = document.getElementById(header.dataset.target);
            const isOpen = body.style.display !== 'none';

            // Cerrar todos
            document.querySelectorAll('.fp-accordion-body').forEach(b => b.style.display = 'none');
            document.querySelectorAll('.fp-chevron').forEach(c => c.classList.remove('fp-chevron-open'));

            // Abrir el clicado si estaba cerrado
            if (!isOpen) {
                body.style.display = 'block';
                header.querySelector('.fp-chevron').classList.add('fp-chevron-open');
            }
        });
    });

    // Buscador interno de cada sección
    document.querySelectorAll('.fp-search-input').forEach(si => {
        si.addEventListener('input', () => {
            const term = si.value.toLowerCase();
            si.nextElementSibling.querySelectorAll('.fp-option-item').forEach(item => {
                const text = item.querySelector('span').textContent.toLowerCase();
                item.style.display = text.includes(term) ? '' : 'none';
            });
        });
    });

    // Badges de conteo
    function updateBadges() {
        const sections = [
            { selector: 'input[name="ingredients[]"]:checked', badgeId: 'badge-ingredients' },
            { selector: 'input[name="food_types[]"]:checked',  badgeId: 'badge-foodtypes'   },
            { selector: 'input[name="diets[]"]:checked',       badgeId: 'badge-diets'        },
        ];

        let total = 0;
        sections.forEach(({ selector, badgeId }) => {
            const count = document.querySelectorAll(selector).length;
            const badge = document.getElementById(badgeId);
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-flex' : 'none';
            }
            total += count;
        });

        const activeBadge = document.getElementById('filter-active-badge');
        if (activeBadge) {
            activeBadge.textContent = total;
            activeBadge.style.display = total > 0 ? 'inline-flex' : 'none';
        }
    }

    document.querySelectorAll('#filter-panel input[type="checkbox"]').forEach(cb => {
        cb.addEventListener('change', updateBadges);
    });

    document.getElementById('fp-clear-btn').addEventListener('click', () => {
        document.querySelectorAll('#filter-panel input[type="checkbox"]').forEach(cb => cb.checked = false);
        updateBadges();
    });

    // Inicializar badges (en la página de resultados los checkboxes ya vienen marcados)
    updateBadges();

    // Cerrar al hacer clic fuera del buscador
    document.addEventListener('click', e => {
        if (!e.target.closest('.search-wrapper')) {
            cerrarDropdown();
            cerrarFiltros();
        }
    });

    // ── Menú de usuario ──────────────────────────────────────────────────
    const userMenuBtn  = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDropdown.classList.contains('open');
            userDropdown.classList.toggle('open', !open);
            userMenuBtn.classList.toggle('open', !open);
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('#user-menu-wrapper')) {
                userDropdown.classList.remove('open');
                userMenuBtn.classList.remove('open');
            }
        });
    }

})();

// ── Lista de la compra ───────────────────────────────────────────────────

// Delegación: toggle seleccionado en ingredientes del modal
document.addEventListener('click', e => {
    const item = e.target.closest('.modal-ingredient-item');
    if (!item) return;

    item.classList.toggle('selected');

    // Actualizar estado del botón del carrito
    const modalBody = document.getElementById('modal-body');
    if (!modalBody) return;
    const selected = modalBody.querySelectorAll('.modal-ingredient-item.selected');
    const cartBtn  = modalBody.querySelector('.modal-cart-btn');
    if (!cartBtn || cartBtn.classList.contains('added')) return;

    const label = cartBtn.querySelector('.modal-cart-label');
    if (selected.length === 0) {
        cartBtn.classList.add('modal-cart-btn--empty');
        cartBtn.title = 'Selecciona ingredientes para añadir';
        if (label) label.textContent = 'Selecciona ingredientes';
    } else {
        cartBtn.classList.remove('modal-cart-btn--empty');
        cartBtn.title = `Añadir ${selected.length} ingrediente${selected.length > 1 ? 's' : ''} a la lista`;
        if (label) label.textContent = `Añadir ${selected.length}`;
    }
});

window.addToShoppingList = function (recipeId, btn) {
    if (btn.classList.contains('modal-cart-btn--empty') || btn.classList.contains('added')) return;

    const selected = [...document.querySelectorAll('.modal-ingredient-item.selected')]
        .map(el => el.dataset.id);

    if (selected.length === 0) return;

    btn.disabled = true;

    const body = new FormData();
    selected.forEach(id => body.append('ingredient_ids[]', id));

    fetch(`/shopping-list/recipe/${recipeId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body,
    })
    .then(r => r.json())
    .then(() => {
        btn.classList.add('added');
        btn.innerHTML = '<i class="bi bi-cart-check"></i> <span class="modal-cart-label">¡Añadidos!</span>';
        btn.title = 'Ingredientes añadidos a tu lista';
    })
    .catch(() => {
        btn.disabled = false;
    });
};

// ── Lightbox de imagen completa ───────────────────────────────────────────
window.cerrarLightbox = function () {
    const lb = document.getElementById('lightbox-overlay');
    if (!lb) return;
    lb.classList.remove('lb-show');
    setTimeout(() => { lb.style.display = 'none'; }, 250);
};

window.abrirLightbox = function (src, alt) {
    let lb = document.getElementById('lightbox-overlay');

    if (!lb) {
        lb = document.createElement('div');
        lb.id = 'lightbox-overlay';
        lb.innerHTML = `
            <button class="lb-close" onclick="cerrarLightbox()" title="Cerrar"></button>
            <img class="lb-img" src="" alt="">
        `;
        // Cerrar al clicar el fondo
        lb.addEventListener('click', e => {
            if (e.target === lb) cerrarLightbox();
        });
        // Cerrar con Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && lb.classList.contains('lb-show')) cerrarLightbox();
        });
        document.body.appendChild(lb);
    }

    lb.querySelector('.lb-img').src = src;
    lb.querySelector('.lb-img').alt = alt || '';
    lb.style.display = 'flex';
    // Forzar repaint para que la transición arranque
    requestAnimationFrame(() => requestAnimationFrame(() => lb.classList.add('lb-show')));
};
</script>
