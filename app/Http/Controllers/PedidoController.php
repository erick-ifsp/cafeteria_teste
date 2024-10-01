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
        if (auth()->user()->can('func')) {
            $pedidos = Pedido::with('usuario')->orderBy('id', 'desc')->get();
        } else {
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

    public function atualizarStatus(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $statusAntigo = $pedido->status;
        $pedido->status = $request->input('status');
        $pedido->save();

        if ($pedido->status === 'Concluído') {
            $this->adicionarVenda($pedido);

            if ($statusAntigo === 'Estorno') {
                $this->removerDespesa($pedido);
            }
        } elseif ($pedido->status === 'Estorno') {
            $this->registrarDespesa($pedido);

            if ($statusAntigo === 'Concluído') {
                $this->removerVenda($pedido);
            }
        } elseif ($statusAntigo === 'Concluído' || $statusAntigo === 'Estorno') {
            if (in_array($pedido->status, ['Pendente', 'Em Produção', 'A Caminho'])) {
                $this->removerVenda($pedido);
                $this->removerDespesa($pedido);
            }
        } elseif ($statusAntigo === 'Concluído') {
            $this->removerVenda($pedido);
        }

        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }

    private function removerDespesa(Pedido $pedido)
    {
        Financeiro::where('gerenciamento_id', $pedido->id)
            ->where('tipo', 'Despesa')
            ->delete();
    }

    private function adicionarVenda(Pedido $pedido)
    {
        foreach ($pedido->pedidoProdutos as $pedidoProduto) {
            $produto = $pedidoProduto->produto;

            if ($produto) {
                Financeiro::create([
                    'user_id' => auth()->id(),
                    'gerenciamento_id' => $pedido->id,
                    'nome' => $produto->nome,
                    'descricao' => 'Venda de ' . $produto->nome . ' do pedido realizado por: ' . $pedido->usuario->name,
                    'tipo' => 'Venda',
                    'valor' => $pedidoProduto->preco_unitario * $pedidoProduto->quantidade,
                    'data' => now(),
                ]);
            }
        }
    }

    private function registrarDespesa(Pedido $pedido)
    {
        foreach ($pedido->pedidoProdutos as $pedidoProduto) {
            $produto = $pedidoProduto->produto;

            if ($produto) {
                Financeiro::create([
                    'user_id' => auth()->id(),
                    'gerenciamento_id' => $pedido->id,
                    'nome' => $produto->nome,
                    'descricao' => 'Despesa de ' . $produto->nome . ' do pedido realizado por: ' . $pedido->usuario->name,
                    'tipo' => 'Despesa',
                    'valor' => -abs($pedidoProduto->preco_unitario * $pedidoProduto->quantidade),
                    'data' => now(),
                ]);
            }
        }
    }

    private function removerVenda(Pedido $pedido)
    {
        Financeiro::where('gerenciamento_id', $pedido->id)
            ->where('tipo', 'Venda')
            ->delete();
    }

    public function gerarNotaFiscal($id)
    {
        $pedido = Pedido::with('produtos', 'usuario')->findOrFail($id);

        $pdf = PDF::loadView('pdf.nota_fiscal', compact('pedido'));

        return $pdf->download('nota_fiscal_pedido_' . $pedido->id . '.pdf');
    }

    public function store(Request $request)
    {
        $request->merge([
            'total' => str_replace(['R$', '.', ','], ['', '', '.'], $request->total)
        ]);

        $request->validate([
            'cliente' => 'required|string|max:35',
            'produtos' => 'required|array',
            'total' => 'required|numeric|min:0',
            'metodo_pagamento' => 'required|string|max:35'
        ]);

        $pedido = Pedido::create([
            'user_id' => auth()->id(),
            'total' => $request->total,
            'status' => 'Pendente',
        ]);

        foreach ($request->produtos as $produtoId => $produtoData) {
            if ($produtoData['quantidade'] > 0) {
                $produto = Produto::find($produtoId);
                if ($produto) {
                    $pedido->pedidoProdutos()->create([
                        'produto_id' => $produto->id,
                        'quantidade' => $produtoData['quantidade'],
                        'preco_unitario' => $produto->preco,
                        'metodo_pagamento' => $request->metodo_pagamento
                    ]);
                }
            }
        }

        return redirect()->route('pedidos')->with('success', 'Pedido criado com sucesso!');
    }

    public function create()
    {
        $produtos = Produto::all();

        return view('pedidos.create', compact('produtos'));
    }
}
