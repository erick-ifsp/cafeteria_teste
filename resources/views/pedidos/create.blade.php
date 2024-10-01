@extends('layouts.gerenciamento')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Criar Pedido</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedidos.store') }}" method="POST" class="mt-3 mb-5">
        @csrf
        <div class="form-group mb-3">
            <label for="cliente">Nome do Cliente:</label>
            <input type="text" id="cliente" maxlength="50" name="cliente" class="form-control" required>
        </div>

        <h4 class="mb-3">Produtos</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th class="quantity-col">Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="product-list">
                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td>
                            <input type="number" name="produtos[{{ $produto->id }}][quantidade]" value="0" min="0"
                                class="form-control quantity-input"  value="0" min="0"
                                max="50" data-preco="{{ $produto->preco }}" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm add-product" style="background-color: #35221B; color: #f1f1f1" data-id="{{ $produto->id }}"
                                data-name="{{ $produto->nome }}" data-preco="{{ $produto->preco }}">+</button>
                            <button type="button" class="btn btn-sm btn-danger remove-product"
                                data-id="{{ $produto->id }}">-</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3">
            <label for="metodo_pagamento">Método de Pagamento:</label>
            <select id="metodo_pagamento" name="metodo_pagamento" class="form-select" required>
                <option value="" selected>Escolha um método</option>
                <option value="cartao">Cartão</option>
                <option value="pix">PIX</option>
                <option value="dinheiro">Dinheiro</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="total">Total:</label>
            <input type="text" id="total" name="total" class="form-control" readonly value="R$ 0,00">
        </div>

        <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Criar Pedido</button>
    </form>
</div>

<style>
    .quantity-col {
        width: 120px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productList = document.getElementById('product-list');
        const totalField = document.getElementById('total');
        let total = 0;

        productList.addEventListener('click', function (event) {
            if (event.target.matches('.add-product') || event.target.matches('.remove-product')) {
                updateQuantity(event);
                updateTotal();
            }
        });

        productList.addEventListener('input', function (event) {
            if (event.target.matches('.quantity-input')) {
                updateTotal();
            }
        });

        function updateQuantity(event) {
            const button = event.target;
            const input = button.closest('tr').querySelector('.quantity-input');
            let quantity = parseInt(input.value) || 0;

            if (button.classList.contains('add-product')) {
                quantity++;
            } else if (button.classList.contains('remove-product')) {
                quantity = Math.max(0, quantity - 1);
            }

            input.value = quantity;
            input.dispatchEvent(new Event('input'));
        }

        function updateTotal() {
            total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const quantidade = parseInt(input.value) || 0;
                const preco = parseFloat(input.getAttribute('data-preco'));
                total += quantidade * preco;
            });
            totalField.value = 'R$ ' + total.toFixed(2).replace('.', ',');
        }

        document.querySelector('form').addEventListener('submit', function () {
            totalField.value = total.toFixed(2);
        });
    });
</script>
@endsection