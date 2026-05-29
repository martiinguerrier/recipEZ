@extends('layouts.clean')

@section('title', 'Declaración de Accesibilidad - RecipEZ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/legal.css') }}">
@endpush

@section('content')
<main class="legal-container">

    <h1>Declaración de Accesibilidad</h1>

    <section>
        <h2>Compromiso con la accesibilidad</h2>
        <p>RecipEZ se compromete a garantizar la accesibilidad de su plataforma para todas las personas, independientemente de sus capacidades o del dispositivo que utilicen. Trabajamos continuamente para mejorar la experiencia de usuario y cumplir con los estándares internacionales de accesibilidad web.</p>
    </section>

    <section>
        <h2>Estándares aplicados</h2>
        <p>Nos esforzamos por cumplir con las <strong>Pautas de Accesibilidad para el Contenido Web (WCAG) 2.1</strong> en su nivel AA, establecidas por el World Wide Web Consortium (W3C). Estas pautas explican cómo hacer el contenido web más accesible para personas con discapacidades.</p>
    </section>

    <section>
        <h2>Medidas adoptadas</h2>
        <ul>
            <li>Uso de etiquetas semánticas HTML para facilitar la navegación con lectores de pantalla.</li>
            <li>Textos alternativos en imágenes y elementos visuales.</li>
            <li>Contraste de color suficiente entre texto y fondo.</li>
            <li>Navegación accesible mediante teclado.</li>
            <li>Integración del widget de accesibilidad <strong>UserWay</strong>, que ofrece opciones como ajuste de tamaño de texto, modo alto contraste, lector de pantalla y más.</li>
        </ul>
    </section>

    <section>
        <h2>Limitaciones conocidas</h2>
        <p>A pesar de nuestros esfuerzos, es posible que algunas secciones de la plataforma no cumplan completamente con todos los criterios de accesibilidad, especialmente en contenido generado por los propios usuarios. Estamos trabajando para identificar y corregir estas situaciones.</p>
    </section>

    <section>
        <h2>Compatibilidad</h2>
        <p>RecipEZ está diseñado para ser compatible con las versiones recientes de los principales navegadores (Chrome, Firefox, Safari, Edge) y con tecnologías de asistencia como lectores de pantalla (NVDA, JAWS, VoiceOver).</p>
    </section>

    <section>
        <h2>Contacto y retroalimentación</h2>
        <p>Si encuentras alguna barrera de accesibilidad en RecipEZ o tienes sugerencias para mejorarla, puedes ponerte en contacto con nosotros en <a href="mailto:info@recipez.app">info@recipez.app</a>. Nos comprometemos a responder en un plazo máximo de 5 días hábiles.</p>
    </section>

</main>
@endsection
