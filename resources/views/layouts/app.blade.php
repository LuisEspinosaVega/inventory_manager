<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - ERP</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Exo 2', sans-serif;
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                @auth
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        Inicio - Modulos
                    </a>
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Sobre nostros') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Contacto') }}</a>
                            </li>
                        </ul>
                    @else
                        {{-- <ul class="navbar-nav mx-auto">

                            @if (Auth::user()->can('main_inventory'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('inventory') }}">{{ __('Inventarios') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">{{ __('Inventarios') }}</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('main_finance'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Finanzas') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">{{ __('Finanzas') }}</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('main_rh'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Recursos humanos') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">{{ __('Recursos humanos') }}</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('main_social'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Social') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">{{ __('Social') }}</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('main_admin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin') }}">{{ __('Admin') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">{{ __('Admin') }}</a>
                                </li>
                            @endif

                        </ul> --}}
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item bg-dark text-light" href="{{ route('profile') }}">Mi
                                        cuenta</a>
                                    <a class="dropdown-item bg-dark text-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
