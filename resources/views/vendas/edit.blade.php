@extends('layouts.app')

@section('title', 'Editar Vendas')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Editar Vendas</h1>
    <hr>
    <form action="{{ route('vendas.update', ['id' => $vendas->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" value="{{ $vendas->nome }}"
                placeholder="Digite o nome do produto:" required>
        </div>
        <div class="form-group mb-3">
            <label for="quantidade" class="form-label">Quantidade:</label>
            <input type="number" class="form-control" name="quantidade" value="{{ $vendas->quantidade }}"
                placeholder="Digite a quantidade:" required>
        </div>
        <div class="form-group mb-4">
            <label for="preco" class="form-label">Preço:</label>
            <input type="number" class="form-control" name="preco" value="{{ $vendas->preco }}"
                placeholder="Digite o preço:" required>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary me-2">Salvar</button>
            <a href="{{ route('vendas') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection