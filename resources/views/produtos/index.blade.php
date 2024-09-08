@extends('layouts.app')

@section('title', 'Produtos')

@section('content')

<div class="container custom-container m-5">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('produtos') }}" method="GET">
                <input type="text" name="nome" placeholder="Buscar" class="form-control mb-3"
                    value="{{ request('nome') }}">

                <h5 class="mb-3">Categorias</h5>
                @foreach ($categorias as $categoria)
                    <div class="form-check ml-1">
                        <input class="form-check-input" type="checkbox" name="categorias[]" value="{{ $categoria->nome }}"
                            id="categoria{{ $categoria->id }}" {{ in_array($categoria->nome, (array) request('categorias')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="categoria{{ $categoria->id }}">{{ $categoria->nome }}</label>
                    </div>
                @endforeach

                <h5 class="mb-2 mt-3">Ordenar por</h5>
                <select name="ordem" class="form-control mb-3">
                    <option value="">Selecione...</option>
                    <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>Nome (A a Z)</option>
                    <option value="za" {{ request('ordem') == 'za' ? 'selected' : '' }}>Nome (Z a A)</option>
                    <option value="preco_asc" {{ request('ordem') == 'preco_asc' ? 'selected' : '' }}>Preço (Menor ao
                        Maior)</option>
                    <option value="preco_desc" {{ request('ordem') == 'preco_desc' ? 'selected' : '' }}>Preço (Maior ao
                        Menor)</option>
                    <option value="ultima_editada" {{ request('ordem') == 'ultima_editada' ? 'selected' : '' }}>Última
                        Categoria Editada</option>
                    <option value="primeira_editada" {{ request('ordem') == 'primeira_editada' ? 'selected' : '' }}>
                        Primeira Categoria Editada</option>
                </select>

                <button type="submit" class="btn btn-block mt-4" style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5 class="mb-3">{{ count($produtos) }} {{ count($produtos) == 1 ? 'Produto' : 'Produtos' }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Categoria</th>
                        <th scope="col" class="text-center">Editar</th>
                        <th scope="col" class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>{{ $produto->categoria }}</td>
                            <td class="text-center">
                                <a href="{{ route('produtos.edit', ['id' => $produto->id]) }}"
                                    class="btn btn-sm" style="background-color: #35221B; color: #f1f1f1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('produtos.destroy', ['id' => $produto->id]) }}" method="POST"
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

            <a href="{{ route('produtos.create') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Criar Novo Produto</a>
        </div>
    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>
@endsection