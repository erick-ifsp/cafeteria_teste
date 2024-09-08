@extends('layouts.app')

@section('title', 'Adicionar Categorias de Acesso')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Criar Categoria de Acesso</h1>
            <hr>
            <form action="{{ route('accesses.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" maxlength="50" placeholder="Digite o nome da categoria de acesso"
                        required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Adicionar</button>
                    <a href="{{ route('accesses') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection