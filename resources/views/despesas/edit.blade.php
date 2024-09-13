@extends('layouts.gerenciamento')

@section('title', 'Editar Despesa')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Editar Despesa</h1>
    <hr>
    <form action="{{ route('despesas.update', ['id' => $despesas->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" maxlength="50" name="nome" value="{{ $despesas->nome }}"
                placeholder="Digite o nome da despesa:" required>
        </div>

        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" class="form-control" maxlength="100" name="descricao" value="{{ $despesas->descricao }}"
                placeholder="Digite a descrição:" required>
        </div>

        <div class="form-group mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input type="number" class="form-control" maxlength="20" name="valor" value="{{ $despesas->valor }}"
                placeholder="Digite o valor da despesa:" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn me-2" style="background-color: #35221B; color: #f1f1f1">Salvar</button>
            <a href="{{ route('despesas') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
        </div>
    </form>
</div>

@endsection