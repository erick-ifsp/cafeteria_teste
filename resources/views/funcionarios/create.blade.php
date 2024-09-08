@extends('layouts.app')

@section('title', 'Adicionar Funcionario')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Adicionar Funcionário</h1>
            <hr>
            <form action="{{ route('funcionarios.store') }}" method="POST" id="cpfForm">
                @csrf
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome do funcionário:"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF:" required>
                </div>

                <div class="form-group mb-3">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" class="form-control" name="cargo" placeholder="Digite o cargo do funcionário:"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" class="form-control" name="telefone" placeholder="Digite o telefone:" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Digite o email:" required>
                </div>

                <div class="form-group mb-3">
                    <label for="data_contratacao" class="form-label">Data de Contratação:</label>
                    <input type="date" class="form-control" name="data_contratacao" required>
                </div>

                <div class="form-group mb-3">
                    <label for="access_id" class="form-label">Nível de Acesso:</label>
                    <select class="form-control" name="access_id" required>
                        <option value="">Selecione um nível de acesso...</option>
                        @foreach ($AccessLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="salario" class="form-label">Salário:</label>
                    <input type="number" step="0.01" class="form-control" name="salario"
                        placeholder="Digite o salário do funcionário:" required>
                </div>

                <button type="submit" class="btn mt-3" style="background-color: #35221B; color: #f1f1f1">Salvar</button>

                <a href="{{ route('funcionarios') }}" class="btn mt-3"
                    style="background-color: #808080; color: #f1f1f1">Cancelar</a>
            </form>
        </div>
    </div>
</div>


@endsection