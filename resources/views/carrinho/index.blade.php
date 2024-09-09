@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Carrinho</h2>

    @if(isset($carrinhoItems) && $carrinhoItems->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Preço Unitário</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carrinhoItems as $item)
                            <tr>
                                <td class="align-middle d-flex">
                                    <img src="{{ asset('storage/' . $item->produto->produto_arquivo) }}"
                                        alt="{{ $item->produto->nome }}"
                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    <div class="ml-3">
                                        <a href="{{ route('produtos.show', ['id' => $item->produto->id]) }}"
                                            style="text-decoration: none; color: #000; font-weight: 500;">
                                            {{ $item->produto->nome }}
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle"> {{ $item->tipo }} </td>
                                <td class="align-middle">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</td>
                                <td class="align-middle">
                                    <input type="number" name="quantidade" class="form-control quantidade"
                                        data-id="{{ $item->id }}" value="{{ $item->quantidade }}" min="1"
                                        style="width: 80px; text-align: center;">
                                </td>
                                <td class="align-middle subtotal">
                                    R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-sm" style="background-color: #8D120F; color: #f1f1f1"
                                        data-bs-toggle="modal" data-bs-target="#removerModal-{{ $item->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="removerModal-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="removerModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Remover Produto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Deseja mesmo remover esse produto?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('carrinho.remover', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn" style="background-color: #8D120F; color: #f1f1f1"
                                                    type="submit">Remover</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4 fixed-bottom bg-white py-3 border-top">
            <div class="col-md-11 text-end">
                <h4>Total do Carrinho: <span id="total-carrinho">R$
                        {{ number_format($carrinhoItems->sum(function ($item) {
            return $item->produto->preco * $item->quantidade; }), 2, ',', '.') }}</span>
                </h4>
                <button class="btn" style="background-color: #98C9A3" data-bs-toggle="modal"
                    data-bs-target="#finalizarCompraModal">Finalizar
                    Compra</button>
            </div>
        </div>

        <div class="modal fade" id="finalizarCompraModal" tabindex="-1" aria-labelledby="finalizarCompraLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Compra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="finalizarCompraForm" action="{{ route('carrinho.finalizar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
                                <select id="metodo_pagamento" name="metodo_pagamento" class="form-select" required>
                                    <option value="" disabled selected>Escolha um método</option>
                                    <option value="cartao">Cartão</option>
                                    <option value="pix">PIX</option>
                                    <option value="dinheiro">Dinheiro</option>
                                </select>
                            </div>
                            <div id="cartao-section" class="d-none">
                                <div class="mb-3">
                                    <label for="cartao" class="form-label">Escolha um cartão</label>
                                    <select id="cartao" name="cartao" class="form-select">
                                        @forelse ($cartoes as $cartao)
                                            <option value="{{ $cartao->id }}">{{ $cartao->nome }} - {{ $cartao->numero }}
                                            </option>
                                        @empty
                                            <option value="">Nenhum cartão cadastrado</option>
                                        @endforelse
                                        <option value="novo">Adicionar Novo Cartão</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn" style="background-color: #98C9A3">Confirmar
                                    Pagamento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class=" modal fade" id="adicionarCartaoModal" tabindex="-1" aria-labelledby="adicionarCartaoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Novo Cartão</h5>
                    </div>
                    <div class="modal-body">
                        <form id="adicionarCartaoForm" action="{{ route('cartoes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="numero" class="form-label">Número do Cartão</label>
                                <input type="text" id="numero" name="numero" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome no Cartão</label>
                                <input type="text" id="nome" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="data" class="form-label">Data de Validade</label>
                                <input type="text" id="data" name="data" class="form-control" placeholder="MM/AA" required>
                            </div>
                            <div class="mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" placeholder="000" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn" style="background-color: #98C9A3">Adicionar
                                    Cartão</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-left h6">Seu carrinho está vazio. Acesse o <a href="{{ url('cardapio') }}">Cardápio</a> e veja nossos
            produtos ou acesse <a href="{{ url('pedidos') }}">Meus Pedidos</a></p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fecha o primeiro modal quando o segundo modal abrir
        $('#adicionarCartaoModal').on('show.bs.modal', function () {
            $('#finalizarCompraModal').modal('hide');
        });

        // Reabre o primeiro modal quando o segundo modal fechar
        $('#adicionarCartaoModal').on('hidden.bs.modal', function () {
            $('#finalizarCompraModal').modal('show');
        });

        // Código existente para trocar de método de pagamento
        const metodoPagamentoSelect = document.getElementById('metodo_pagamento');
        const cartaoSection = document.getElementById('cartao-section');
        const cartaoSelect = document.getElementById('cartao');

        metodoPagamentoSelect.addEventListener('change', function () {
            if (this.value === 'cartao') {
                cartaoSection.classList.remove('d-none');
            } else {
                cartaoSection.classList.add('d-none');
            }
        });

        cartaoSelect.addEventListener('change', function () {
            if (this.value === 'novo') {
                new bootstrap.Modal(document.getElementById('adicionarCartaoModal')).show();
            }
        });
    });
</script>

@endsection