@extends('layouts.home')

@section('content')


<div class="sidebar" id="sidebar">
    <nav class="nav flex-column ml-2">
        <a class="nav-link" href="{{ route('carrinho.index') }}">Carrinho</a>
        <a class="nav-link" href="{{ route('sobre') }}">Sobre Nós</a>

        @can('func')
            <a class="nav-link" href="{{ route('gerenciamento') }}">Gerenciamento</a>
        @endcan

        <a class="nav-link" href="{{ route('cardapio') }}">Cardápio</a>

        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif
        @else
            <a class="nav-link" href="{{ route('profile.show') }}">
                {{ __('Meu Perfil') }}
            </a>
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Sair') }}</a>
        @endguest
    </nav>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="ratio custom-ratio">
                <img src="images/cafeteria.webp" class="d-block w-100" alt="Slide 1" style="object-fit: cover;">
            </div>
        </div>
        <div class="carousel-item">
            <div class="ratio custom-ratio">
                <img src="images/cafeteria2.jpg" class="d-block w-100" alt="Slide 2" style="object-fit: cover;">
            </div>
        </div>
        <div class="carousel-item">
            <div class="ratio custom-ratio">
                <img src="images/cafeteria3.png" class="d-block w-100" alt="Slide 3" style="object-fit: cover;">
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Próximo</span>
    </a>
</div>


<div class="container mt-5">
    <h2 class="mb-4 text-center">As melhores ofertas em Produtos</h2>
    <div class="row">
        @foreach ($produtos as $produto)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card">
                    <img src="{{ asset('storage/' . $produto->produto_arquivo) }}" class="card-img-top"
                        alt="{{ $produto->nome }}" style="width: 250px; height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('produtos.show', ['id' => $produto->id]) }}" style="color: #111111">
                                {{ $produto->nome }}
                            </a>
                        </h5>
                        <p class="card-text">
                            Categoria: {{ $produto->categoria }}
                        </p>
                        <p class="h6 card-text">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('cardapio') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Ver mais</a>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        document.body.classList.toggle('overflow-hidden', sidebar.classList.contains('active'));
    });
</script>

<style>
    .sidebar {
        position: fixed;
        left: -250px;
        width: 250px;
        background-color: #f1f1f1;
        padding-top: 10px;
        height: calc(100% - 50px);
        transition: left 0.3s ease;
        z-index: 999;
    }

    .sidebar.active {
        left: 0;
        overflow: hidden;
    }

    .sidebar a {
        color: #35221B;
    }

    .sidebar .nav-item {
        width: 100%;
    }

    .sidebar .nav-item a {
        width: 100%;
        padding: 10px 15px;
    }

    .custom-ratio {
        position: relative;
        width: 100%;
        padding-top: 42.857%;
    }

    .custom-ratio img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .custom-ratio {
            padding-top: 100%;
        }
    }
</style>
@endsection