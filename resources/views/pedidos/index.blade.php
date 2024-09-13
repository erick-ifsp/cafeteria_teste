@extends('layouts.gerenciamento')

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
                            <th>Nota Fiscal</th>
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
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn"
                                        style="background-color: #35221B; color: #f1f1f1">Ver Detalhes</a>
                                    @if($pedido->status == 'Pendente')
                                        <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Pronto">
                                            <button type="submit" class="btn" style="background-color: #98C9A3; color: #f1f1f1">Marcar
                                                como Pronto</button>
                                        </form>
                                    @elseif($pedido->status == 'Pronto')
                                        <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Concluído">
                                            <button type="submit" class="btn btn-sm"
                                                style="background-color: #98C9A3; color: #f1f1f1">Marcar como Concluído</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.nota-fiscal', $pedido->id) }}" class="btn"
                                        style="background-color: #35221B; color: #f1f1f1">Gerar Nota Fiscal</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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
                            <th>Nota Fiscal</th>
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
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn"
                                        style="background-color: #35221B; color: #f1f1f1">Ver Detalhes</a>
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.nota-fiscal', $pedido->id) }}" class="btn"
                                        style="background-color: #35221B; color: #f1f1f1">Gerar Nota Fiscal</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endcan
</div>

<div class="row mt-4 fixed-bottom bg-white py-3 border-top">
        <div class="col-md-11 text-end mb-2 mt-2">
            <a href=" {{ route('pedidos.create') }} " class="btn" style="background-color: #98C9A3; color: #f1f1f1">Adicionar Pedido</a>
        </div>
</div>

@endsection