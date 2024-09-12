<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financeiro;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        // Obter os parâmetros de filtro e ordenação
        $nome = $request->input('nome');
        $ordem = $request->input('ordem');
        $tipo = $request->input('tipo');
        $produto = $request->input('produto');
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        // Consulta inicial
        $query = Financeiro::query();

        // Aplicar filtro de busca pelo nome
        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }

        // Aplicar filtro de tipo
        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        // Aplicar filtro de data
        if ($dataInicio && $dataFim) {
            $query->whereBetween('updated_at', [$dataInicio, $dataFim]);
        } elseif ($dataInicio) {
            $query->whereDate('updated_at', '>=', $dataInicio);
        } elseif ($dataFim) {
            $query->whereDate('updated_at', '<=', $dataFim);
        }

        // Aplicar filtro de produto na descrição
        if ($produto) {
            $query->where('descricao', 'like', "%{$produto}%");
        }

        // Aplicar ordenação
        switch ($ordem) {
            case 'az':
                $query->orderBy('nome', 'asc');
                break;
            case 'za':
                $query->orderBy('nome', 'desc');
                break;
            case 'preco_asc':
                $query->orderBy('valor', 'asc');
                break;
            case 'preco_desc':
                $query->orderBy('valor', 'desc');
                break;
            case 'ultima_editada':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'primeira_editada':
                $query->orderBy('updated_at', 'asc');
                break;
            default:
                $query->orderBy('updated_at', 'desc'); // Ordenação padrão
                break;
        }

        // Obter os resultados da consulta
        $financeiros = $query->get();
        $total = $financeiros->sum('valor'); // Calcula a soma total dos valores

        // Passar os dados para a view
        return view('financeiro.index', [
            'financeiros' => $financeiros,
            'total' => $total,
        ]);
    }

    public function show($id)
    {
        $transacao = Financeiro::where('user_id', Auth::id())->findOrFail($id);
        return view('financeiro.show', compact('transacao'));
    }

    public function generatePdf(Request $request)
    {
        // Filtros opcionais por data, tipo ou outros critérios
        $query = Financeiro::query();

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('updated_at', [$request->input('data_inicio'), $request->input('data_fim')]);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        $financeiros = $query->get();

        $vendasQuantidade = $financeiros->where('tipo', 'Venda')
        ->groupBy('nome')
        ->map(function ($vendas) {
            return [
                'quantidade' => $vendas->count(),
                'valor_total' => $vendas->sum('valor')
            ];
        });

        // Calculando os totais com base no tipo
        $totalVendas = $financeiros->where('tipo', 'Venda')->sum('valor');
        $totalEstoque = $financeiros->where('tipo', 'Estoque')->sum('valor');
        $totalDespesas = $financeiros->where('tipo', 'Despesa')->sum('valor');
        $totalSalarios = $financeiros->where('descricao', 'Salários')->sum('valor');

        // Cálculo de impostos e lucro
        $taxaImposto = 0.18; // 19% de imposto
        $valorImposto = $totalVendas * $taxaImposto;
        $lucroAntesImposto = $totalVendas + $totalDespesas;
        $lucroLiquido = $lucroAntesImposto - $valorImposto;

        // Gerar o timestamp do relatório
        $timestamp = now()->format('d/m/Y H:i');

        // Preparar os dados para a view
        $data = [
            'vendasQuantidade' => $vendasQuantidade,
            'financeiros' => $financeiros,
            'totalVendas' => $totalVendas,
            'totalEstoque' => $totalEstoque,
            'totalDespesas' => $totalDespesas,
            'totalSalarios' => $totalSalarios,
            'valorImposto' => $valorImposto,
            'lucroAntesImposto' => $lucroAntesImposto,
            'lucroLiquido' => $lucroLiquido,
            'timestamp' => $timestamp,
        ];

        // Gerar o PDF com base na view e nos dados
        $pdf = Pdf::loadView('financeiro.pdf', $data);

        // Retornar o PDF para download
        return $pdf->download('relatorio-financeiro.pdf');
    }
}
