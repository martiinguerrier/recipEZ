<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RecipEZ')</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profilerecipes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('img/Favicon RecipEZ.png') }}">
</head>

<body class="recip">

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- HERO --}}
    @include('partials.hero')

    {{-- CONTENIDO --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    <script src="https://cdn.userway.org/widget.js" data-account="H7oxU6x4tP" data-position="bottom-left" data-color="#00d9ff"></script>
</body>
<style>
    #userwayAccessibilityIcon {
        bottom: -90vh !important;
        right: -1vw !important;
    }
</style>
</html>