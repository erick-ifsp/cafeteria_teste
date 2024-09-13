<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Financeiro;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Verifica se o usuário é admin
        if (auth()->user()->can('access')) {
            // Retorna todos os pedidos se for admin
            $pedidos = Pedido::with('usuario')->orderBy('id', 'desc')->get();
        } else {
            // Retorna apenas os pedidos do usuário autenticado se não for admin
            $pedidos = Pedido::where('user_id', auth()->id())->with('usuario')->orderBy('id', 'desc')->get();
        }

        return view('pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('pedidoProdutos.produto')
            ->firstOrFail();

        return view('pedidos.show', compact('pedido'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $status = $request->input('status');

        if (is_null($status) || !in_array($status, ['Pronto', 'Concluído'])) {
            return redirect()->back()->with('error', 'Status inválido.');
        }

        if ($status === 'Pronto') {
            $pedido->status = 'Pronto';
            $pedido->save();
            return redirect()->back()->with('success', 'Pedido marcado como pronto.');
        } elseif ($status === 'Concluído') {
            $pedido->status = 'Concluído';
            $pedido->save();

            foreach ($pedido->pedidoProdutos as $produto) {
                Financeiro::create([
                    'user_id' => $pedido->user_id,
                    'nome' => $produto->produto->nome,
                    'descricao' => 'Pedido realizado por: ' . $pedido->usuario->name,
                    'tipo' => 'Venda',
                    'valor' => $produto->quantidade * $produto->preco_unitario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Pedido concluído e registrado no financeiro.');
        }
    }

    public function gerarNotaFiscal($id)
    {
        $pedido = Pedido::with('produtos', 'usuario')->findOrFail($id);

        // Carrega a view que será usada para o PDF
        $pdf = PDF::loadView('pdf.nota_fiscal', compact('pedido'));

        // Retorna o PDF para download ou exibição
        return $pdf->download('nota_fiscal_pedido_' . $pedido->id . '.pdf');
    }

    public function store(Request $request)
    {
        // Remove o "R$" e converte a vírgula decimal para ponto
        $request->merge([
            'total' => str_replace(['R$', '.', ','], ['', '', '.'], $request->total)
        ]);

        // Validação
        $request->validate([
            'cliente' => 'required|string|max:35',
            'produtos' => 'required|array',
            'total' => 'required|numeric|min:0',
            'metodo_pagamento' => 'required|string|max:35'
        ]);

        // Cria o pedido
        $pedido = Pedido::create([
            'user_id' => auth()->id(),  // O funcionário que criou o pedido
            'total' => $request->total,
            'status' => 'Pendente',     // Status inicial do pedido
        ]);

        // Adiciona produtos ao pedido
        foreach ($request->produtos as $produtoId => $produtoData) {
            if ($produtoData['quantidade'] > 0) {
                $produto = Produto::find($produtoId);
                if ($produto) {
                    $pedido->pedidoProdutos()->create([
                        'produto_id' => $produto->id,
                        'quantidade' => $produtoData['quantidade'],
                        'preco_unitario' => $produto->preco,
                        'metodo_pagamento' => $request->metodo_pagamento  // Corrigido
                    ]);
                }
            }
        }

        return redirect()->route('pedidos')->with('success', 'Pedido criado com sucesso!');
    }

    public function create()
    {
        // Listar todos os produtos para serem exibidos no formulário de criação de pedido
        $produtos = Produto::all();

        // Renderiza a página de criação de pedido manual
        return view('pedidos.create', compact('produtos'));
    }
}
