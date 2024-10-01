<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Recibo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 10mm;
            border: 1px solid black;
            box-sizing: border-box;
            text-align: center;
        }

        .header {
            text-align: center;
            padding: 5px;
            background-color: #f7f7f7;
            font-size: 14px;
            font-weight: bold;
        }

        .sub-header {
            text-align: center;
            padding: 5px;
            background-color: #fff;
            font-size: 12px;
        }

        .details,
        .calculation,
        .additional-info {
            margin: 10px 0;
        }

        .details-table,
        .product-table,
        .calculation-table,
        .additional-info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            max-width: 100%;
        }

        .details-table td,
        .product-table th,
        .product-table td,
        .calculation-table td,
        .additional-info-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .product-table th {
            background-color: #f7f7f7;
        }

        .footer {
            text-align: center;
            padding: 5px;
            font-size: 10px;
            background-color: #f7f7f7;
        }

        .title {
            font-weight: bold;
        }

        .small-text {
            font-size: 8px;
        }

        .company-info-table {
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid black;
        }

        .company-logo {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Recibo
        </div>

        <div class="sub-header">
            <p><strong>Cafeteria</strong> - Documento Sem Valor Fiscal</p>
            <p>Pedido nº {{ $pedido->id }}</p>
        </div>

        <div class="company-info">
            <table class="company-info-table">
                <tr>
                    <td style="width: 30%;">
                        <img class="company-logo" src="images/logo_café.png" alt="Logo da Cafeteria">
                    </td>
                    <td style="width: 70%; text-align: left;">
                        <strong>Cafeteria</strong><br>
                        <strong>CNPJ:</strong> 12.345.678/0001-90<br>
                        <strong>Endereço:</strong> Rua Monsenhor José Vita, 280, Abernéssia<br>
                        <strong>Município:</strong> Campos do Jordão - SP<br>
                        <strong>Telefone:</strong> (12) 99999-9999 <br>
                        <strong>Email:</strong> contato@cafeteria.com.br
                    </td>
                </tr>
            </table>
        </div>

        <div class="details">
            <table class="details-table">
                <tr>
                    <td colspan="2"><strong>Destinatário/Remetente</strong></td>
                </tr>
                <tr>
                    <td>
                        <strong>Nome:</strong> {{ $pedido->usuario->name ?? 'Sem informação' }}<br>
                        <strong>CPF:</strong> {{ $pedido->usuario->endereco->cpf ?? 'Sem informação' }}<br>
                        <strong>Endereço:</strong> {{ $pedido->usuario->endereco->rua ?? 'Sem informação' }},
                        {{ $pedido->usuario->endereco->cidade ?? 'Sem informação' }},
                        {{ $pedido->usuario->endereco->estado ?? 'Sem informação' }}<br>
                        <strong>Município:</strong> {{ $pedido->usuario->endereco->cidade ?? 'Sem informação' }}<br>
                        <strong>Telefone:</strong> (12) 99999-9999
                    </td>
                    <td>
                        <strong>Data de Emissão:</strong>
                        {{ $pedido->created_at->format('d/m/Y') ?? 'Sem informação' }}<br>
                        <strong>Chave de Acesso:</strong> 43.0908.90.627.936/0001-30-55-001-000.0.175-000.896.536<br>
                        <strong>Protocolo de Autorização:</strong> 000.0.175-000.896.536
                    </td>
                </tr>
            </table>
        </div>

        <div class="details">
            <table class="product-table">
                <thead>
                    <tr>
                        <th style="width: 60%;">Descrição do Produto/Serviço</th>
                        <th style="width: 10%;">Qtd</th>
                        <th style="width: 10%;">Unidade</th>
                        <th style="width: 10%;">Valor Unitário</th>
                        <th style="width: 10%;">Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedido->produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome ?? 'Sem informação' }}</td>
                            <td>{{ $produto->pivot->quantidade ?? 'Sem informação' }}</td>
                            <td>Un</td>
                            <td>{{ number_format($produto->preco ?? 0, 2, ',', '.') }}</td>
                            <td>{{ number_format(($produto->pivot->quantidade ?? 0) * ($produto->preco ?? 0), 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="calculation">
            <table class="calculation-table">
                <tr>
                    <td colspan="2"><strong>Cálculo do Imposto</strong></td>
                </tr>
                <tr>
                    <td>Base de Cálculo do ICMS: R$ {{ number_format($pedido->total * 0.12, 2, ',', '.') }}</td>
                    <td>Valor do ICMS: R$ {{ number_format($pedido->total * 0.18, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Valor do Produto: R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                    <td>Valor Total da Nota: R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="additional-info">
            <table class="additional-info-table">
            </table>
        </div>

        <div class="footer small-text">
            <p>Documento sem valor fiscal. Obrigado por comprar na nossa cafeteria!</p>
            <p>Ambiente de homologação - Documento sem valor fiscal</p>
        </div>
    </div>
</body>

</html>