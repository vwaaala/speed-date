<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <title>{{ config('app.name', 'Larabone') }}</title>

    <!-- vite styles -->
    @vite(['resources/sass/app.scss'])
    <!-- page specific styles -->
    @stack('styles')
</head>

<body>
<!-- page loader -->
<div id="loader-wrapper">
    <div id="loader" class="page-loader">
        <span class="loader"></span>
    </div>
</div>

<!-- app wrapper -->
<div id="app">

    @auth()
        <!-- sidebar -->
        @include('layouts.partials.sidebar')
    @endauth
    <div class="content {{ auth()->check() ? 'logged-in' : '' }}">
        <!-- navbar -->
        @include('layouts.partials.navbar')
        <div class="p-2 mt-2">
            @auth()
                <!-- breadcrumb -->
                @include('layouts.partials.breadcrumb')
            @endauth
            @if(session('success'))
                <!-- session message: success -->
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <!-- session message: error -->
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!-- app::dynamic content-->
            @yield('content')
        </div>

        <!-- footer -->
        <footer class="bg-light">
            <p>&copy; 2024 | All rights reserved | <a href="https://bunk3r.net" target="_blank" rel="noopener noreferrer">Bunk3r</a></p>
        </footer>
    </div>
</div>
<!-- jquery -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.js') }}"></script>
<!-- vite scripts -->
@vite(['resources/js/app.js'])
<!-- page specific js -->
@stack('scripts')
<style>
    .nav-item.active .dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0;
    border-right: 0.3em solid transparent;
    border-bottom: 0.3em solid;
    border-left: 0.3em solid transparent;
}
</style>
</body>

</html>
