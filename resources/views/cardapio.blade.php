@extends('layouts.app')

@section('title', 'Produtos')

@section('content')

<div class="container custom-container mt-5">
    <div class="row">
        <div class="col-md-3">
            <h5 class="mb-3">Tipos de Produtos</h5>
            <form action="{{ route('cardapio') }}" method="GET">
                <input type="text" name="nome" placeholder="Buscar" class="form-control mb-3"
                    value="{{ request('nome') }}">

                <h5 class="mb-2">Categorias</h5>
                @foreach ($categorias as $categoria)
                    <div class="form-check ml-1">
                        <input class="form-check-input" type="checkbox" name="categorias[]" value="{{ $categoria->nome }}"
                            id="categoria{{ $categoria->id }}" {{ in_array($categoria->nome, (array) request('categorias')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="categoria{{ $categoria->id }}"> {{ $categoria->nome }} </label>
                    </div>
                @endforeach

                <h5 class="mb-2 mt-3">Ordenar por</h5>
                <select name="ordem" class="form-control mb-4">
                    <option value="">Selecione...</option>
                    <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>Nome (A a Z)</option>
                    <option value="za" {{ request('ordem') == 'za' ? 'selected' : '' }}>Nome (Z a A)</option>
                    <option value="preco_asc" {{ request('ordem') == 'preco_asc' ? 'selected' : '' }}>Preço (Menor ao
                        Maior)</option>
                    <option value="preco_desc" {{ request('ordem') == 'preco_desc' ? 'selected' : '' }}>Preço (Maior ao
                        Menor)</option>
                </select>

                <button type="submit" class="btn btn-block mt-3" style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5 class="mb-3">{{ count($produtos) }} {{ count($produtos) == 1 ? "Produto" : "Produtos" }}</h5>
            <div class="row">
                @foreach ($produtos as $produto)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $produto->produto_arquivo) }}" class="card-img-top"
                                alt="{{ $produto->nome }}" style="width: 100%; height: 200px; object-fit: cover;">
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
        </div>
    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>

@endsection