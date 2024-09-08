@extends('layouts.app')

@section('title', 'Editar Estoque')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Editar Estoque</h1>
    <hr>
    <form action="{{ route('estoques.update', ['id' => $estoques->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" value="{{ $estoques->nome }}"
                placeholder="Digite o nome da estoque:" required>
        </div>

        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Descrição e Quantidade:</label>
            <input type="text" class="form-control" name="descricao" value="{{ $estoques->descricao }}"
                placeholder="Digite a descrição e a quantidade:" required>
        </div>

        <div class="form-group mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" class="form-control" name="valor" value="{{ $estoques->valor }}"
                placeholder="Digite o valor da estoque:" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('estoques') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection