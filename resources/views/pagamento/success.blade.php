@extends('layouts.gerenciamento')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">Obrigado por sua compra!</h2>
        <p class="lead">Seu pedido foi recebido com sucesso e está sendo processado.</p>
        <div class="alert alert-success" role="alert">
            <strong>Resumo do Pedido:</strong><br>
            Número do Pedido: <strong>{{ $pedido->id }}</strong><br>
            Data do Pedido: <strong>{{ $pedido->created_at->format('d/m/Y H:i') }}</strong><br>
            Total: <strong>R$ {{ number_format($pedido->total, 2, ',', '.') }}</strong>
        </div>
        <h4 class="mt-4">O que fazer a seguir?</h4>
        <ul class="list-unstyled">
            <li><i class="bi bi-check-circle-fill"></i> Acompanhe o status do seu pedido na seção <a
                    href="{{ route('pedidos')}}">Meus Pedidos.</a></li>
        </ul>
        <a href="{{ route('cafeteria') }}" class="btn" style="background-color: #35221B; color: #f1f1f1">Voltar à Página
            Inicial</a>
    </div>
</div>
@endsection