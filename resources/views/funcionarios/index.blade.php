@extends('layouts.gerenciamento')

@section('title', 'Funcionario')

@section('content')
<div class="container custom-container mt-5">
    <div class="row">
        <div class="col-md-3">
            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('funcionarios') }}" method="GET">
                <h5 class="h6 mb-3">Nome:</h5>
                <input type="text" name="nome" placeholder="Buscar" class="form-control mb-3" value="{{ request('nome') }}">

                <h5 class="h6 mb-3">CPF:</h5>
                <input type="text" name="cpf" placeholder="Buscar" class="form-control mb-3" value="{{ request('cpf') }}">

                <button type="submit" class="btn btn-block mt-4" style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-sm-9">
            <h5 class="mb-3">Lista de Funcionários</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Salário</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Nível de Acesso</th>
                        <th scope="col" class="text-center">Editar</th>
                        <th scope="col" class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($funcionarios as $funcionario)
                        <tr>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->cpf }}</td>
                            <td>R$ {{ number_format($funcionario->salario, 2, ',', '.') }}</td>
                            <td>{{ $funcionario->access_id }}</td>
                            <td>{{ $funcionario->nome }}</td>
                            <td class="text-center">
                                <a href="{{ route('funcionarios.edit', ['id' => $funcionario->id]) }}" class="btn btn-sm" style="background-color: #35221B; color: #f1f1f1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('funcionarios.destroy', ['id' => $funcionario->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background-color: #35221B; color: #f1f1f1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('funcionarios.create') }}" class="btn mt-3" style="background-color: #35221B; color: #f1f1f1">Adicionar Novo Funcionário</a>
        </div>
    </div>
</div>
@endsection
