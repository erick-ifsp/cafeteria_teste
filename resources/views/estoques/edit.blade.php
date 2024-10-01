@extends('layouts.gerenciamento')

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
            <input type="text" class="form-control" maxlength="50" name="nome" value="{{ $estoques->nome }}"
                placeholder="Digite o nome da estoque:" required>
        </div>

        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Descrição e Quantidade:</label>
            <input type="text" class="form-control" maxlength="100" name="descricao" value="{{ $estoques->descricao }}"
                placeholder="Digite a descrição e a quantidade:" required>
        </div>

        <div class="form-group mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" class="form-control" maxlength="10" name="valor" value="{{ $estoques->valor }}"
                placeholder="Digite o valor da estoque:" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn me-2" style="background-color: #35221B; color: #f1f1f1">Salvar</button>
            <a href="{{ route('estoques') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
        </div>
    </form>
</div>

@endsection