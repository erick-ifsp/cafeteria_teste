<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cafeteria') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="{{ asset('js/mascaras.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('../public/css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background-color: #F1F1F1;
        }

        #app {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        footer {
            margin-top: auto;
            background-color: #35221B;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <a class="nav-link active" aria-current="page" href="/">Cafeteria</a>


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cardapio') }}">{{ __('Cardápio') }}</a>
                    </li>
                    <li class="nav-item" style="color: #35221B">
                        <a class="nav-link" href="{{ route('carrinho.index') }}">
                            {{ __('Carrinho') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pedidos') }}">{{ __('Pedidos') }}</a>
                    </li>

                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                            </li>
                        @endif

                    @else
                        @can('func')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gerenciamento') }}">{{ __('Gerenciamento') }}</a>
                            </li>
                        @endcan
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    {{ __('Meu Perfil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Sair') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    @if(!isset($noFooter) || !$noFooter)
        <footer class="footer mt-5 py-4 text-white">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Cafeteria</h5>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero, sapiente!</p>
                    </div>
                    <div class="col-md-2">
                        <h5>Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('cardapio') }}" class="text-white">Cardápio</a></li>
                            <li><a href="{{ route('sobre') }}" class="text-white">Sobre Nós</a></li>
                            <li><a href="https://g.co/kgs/TZHFx4n" class="text-white">Localização</a></li>
                            <li><a href="" class="text-white">Contato</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Social</h5>
                        <ul class="list-unstyled">
                            <li><a href="https://www.instagram.com" class="text-white">Instagram</a></li>
                            <li><a href="https://www.facebook.com" class="text-white">Facebook</a></li>
                            <li><a href="https://twitter.com" class="text-white">Twitter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    @endif
</body>

<script src="js/mascaras"></script>

</html>