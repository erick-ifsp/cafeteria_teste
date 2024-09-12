<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #f1f1f1;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header div {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .period {
            text-align: right;
            font-size: 14px;
            margin-top: -10px;
        }

        .section-title {
            font-size: 16px;
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            font-size: 14px;
            border: 1px solid #ddd;
            /* Divisórias entre os valores */
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
        }

        .total-section .value {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Relatório Financeiro</h1>
        <div class="header">
            <div>
                <p><strong>Empresa</strong>: Cafeteria</p>
                <p><strong>Endereço</strong>: Rua Monsenhor José Vita, 280 - Abernéssia, Campos do Jordão - SP,
                    12460-000</p>
            </div>
            <div>
                <p><strong>Email</strong>: contato@cafeteria.com</p>
                <p class="period"><strong>Data do Relatório</strong>: {{ $timestamp }}</p>
            </div>
        </div>

        <div class="section-title">Receita</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendasQuantidade as $nome => $detalhes)
                    <tr>
                        <td>{{ $nome }}</td>
                        <td>{{ $detalhes['quantidade'] }}</td>
                        <td>R$ {{ number_format($detalhes['valor_total'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Vendas Totais</strong></td>
                    <td></td>
                    <td><strong>R$ {{ number_format($totalVendas, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Estoque</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financeiros->where('tipo', 'Estoque') as $financeiro)
                    <tr>
                        <td>{{ $financeiro->nome }}</td>
                        <td>R$ {{ number_format($financeiro->valor, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Estoque Total</strong></td>
                    <td><strong>R$ {{ number_format($totalEstoque, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Despesas</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financeiros->where('tipo', 'Despesa')->where('descricao', '!=', 'Salários') as $financeiro)
                    <tr>
                        <td>{{ $financeiro->nome }}</td>
                        <td>R$ {{ number_format(abs($financeiro->valor), 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Despesas Totais</strong></td>
                    <td><strong>R$ {{ number_format(abs($totalDespesas), 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <p>Receita Bruta: <span class="value">R$ {{ number_format($totalVendas, 2, ',', '.') }}</span></p>
            <p>Despesas Totais: <span class="value">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</span></p>
            <p>Impostos (18%): <span class="value">R$ {{ number_format($valorImposto, 2, ',', '.') }}</span></p>
            <p>Lucro Antes do Imposto: <span class="value">R$
                    {{ number_format($lucroAntesImposto, 2, ',', '.') }}</span></p>
            <p>Lucro Líquido: <span class="value">R$ {{ number_format($lucroLiquido, 2, ',', '.') }}</span></p>
        </div>
    </div>
</body>

</html>