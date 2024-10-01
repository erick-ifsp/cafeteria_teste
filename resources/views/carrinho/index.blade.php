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
                                <td class="align-middle">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                <td class="align-middle">
                                    <input type="number" name="quantidade" class="form-control quantidade"
                                        value="{{ $item->quantidade }}" min="1" max="50"
                                        style="width: 65px; text-align: center;" data-id="{{ $item->id }}">

                                </td>
                                <td class="align-middle subtotal">
                                    R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
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
                                            <button type="button" class="btn" style="background-color: #35221B; color: #f1f1f1"
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
            return $item->preco * $item->quantidade; }), 2, ',', '.') }}</span>
                </h4>

                <a href="{{ route('carrinho.pagar')}} " class="btn" style="background-color: #98C9A3">Continuar</a>
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

                subtotalElement.textContent = 'R$ ' + subtotal;

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
</script>
@endsection