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

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/imagem1.webp" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="images/imagem1.webp" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="images/imagem1.webp" class="d-block w-100" alt="Slide 3">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Próximo</span>
    </a>
</div>

<div class="container mt-5">
    <h2 class="mb-4 text-center">As melhores ofertas em Produtos</h2>
    <div class="row">
        @foreach ($produtos as $produto)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="ratio ratio-1x1">
                        @if($produto->produto_arquivo)
                            <img src="{{ asset('storage/' . $produto->produto_arquivo) }}" class="card-img-top"
                                alt="{{ $produto->nome }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light h-100">
                                <span class="text-muted fs-4">Imagem Indisponível</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fs-5">
                            <a href="{{ route('produtos.show', ['id' => $produto->id]) }}"
                                class="text-decoration-none text-dark">
                                {{ $produto->nome }}
                            </a>
                        </h5>
                        <p class="card-text">Categoria: {{ $produto->categoria }}</p>
                        <p class="card-text text-center fw-bold fs-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('cardapio') }}" class="btn btn-dark">Ver mais</a>
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
</style>
@endsection