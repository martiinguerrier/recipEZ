@extends('layouts.clean')

@section('title', 'Aviso de Cookies - RecipEZ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/legal.css') }}">
@endpush

@section('content')
<main class="legal-container">

    <h1>Aviso de Cookies</h1>

    <section>
        <h2>¿Qué son las cookies?</h2>
        <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Permiten que el sitio recuerde tus preferencias y mejoren tu experiencia de navegación.</p>
    </section>

    <section>
        <h2>¿Qué cookies utiliza RecipEZ?</h2>

        <h3>Cookies estrictamente necesarias</h3>
        <p>Son imprescindibles para el funcionamiento de la plataforma. Incluyen las cookies de sesión que te mantienen autenticado mientras navegas por RecipEZ. Sin ellas, no sería posible iniciar sesión ni utilizar funciones básicas.</p>

        <h3>Cookies de preferencias</h3>
        <p>Recuerdan tus ajustes y preferencias, como el idioma o la región, para ofrecerte una experiencia más personalizada en futuras visitas.</p>

        <h3>Cookies analíticas</h3>
        <p>Nos ayudan a entender cómo los usuarios interactúan con RecipEZ: qué páginas visitan más, cuánto tiempo permanecen o desde qué dispositivos acceden. Esta información se utiliza de forma agregada y anónima para mejorar el servicio.</p>
    </section>

    <section>
        <h2>¿Cómo gestionar las cookies?</h2>
        <p>Puedes configurar tu navegador para bloquear o eliminar cookies en cualquier momento. Ten en cuenta que deshabilitar ciertas cookies puede afectar al funcionamiento de la plataforma. A continuación tienes los enlaces a las instrucciones de los navegadores más comunes:</p>
        <ul>
            <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">Google Chrome</a></li>
            <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener">Mozilla Firefox</a></li>
            <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Safari</a></li>
            <li><a href="https://support.microsoft.com/es-es/microsoft-edge/eliminar-las-cookies-en-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener">Microsoft Edge</a></li>
        </ul>
    </section>

    <section>
        <h2>Consentimiento</h2>
        <p>Al continuar navegando por RecipEZ aceptas el uso de las cookies descritas en este aviso. Puedes revocar tu consentimiento en cualquier momento desde la <a href="{{ route('legal.configuracion-cookies') }}">Configuración de cookies</a>.</p>
    </section>

</main>
@endsection
