@extends('layouts.app')

@section('title', 'Estoques')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('estoques') }}" method="GET">
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
            <h5 class="mb-3">{{ count($estoques) }} {{ count($estoques) == 1 ? 'estoque' : 'estoques' }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição e Quantidade</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Adicionado por</th>
                        <th scope="col" class="text-center">Editar</th>
                        <th scope="col" class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estoques as $estoque)
                        <tr>
                            <td>{{ $estoque->nome }}</td>
                            <td>{{ $estoque->descricao }}</td>
                            <td>R$
                                {{ $estoque->valor < 0 ? '-' : '' }}{{ number_format(abs($estoque->valor), 2, ',', '.') }}
                            </td>
                            <td>{{ $estoque->user ? $estoque->user->name : 'Usuário não encontrado' }}</td>
                            <td class="text-center">
                                <a href="{{ route('estoques.edit', ['id' => $estoque->id]) }}" class="btn btn-sm"
                                    style="background-color: #35221B; color: #f1f1f1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('estoques.destroy', ['id' => $estoque->id]) }}" method="POST"
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

            <a href="{{ route('estoques.create') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Adicionar Estoque</a>
        </div>
    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>
@endsection