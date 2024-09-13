@extends('layouts.gerenciamento')

@section('title', 'Despesas')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('despesas') }}" method="GET">
                <input type="text" name="descricao" placeholder="Buscar Descrição" class="form-control mb-3"
                    value="{{ request('descricao') }}">

                <h5 class="mb-3">Data</h5>
                <input type="date" name="data_inicio" class="form-control mb-3" value="{{ request('data_inicio') }}">
                <input type="date" name="data_fim" class="form-control mb-3" value="{{ request('data_fim') }}">

                <button type="submit" class="btn btn-block mt-4"
                    style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5 class="mb-3">{{ count($despesas) }} {{ count($despesas) == 1 ? 'Despesa' : 'Despesas' }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Adicionado por</th>
                        <th scope="col" class="text-center">Editar</th>
                        <th scope="col" class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despesas as $despesa)
                        <tr>
                            <td>{{ $despesa->nome }}</td>
                            <td>{{ $despesa->descricao }}</td>
                            <td>R$
                                {{ $despesa->valor < 0 ? '-' : '' }}{{ number_format(abs($despesa->valor), 2, ',', '.') }}
                            </td>
                            <td>{{ $despesa->user ? $despesa->user->name : 'Usuário não encontrado' }}</td>
                            <td class="text-center">
                                <a href="{{ route('despesas.edit', ['id' => $despesa->id]) }}" class="btn btn-sm"
                                    style="background-color: #35221B; color: #f1f1f1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('despesas.destroy', ['id' => $despesa->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        style="background-color: #35221B; color: #f1f1f1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('despesas.create') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Criar
                Nova Despesa</a>
        </div>
    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>
@endsection