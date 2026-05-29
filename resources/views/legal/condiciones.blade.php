@extends('layouts.clean')

@section('title', 'Condiciones de Uso - RecipEZ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/legal.css') }}">
@endpush

@section('content')
<main class="legal-container">

    <h1>Condiciones de Uso</h1>

    <section>
        <h2>1. Aceptación de las condiciones</h2>
        <p>Al acceder y utilizar RecipEZ, aceptas quedar vinculado por estas Condiciones de Uso. Si no estás de acuerdo con alguno de los términos aquí recogidos, te rogamos que no utilices la plataforma.</p>
    </section>

    <section>
        <h2>2. Descripción del servicio</h2>
        <p>RecipEZ es una plataforma en línea que permite a los usuarios descubrir, publicar y compartir recetas de cocina. El servicio incluye funcionalidades como la búsqueda de recetas, la creación de perfiles de usuario, la lista de la compra y la posibilidad de guardar recetas favoritas.</p>
    </section>

    <section>
        <h2>3. Registro y cuenta de usuario</h2>
        <p>Para acceder a ciertas funciones es necesario crear una cuenta. Al registrarte, te comprometes a proporcionar información veraz y actualizada. Eres responsable de mantener la confidencialidad de tu contraseña y de todas las actividades que se realicen desde tu cuenta.</p>
        <p>RecipEZ se reserva el derecho de suspender o eliminar cuentas que incumplan estas condiciones o que hagan un uso fraudulento del servicio.</p>
    </section>

    <section>
        <h2>4. Contenido publicado por los usuarios</h2>
        <p>Al publicar recetas, imágenes u otro contenido en RecipEZ, garantizas que dispones de los derechos necesarios para hacerlo y que dicho contenido no infringe derechos de terceros ni contraviene la legislación vigente.</p>
        <p>RecipEZ no asume responsabilidad por el contenido publicado por los usuarios, aunque se reserva el derecho de eliminar cualquier contenido que considere inapropiado, ofensivo o contrario a estas condiciones.</p>
    </section>

    <section>
        <h2>5. Propiedad intelectual</h2>
        <p>El diseño, logotipos, textos e imágenes propios de RecipEZ están protegidos por derechos de propiedad intelectual. Queda prohibida su reproducción total o parcial sin autorización expresa.</p>
    </section>

    <section>
        <h2>6. Limitación de responsabilidad</h2>
        <p>RecipEZ no garantiza la exactitud nutricional de las recetas publicadas por los usuarios. El contenido de la plataforma tiene carácter meramente informativo y no sustituye el consejo de un profesional de la nutrición o la salud.</p>
    </section>

    <section>
        <h2>7. Modificaciones</h2>
        <p>Nos reservamos el derecho de modificar estas condiciones en cualquier momento. Las modificaciones entrarán en vigor desde su publicación en esta página. Te recomendamos revisarlas periódicamente.</p>
    </section>

    <section>
        <h2>8. Contacto</h2>
        <p>Si tienes alguna duda sobre estas condiciones, puedes contactarnos a través del correo electrónico: <a href="mailto:info@recipez.app">info@recipez.app</a></p>
    </section>

</main>
@endsection
