@extends('layouts.app')

@section('title', 'Adicionar Categorias')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Criar Categoria</h1>
            <hr>
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" maxlength="50" name="nome" placeholder="Digite o nome da categoria"
                        required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Adicionar</button>
                    <a href="{{ route('categorias') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection