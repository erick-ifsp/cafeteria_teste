@extends('layouts.app')

@section('content')
<div class="container custom-container">
    <div class="mb-2 mt-5">
        <a href="{{ route('cardapio') }}" class="btn btn-outline-secondary">Voltar ao cardápio</a>
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
                <h2 id="produto-preco" class="h2 text-dark mb-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </h2>
                <p class="h4 text-muted mb-4">{{ $produto->descricao }}</p>
                <p><strong>Categoria:</strong>
                    <a href="http://cafeteria.local/cardapio?nome=&categorias%5B%5D={{$produto->categoria}}&ordem="
                        style="color: #35221B">{{ $produto->categoria }}</a>
                </p>
                <div class="d-flex gap-2 mt-2">
                    <form action="{{ route('carrinho.add', $produto->id) }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                @foreach($produto->variacoes as $variacao)
                                    <option value="{{ $variacao->nome }}" data-preco="{{ $variacao->preco }}">
                                        {{ $variacao->nome }} (R$ {{ number_format($variacao->preco, 2, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="preco" name="preco" value="{{ $produto->preco }}">
                        <div class="d-flex gap-2">
                            <input type="number" name="quantidade" class="form-control quantidade" value="1" min="1"
                                max="50" style="width: 65px; text-align: center;">
                            <button class="btn" type="submit"
                                style="background-color: #35221B; color: #f1f1f1">Adicionar ao
                                Carrinho
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectTipo = document.getElementById('tipo');
        const precoDisplay = document.getElementById('produto-preco');
        const inputPreco = document.getElementById('preco');

        selectTipo.addEventListener('change', function () {
            const precoSelecionado = selectTipo.options[selectTipo.selectedIndex].dataset.preco;
            const precoFormatado = parseFloat(precoSelecionado).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            precoDisplay.textContent = precoFormatado;
            inputPreco.value = precoSelecionado;
        });
    });
</script>

<style>
    .thumbnail-images img {
        cursor: pointer;
    }

    .custom-container {
        max-width: 1425px;
    }
</style>

@endsection