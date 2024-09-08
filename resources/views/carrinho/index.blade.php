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
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#removerModal-{{ $item->id }}">Remover</button>
                                </td>
                            </tr>

                            <!-- Modal Remover Produto -->
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
                                                <button class="btn btn-danger" type="submit">Remover</button>
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
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finalizarCompraModal">Finalizar
                    Compra</button>
            </div>
        </div>

        <!-- Modal Finalizar Compra -->
        <div class="modal fade" id="finalizarCompraModal" tabindex="-1" aria-labelledby="finalizarCompraLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Compra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente finalizar a compra?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('carrinho.finalizar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @else
        <p class="text-left h6">Seu carrinho está vazio. Acesse o <a href="{{ url('cardapio') }}">Cardápio</a> e veja nossos
            produtos!</p>
    @endif
</div>

<script>
    document.querySelectorAll('.quantidade').forEach(function (input) {
        input.addEventListener('change', function () {
            var itemId = this.getAttribute('data-id');
            var quantidade = this.value;

            fetch('/carrinho/' + itemId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantidade: quantidade
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const subtotalElement = this.closest('tr').querySelector('.subtotal');
                        subtotalElement.innerText = 'R$ ' + data.subtotal;
                        document.getElementById('total-carrinho').innerText = 'R$ ' + data.total;
                    } else {
                        console.error('Erro na resposta JSON', data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao atualizar o carrinho:', error);
                });
        });
    });
</script>
@endsection