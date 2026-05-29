@extends('layouts.clean')

@section('title', 'Configuración de Cookies - RecipEZ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/legal.css') }}">
@endpush

@section('content')
<main class="legal-container">

    <h1>Configuración de Cookies</h1>

    <p>Desde aquí puedes gestionar qué tipos de cookies acepta RecipEZ en tu dispositivo. Las cookies estrictamente necesarias no pueden desactivarse ya que son imprescindibles para el funcionamiento de la plataforma.</p>

    <section class="cookie-settings">

        <div class="cookie-option">
            <div class="cookie-option-info">
                <h2>Cookies estrictamente necesarias</h2>
                <p>Permiten el funcionamiento básico de la web: inicio de sesión, seguridad y navegación. No se pueden desactivar.</p>
            </div>
            <div class="cookie-toggle">
                <span class="toggle-always-on">Siempre activas</span>
            </div>
        </div>

        <div class="cookie-option">
            <div class="cookie-option-info">
                <h2>Cookies de preferencias</h2>
                <p>Guardan ajustes como el idioma o la región para personalizar tu experiencia.</p>
            </div>
            <div class="cookie-toggle">
                <label class="switch">
                    <input type="checkbox" id="pref-cookies" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="cookie-option">
            <div class="cookie-option-info">
                <h2>Cookies analíticas</h2>
                <p>Nos ayudan a entender cómo se utiliza la plataforma para mejorar el servicio. Los datos son anónimos.</p>
            </div>
            <div class="cookie-toggle">
                <label class="switch">
                    <input type="checkbox" id="analytics-cookies" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

    </section>

    <button class="btn-save-cookies" onclick="saveCookieSettings()">Guardar preferencias</button>

    <p style="margin-top:1.5rem; font-size:.9rem; color:#888">Para más información consulta nuestro <a href="{{ route('legal.cookies') }}">Aviso de Cookies</a>.</p>

</main>

<script>
    function saveCookieSettings() {
        const prefs = document.getElementById('pref-cookies').checked;
        const analytics = document.getElementById('analytics-cookies').checked;
        localStorage.setItem('cookies_preferences', prefs);
        localStorage.setItem('cookies_analytics', analytics);
        const btn = document.querySelector('.btn-save-cookies');
        btn.textContent = '✓ Preferencias guardadas';
        btn.style.background = '#4caf50';
        setTimeout(() => {
            btn.textContent = 'Guardar preferencias';
            btn.style.background = '';
        }, 2500);
    }

    // Cargar preferencias guardadas
    window.addEventListener('DOMContentLoaded', () => {
        const prefs = localStorage.getItem('cookies_preferences');
        const analytics = localStorage.getItem('cookies_analytics');
        if (prefs !== null) document.getElementById('pref-cookies').checked = prefs === 'true';
        if (analytics !== null) document.getElementById('analytics-cookies').checked = analytics === 'true';
    });
</script>
@endsection
