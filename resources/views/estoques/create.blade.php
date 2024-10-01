@extends('layouts.gerenciamento')

@section('title', 'Adicionar Estoque')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Adicionar Estoque</h1>
    <hr>
    <form action="{{ route('estoques.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" maxlength="50" placeholder="Digite o nome da estoque:" required>
        </div>
        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Quantidade e Descrição:</label>
            <input type="text" class="form-control" name="descricao" maxlength="100" placeholder="Digite a quantidade e a descrição:" required>
        </div>
        <div class="form-group mb-4">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" class="form-control" name="valor" maxlength="10" placeholder="Digite o valor da estoque:" required>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn me-2" style="background-color: #35221B; color: #f1f1f1">Adicionar</button>
            <a href="{{ route('estoques') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
        </div>
    </form>
</div>

@endsection