@extends('layouts.app')

@section('title', 'Adicionar Produto Vendido')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Adicionar Produto Vendido</h1>
    <hr>
    <form action="{{ route('vendas.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" placeholder="Digite o nome do produto:" required>
        </div>
        <div class="form-group mb-3">
            <label for="quantidade" class="form-label">Quantidade:</label>
            <input type="number" class="form-control" name="quantidade" placeholder="Digite a quantidade:" required>
        </div>
        <div class="form-group mb-4">
            <label for="preco" class="form-label">Preço:</label>
            <input type="number" class="form-control" name="preco" placeholder="Digite o preço:" required>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary me-2">Adicionar</button>
            <a href="{{ route('vendas') }}" class="btn btn-secondary">Cancelar</a>

        </div>
    </form>
</div>

@endsection