@extends('layouts.gerenciamento')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Detalhes do Pedido #{{ $pedido->id }}</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informações do Pedido
        </div>
        <div class="card-body">
            <p><strong>Usuário:</strong> {{ $pedido->usuario->name }}</p>
            <p><strong>Total:</strong> {{ number_format($pedido->total, 2, ',', '.') }}</p>
            <p><strong>Status:</strong>
                <span
                    class="badge badge-{{ $pedido->status == 'Concluído' ? 'success' : ($pedido->status == 'Pronto' ? 'warning' : 'secondary') }}">
                    {{ $pedido->status }}
                </span>
            </p>
        </div>
    </div>

    <h2 class="mb-4">Produtos do Pedido</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead">
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->pedidoProdutos as $item)
                    <tr>
                        <td>{{ $item->produto->nome }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>{{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection