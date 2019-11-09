<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="/">FFBE Friends</a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
               <a class="nav-item nav-link" href="/">All Units</a>
            </div>
            <div class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                <a class="nav-item nav-link" href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                <a class="nav-item nav-link" href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </div>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
    </div>
</body>
</html>