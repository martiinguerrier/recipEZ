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
        <div class="search-container">
            <input type="text" placeholder="Buscar recetas, ingredientes, usuarios . . ." class="search-input">
            <i class="bi bi-search"></i>
            <button class="filter-btn"><b>☰</b></button>
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