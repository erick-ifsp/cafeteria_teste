@extends('layouts.app')

@section('title', 'Financeiro')

@section('content')

<div class="container custom-container m-5">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <h5 class="mb-3">Filtros</h5>
            <form action="{{ route('financeiro') }}" method="GET">
                <input type="text" name="nome" placeholder="Buscar por nome" class="form-control mb-3"
                    value="{{ request('nome') }}">

                <h5 class="mb-2 mt-3">Tipo</h5>
                <select name="tipo" class="form-control mb-3">
                    <option value="">Todos</option>
                    <option value="venda" {{ request('tipo') == 'venda' ? 'selected' : '' }}>Venda</option>
                    <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                    <option value="estoque" {{ request('tipo') == 'estoque' ? 'selected' : '' }}>Estoque</option>
                </select>

                <h5 class="mb-2 mt-3">Data</h5>
                <input type="date" name="data_inicio" placeholder="Data Início" class="form-control mb-3"
                    value="{{ request('data_inicio') }}">
                <input type="date" name="data_fim" placeholder="Data Fim" class="form-control mb-3"
                    value="{{ request('data_fim') }}">

                <h5 class="mb-2 mt-3">Ordenar por</h5>
                <select name="ordem" class="form-control mb-3">
                    <option value="">Selecione...</option>
                    <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>Nome (A a Z)</option>
                    <option value="za" {{ request('ordem') == 'za' ? 'selected' : '' }}>Nome (Z a A)</option>
                    <option value="preco_asc" {{ request('ordem') == 'preco_asc' ? 'selected' : '' }}>Preço (Menor ao
                        Maior)</option>
                    <option value="preco_desc" {{ request('ordem') == 'preco_desc' ? 'selected' : '' }}>Preço (Maior ao
                        Menor)</option>
                    <option value="ultima_editada" {{ request('ordem') == 'ultima_editada' ? 'selected' : '' }}>Mais
                        Recente</option>
                    <option value="primeira_editada" {{ request('ordem') == 'primeira_editada' ? 'selected' : '' }}>Mais
                        Antiga</option>
                </select>

                <button type="submit" class="btn btn-block mt-4"
                    style="background-color: #35221B; color: #f1f1f1">Aplicar</button>
            </form>
        </div>

        <div class="col-md-9">
            <h5 class="mb-3">{{ $financeiros ? count($financeiros) : 0 }}
                {{ $financeiros && count($financeiros) == 1 ? 'Encontrado' : 'Encontrados' }}
            </h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($financeiros as $financeiro)
                        <tr>
                            <td>{{ $financeiro->nome }}</td>
                            <td>{{ $financeiro->descricao }}</td>
                            <td>{{ $financeiro->tipo }}</td>
                            <td>R$ {{ number_format($financeiro->valor, 2, ',', '.') }}</td>
                            <td>{{ $financeiro->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Total: R$ {{ number_format($total, 2, ',', '.') }}</h5>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('financeiro.pdf', request()->query()) }}" class="btn btn-primary">Gerar PDF</a>
        </div>

    </div>
</div>

<style>
    .custom-container {
        max-width: 1425px;
    }
</style>
@endsection