<div id="inicio"></div>
<header class="navbar">
    <div class="nav-left">
        <a href="/"><img src="{{ asset('img/Título RecipEZ.webp') }}" alt="RecipEZ" class="logo"></a>
        <div class="rrss">
            <i class="bi-instagram"></i>
            <i class="bi-facebook"></i>
            <i class="bi-tiktok"></i>
            <i class="bi-youtube"></i>
        </div>
    </div>

    <div class="nav-center">
        <div class="search-wrapper">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Buscar recetas, usuarios . . ." class="search-input" autocomplete="off">
                <i class="bi bi-search"></i>
                <button class="filter-btn"><b>☰</b></button>
            </div>
            <div id="search-dropdown" class="search-dropdown" style="display:none;"></div>
        </div>
    </div>

    <div class="nav-right">

        @auth
            <div class="profile-icon">
                <a href="{{ route('profile.recipes') }}">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-small">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                </a>
            </div>

            <a href="{{ route('profile.recipes') }}"><span>{{ auth()->user()->name }}</span></a>

            <a href="{{ route('profile.edit') }}" class="btn-secondary">AJUSTES DE PERFIL</a>
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
    const input    = document.getElementById('search-input');
    const dropdown = document.getElementById('search-dropdown');
    let timer;

    input.addEventListener('input', () => {
        clearTimeout(timer);
        const q = input.value.trim();

        if (q.length < 2) {
            dropdown.style.display = 'none';
            dropdown.innerHTML = '';
            return;
        }

        timer = setTimeout(() => {
            fetch(`/search?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => renderDropdown(data));
        }, 300);
    });

    function renderDropdown(data) {
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
                html += `
                <div class="search-item" data-type="recipe" data-id="${r.id}">
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
                html += `
                <div class="search-item" data-type="user" data-id="${u.id}">
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

        // Clic en receta → custom event para que la página abra el modal
        dropdown.querySelectorAll('.search-item[data-type="recipe"]').forEach(el => {
            el.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('openRecipeModal', { detail: { id: el.dataset.id } }));
                cerrarDropdown();
            });
        });

        // Clic en usuario → navegar a su perfil público
        dropdown.querySelectorAll('.search-item[data-type="user"]').forEach(el => {
            el.addEventListener('click', () => {
                window.location.href = `/users/${el.dataset.id}`;
            });
        });
    }

    function cerrarDropdown() {
        dropdown.style.display = 'none';
        dropdown.innerHTML = '';
        input.value = '';
    }

    // Cerrar al hacer clic fuera
    document.addEventListener('click', e => {
        if (!e.target.closest('.search-wrapper')) {
            dropdown.style.display = 'none';
        }
    });
})();
</script>