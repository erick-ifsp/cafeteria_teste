@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @can('func')
        <div class="row">
            <h2 class="mt-3">Todos os Pedidos</h2>
            @if($pedidos->isEmpty())
                <p>Não há pedidos disponíveis.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Usuário</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->usuario->name }}</td>
                                <td>{{ number_format($pedido->total, 2, ',', '.') }}</td>
                                <td>
                                    @if($pedido->status == 'Pendente')
                                        <span class="badge bg-secondary">{{ $pedido->status }}</span>
                                    @elseif($pedido->status == 'Pronto')
                                        <span class="badge bg-warning text-dark">{{ $pedido->status }}</span>
                                    @elseif($pedido->status == 'Concluído')
                                        <span class="badge bg-success">{{ $pedido->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-primary btn-sm">Ver
                                        Detalhes</a>
                                    @if($pedido->status == 'Pendente')
                                        <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Pronto">
                                            <button type="submit" class="btn btn-warning btn-sm">Marcar como Pronto</button>
                                        </form>
                                    @elseif($pedido->status == 'Pronto')
                                        <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Concluído">
                                            <button type="submit" class="btn" style="background-color: #98C9A3" btn-sm">Marcar como Concluído</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endcan
        </div>
    @else
        <div class="row">
            <h2>Seus Pedidos</h2>
            @if($pedidos->isEmpty())
                <p>Você ainda não tem pedidos.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ number_format($pedido->total, 2, ',', '.') }}</td>
                                <td>
                                    @if($pedido->status == 'Pendente')
                                        <span class="badge bg-secondary">{{ $pedido->status }}</span>
                                    @elseif($pedido->status == 'Pronto')
                                        <span class="badge bg-warning text-dark">{{ $pedido->status }}</span>
                                    @elseif($pedido->status == 'Concluído')
                                        <span class="badge bg-success">{{ $pedido->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-primary btn-sm">Ver
                                        Detalhes</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endcan
</div>
@endsection