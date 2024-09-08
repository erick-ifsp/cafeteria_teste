@extends('layouts.app')

@section('title', 'Categorias de Acesso')

@section('content')

<div class="container custom-container m-5">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('categorias') }}" method="GET">
                <input type="text" name="nome" placeholder="Buscar" class="form-control mb-3"
                    value="{{ request('nome') }}">

                <h5 class="mb-2 mt-3">Ordenar por</h5>
                <select name="ordem" class="form-control mb-3">
                    <option value="">Selecione...</option>
                    <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>Nome (A a Z)</option>
                    <option value="za" {{ request('ordem') == 'za' ? 'selected' : '' }}>Nome (Z a A)</option>
                    <option value="ultima_editada" {{ request('ordem') == 'ultima_editada' ? 'selected' : '' }}>Mais recente</option>
                    <option value="primeira_editada" {{ request('ordem') == 'primeira_editada' ? 'selected' : '' }}>
                        Mais antigo</option>
                </select>

                <button type="submit" class="btn btn-block mt-4" style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5 class="mb-3">Gerenciar Categorias de Acesso</h5>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col" class="text-center">Editar</th>
                        <th scope="col" class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accesses as $access)
                        <tr>
                            <td>{{ $access->id }}</td>
                            <td>{{ $access->nome }}</td>
                            <td class="text-center">
                                <a href="{{ route('accesses.edit', ['id' => $access->id]) }}"
                                    class="btn btn-sm" style="background-color: #35221B; color: #f1f1f1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('accesses.destroy', ['id' => $access->id]) }}" method="POST"
                                    style="display:inline;">
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

            <a href="{{ route('accesses.create') }}" class="btn mt-3" style="background-color: #35221B; color: #f1f1f1">Criar Nova Categoria</a>
        </div>
    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>

@endsection