@extends('layouts.app')

@section('title', 'Editar Categorias')

@section('content')

<div class="container mt-5">
    <h1>Editar Categoria</h1>
    <hr>
    <form action="{{ route('categorias.update', ['id' => $categorias->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="{{ $categorias->nome }}"
                    placeholder="Digite o nome da categoria:" required>
            </div>
            <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Salvar</button>
            <a href="{{ route('categorias') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
        </div>
    </form>
</div>

@endsection