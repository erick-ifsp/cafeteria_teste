@extends('layouts.gerenciamento')

@section('title', 'Editar Funcionário')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Editar Funcionário</h1>
    <hr>
    <form action="{{ route('funcionarios.update', ['id' => $funcionario->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" maxlength="50" name="nome" value="{{ $funcionario->nome }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="cpf" class="form-label">CPF:</label>
            <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $funcionario->cpf }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="cargo" class="form-label">Cargo:</label>
            <input type="text" class="form-control" name="cargo" value="{{ $funcionario->cargo }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $funcionario->telefone }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" maxlength="100" value="{{ $funcionario->email }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="data_contratacao" class="form-label">Data de Contratação:</label>
            <input type="date" class="form-control" name="data_contratacao" value="{{ $funcionario->data_contratacao }}"
                required>
        </div>

        <div class="form-group mb-3">
            <label for="access_id" class="form-label">Nível de Acesso:</label>
            <select class="form-control" name="access_id" required>
                <option value="">Selecione um nível de acesso...</option>
                @foreach ($AccessLevels as $level)
                    <option value="{{ $level->id }}" {{ $funcionario->access_id == $level->id ? 'selected' : '' }}>
                        {{ $level->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="salario" class="form-label">Salário:</label>
            <input type="text" class="form-control" name="salario" maxlength="10" value="{{ $funcionario->salario }}" required>
        </div>

        <button type="submit" class="btn mt-3" style="background-color: #35221B; color: #f1f1f1">Atualizar</button>
        <a href="{{ route('funcionarios') }}" class="btn mt-3"
            style="background-color: #808080; color: #f1f1f1">Cancelar</a>
    </form>
</div>

@endsection