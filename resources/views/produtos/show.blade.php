@extends('layouts.app')

@section('content')

<div class="container custom-container">
    <div class="mb-2 mt-5">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="main-image mb-3" style="width: 100%; max-width: 440px;">
                    <img id="main-product-image"
                        src="{{ $produto->produto_arquivo ? asset('storage/' . $produto->produto_arquivo) : 'https://via.placeholder.com/500x500?text=Produto+Sem+Imagem' }}"
                        alt="{{ $produto->nome }}" class="img-fluid rounded border"
                        style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-top">
                <h1 class="h1 text-left mb-4">{{ $produto->nome }}</h1>
                <h2 class="h2 text-dark mb-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h2>
                <p class="h4 text-muted mb-4">{{ $produto->descricao }}</p>
                <p><strong>Categoria:</strong>
                    <a href="http://cafeteria.local/cardapio?nome=&categorias%5B%5D={{$produto->categoria}}&ordem="
                        style="color: #35221B">{{ $produto->categoria }}</a>
                </p>
                <div class=" d-flex gap-2 mt-2">
                    <form action="{{ route('carrinho.add', $produto->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="{{ $produto->nome }}">{{ $produto->nome }}</option>
                                @foreach(explode(', ', $produto->tipos) as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="number" name="quantidade" class="form-control quantidade" value="1" min="1"
                                max="50" style="width: 65px; text-align: center;">
                            <button id="add-to-cart-form" class="btn" type="submit"
                                style="background-color: #35221B; color: #f1f1f1">Adicionar ao
                                Carrinho
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="thumbnail-images mt-4 ml-3" style="width: 100%; max-width: 500px;">
        <div class="row">
            <div class="col-3">
                <img onclick="changeImage('{{ asset('storage/' . $produto->produto_arquivo) }}')"
                    src="{{ asset('storage/' . $produto->produto_arquivo) }}" alt="{{ $produto->nome }}"
                    class="img-thumbnail rounded" style="object-fit: cover; aspect-ratio: 1/1;">
            </div>
            @if($produto->produto_arquivo2)
                <div class="col-3">
                    <img onclick="changeImage('{{ asset('storage/' . $produto->produto_arquivo2) }}')"
                        src="{{ asset('storage/' . $produto->produto_arquivo2) }}" alt="{{ $produto->nome }}"
                        class="img-thumbnail rounded" style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
            @endif
            @if($produto->produto_arquivo3)
                <div class="col-3">
                    <img onclick="changeImage('{{ asset('storage/' . $produto->produto_arquivo3) }}')"
                        src="{{ asset('storage/' . $produto->produto_arquivo3) }}" alt="{{ $produto->nome }}"
                        class="img-thumbnail rounded" style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
            @endif
            @if($produto->produto_arquivo4)
                <div class="col-3">
                    <img onclick="changeImage('{{ asset('storage/' . $produto->produto_arquivo4) }}')"
                        src="{{ asset('storage/' . $produto->produto_arquivo4) }}" alt="{{ $produto->nome }}"
                        class="img-thumbnail rounded" style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
            @endif
        </div>
    </div>
</div>
</div>

<style>
    .thumbnail-images img {
        cursor: pointer;
    }

    .custom-container {
        max-width: 1425px;
    }
</style>

<script>
    function changeImage(src) {
        document.getElementById('main-product-image').src = src;
    }

    document.getElementById('add-to-cart-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Impede o recarregamento da página

        var popup = document.getElementById('cart-confirmation-popup');
        popup.style.display = 'block'; // Exibe o popup

        setTimeout(function () {
            popup.style.display = 'none'; // Esconde o popup após 10 segundos
        }, 10000);

        // Aqui você pode fazer um submit do formulário via AJAX, ou redirecionar a página conforme necessário
    });

</script>

@endsection