@extends('layouts.gerenciamento')

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
                                    <input type="number" name="quantidade" class="form-control quantidade" value="1" min="1"
                                        max="50" style="width: 65px; text-align: center;">
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
                                    <option value="" selected>Escolha um método</option>
                                    <option value="cartao">Cartão</option>
                                    <option value="pix">PIX</option>
                                    <option value="dinheiro">Dinheiro</option>
                                </select>
                            </div>
                            <div id="pix-section" class="d-none mb-3">
                                <label for="pix" class="form-label">Chave PIX</label>
                                <input type="text" id="pix" name="pix" class="form-control" readonly>
                                <div id="pix-qrcode" class="mt-2">
                                </div>
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
                            <div class="mb-3">
                                <label for="entrega" class="form-label">Tipo de Entrega</label>
                                <select id="entrega" name="entrega" class="form-select" required>
                                    <option value="" selected>Escolha uma opção</option>
                                    <option value="retirada">Retirar na loja</option>
                                    <option value="entrega">Entrega</option>
                                </select>
                            </div>
                            <div id="endereco-section" class="d-none mb-3">
                                <label for="endereco" class="form-label">Escolha um endereço</label>
                                <select id="endereco" name="endereco" class="form-select">
                                    @forelse ($enderecos as $endereco)
                                        <option value="{{ $endereco->id }}">{{ $endereco->rua }}, {{ $endereco->cidade }} -
                                            {{ $endereco->estado }} - {{ $endereco->cep }}
                                        </option>
                                    @empty
                                        <option value="">Nenhum endereço cadastrado</option>
                                    @endforelse
                                    <option value="novo">Adicionar Novo Endereço</option>
                                </select>
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

        <div class="modal fade" id="adicionarCartaoModal" tabindex="-1" aria-labelledby="adicionarCartaoLabel"
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
                                <label for="numero_cartao" class="form-label">Número do Cartão</label>
                                <input type="text" id="numero_cartao" name="numero_cartao" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="nome_cartao" class="form-label">Nome no Cartão</label>
                                <input type="text" id="nome_cartao" name="nome_cartao" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                <input type="text" id="data_vencimento" name="data_vencimento" class="form-control"
                                    placeholder="MM/AAAA" required>
                            </div>
                            <div class="mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn" style="background-color: #98C9A3">Adicionar
                                    Cartão</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="adicionarEnderecoModal" tabindex="-1" aria-labelledby="adicionarEnderecoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Novo Endereço</h5>
                    </div>
                    <div class="modal-body">
                        <form id="adicionarEnderecoForm" action="{{ route('enderecos.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rua" class="form-label">Rua</label>
                                <input type="text" id="rua" name="rua" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" id="cidade" name="cidade" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" id="estado" name="estado" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" id="cep" name="cep" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn" style="background-color: #98C9A3">Adicionar
                                    Endereço</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-left h6">Seu carrinho está vazio. Acesse o <strong><a href="{{ url('cardapio') }}" class="txt"
                    style="color: #35221B">Cardápio</a></strong> e veja nossos
            produtos ou acesse seus <strong><a href="{{ url('pedidos') }}" class="txt"
                    style="color: #35221B">Pedidos</a></strong>!</p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fecha o modal de pagamento quando o modal de adicionar cartão abre
        $('#adicionarCartaoModal').on('show.bs.modal', function () {
            $('#finalizarCompraModal').modal('hide');
        });

        // Reabre o modal de pagamento quando o modal de adicionar cartão fecha
        $('#adicionarCartaoModal').on('hidden.bs.modal', function () {
            $('#finalizarCompraModal').modal('show');
        });

        // Fecha o modal de pagamento quando o modal de adicionar endereço abre
        $('#adicionarEnderecoModal').on('show.bs.modal', function () {
            $('#finalizarCompraModal').modal('hide');
        });

        // Reabre o modal de pagamento quando o modal de adicionar endereço fecha
        $('#adicionarEnderecoModal').on('hidden.bs.modal', function () {
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

        // Código existente para troca de tipo de entrega
        const entregaSelect = document.getElementById('entrega');
        const enderecoSection = document.getElementById('endereco-section');
        const enderecoSelect = document.getElementById('endereco');

        entregaSelect.addEventListener('change', function () {
            if (this.value === 'entrega') {
                enderecoSection.classList.remove('d-none');
            } else {
                enderecoSection.classList.add('d-none');
            }
        });

        enderecoSelect.addEventListener('change', function () {
            if (this.value === 'novo') {
                new bootstrap.Modal(document.getElementById('adicionarEnderecoModal')).show();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const quantidadeInputs = document.querySelectorAll('.quantidade');
        const totalCarrinhoElement = document.getElementById('total-carrinho');

        quantidadeInputs.forEach(input => {
            input.addEventListener('input', function () {
                const quantidade = parseInt(this.value);
                const itemId = this.dataset.id;
                const row = this.closest('tr');
                const precoUnitarioElement = row.querySelector('td:nth-child(3)');
                const subtotalElement = row.querySelector('.subtotal');

                const precoUnitario = parseFloat(precoUnitarioElement.textContent.replace('R$', '').replace('.', '').replace(',', '.').trim());
                const subtotal = (quantidade * precoUnitario).toFixed(2).replace('.', ',');

                // Atualiza o subtotal
                subtotalElement.textContent = 'R$ ' + subtotal;

                // Atualiza o total do carrinho
                atualizarTotalCarrinho();
            });
        });

        function atualizarTotalCarrinho() {
            let total = 0;

            document.querySelectorAll('.quantidade').forEach(input => {
                const quantidade = parseInt(input.value);
                const row = input.closest('tr');
                const precoUnitarioElement = row.querySelector('td:nth-child(3)');
                const precoUnitario = parseFloat(precoUnitarioElement.textContent.replace('R$', '').replace('.', '').replace(',', '.').trim());

                total += quantidade * precoUnitario;
            });

            totalCarrinhoElement.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
        }
    });

    $noFooter = true;
</script>
@endsection