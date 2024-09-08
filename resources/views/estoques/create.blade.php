@extends('layouts.app')

@section('title', 'Adicionar Estoque')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Adicionar Estoque</h1>
    <hr>
    <form action="{{ route('estoques.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" placeholder="Digite o nome da estoque:" required>
        </div>
        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Quantidade e Descrição:</label>
            <input type="text" class="form-control" name="descricao" placeholder="Digite a quantidade e a descrição:" required>
        </div>
        <div class="form-group mb-4">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" class="form-control" name="valor" placeholder="Digite o valor da estoque:" required>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary me-2">Adicionar</button>
            <a href="{{ route('estoques') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection