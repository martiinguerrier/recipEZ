<footer>
        <div class="footer-container">
            <div class="footer-top">
                <div><img class="logoBlanco" src="{{ asset('img/logoBlanco.webp') }}" alt="RecipEZ"></div>
                <div class="volver"><a href="#inicio"><button class="volver-btn"><b>VOLVER ARRIBA</b></button></a></div>
            </div>
            <div class="footer-mid">
                <div>
                    <h3>Navegación</h3>
                    <ul>
                        <li><a href="/">Inicio</a></li>
                        <li><a href="{{ route('profile.recipes') }}">Perfil</a></li>
                        <li><a href="{{ route('profile.edit') }}">Gestión de cuenta</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                                @csrf
                                <button type="submit" style="background:none; border:none; cursor:pointer; padding:0; color:inherit; font:inherit;">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3>Redes Sociales</h3>
                    <ul>
                        <li><a href="https://www.instagram.com/recipez.es/" target="_blank" rel="noopener">Instagram</a></li>
                        <li><a href="https://www.facebook.com/profile.php?id=61590708171380" target="_blank" rel="noopener">Facebook</a></li>
                        <li><a href="https://www.tiktok.com/@recipez.es?lang=es" target="_blank" rel="noopener">Tik Tok</a></li>
                        <li><a href="https://www.youtube.com/@RecipEZ-ComparteyDescubreRecet" target="_blank" rel="noopener">YouTube</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Información Legal</h3>
                    <ul>
                        <li><a href="{{ route('legal.condiciones') }}">Condiciones de uso</a></li>
                        <li><a href="{{ route('legal.cookies') }}">Aviso de cookies</a></li>
                        <li><a href="{{ route('legal.configuracion-cookies') }}">Configuración de cookies</a></li>
                        <li><a href="{{ route('legal.accesibilidad') }}">Declaración de Accesibilidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy 2026 RecipEZ - Todos los derechos reservados</span>
            </div>
        </div>
    </footer>