<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financeiro;
use Illuminate\Support\Facades\Auth;

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
        if ($dataInicio) {
            $query->whereDate('updated_at', '>=', $dataInicio);
        }
        if ($dataFim) {
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
}
