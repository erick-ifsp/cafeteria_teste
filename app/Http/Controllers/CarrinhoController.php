<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\Cartao;
use App\Models\Pedido;
use App\Models\PedidoProduto;

class CarrinhoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewCarrinho()
    {
        $user = auth()->user();
        $carrinhoItems = Carrinho::where('user_id', $user->id)->with('produto')->get();
        $cartoes = Cartao::where('user_id', $user->id)->get();

        if ($carrinhoItems->isEmpty()) {
            return view('carrinho.index')->with([
                'message' => 'Seu carrinho está vazio.',
                'cartoes' => $cartoes
            ]);
        }

        return view('carrinho.index', compact('carrinhoItems', 'cartoes'));
    }

    public function AdicionarCarrinho(Request $request, $produtoId)
    {
        $tipo = $request->input('tipo');
        $quantidade = $request->input('quantidade', 1);

        if (is_null($tipo)) {
            return redirect()->back()->with('error', 'O tipo do produto não pode ser nulo.');
        }

        $carrinhoItem = Carrinho::where('user_id', auth()->id())
            ->where('produto_id', $produtoId)
            ->where('tipo', $tipo)
            ->first();

        if ($carrinhoItem) {
            $carrinhoItem->quantidade += $quantidade;
        } else {
            $carrinhoItem = new Carrinho();
            $carrinhoItem->user_id = auth()->id();
            $carrinhoItem->produto_id = $produtoId;
            $carrinhoItem->tipo = $tipo;
            $carrinhoItem->quantidade = $quantidade;
        }

        $carrinhoItem->save();

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function RemoverCarrinho($carrinhoItemId)
    {
        $carrinhoItem = Carrinho::where('user_id', auth()->id())
            ->where('id', $carrinhoItemId)
            ->first();

        if ($carrinhoItem) {
            $carrinhoItem->delete();
        }

        return redirect()->back()->with('success', 'Produto removido do carrinho!');
    }

    public function AtualizarCarrinho(Request $request, $carrinhoItemId)
    {
        $item = Carrinho::where('id', $carrinhoItemId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->quantidade = $request->quantidade;
        $item->save();

        $subtotal = $item->produto->preco * $item->quantidade;
        $total = Carrinho::where('user_id', auth()->id())
            ->get()
            ->sum(function ($carrinhoItem) {
                return $carrinhoItem->produto->preco * $carrinhoItem->quantidade;
            });

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2, ',', '.'),
            'total' => number_format($total, 2, ',', '.')
        ]);
    }

    public function finalizarCompra(Request $request)
    {
        $user = auth()->user();
        $carrinhoItems = Carrinho::where('user_id', $user->id)->get();

        $pedido = Pedido::create([
            'user_id' => $user->id,
            'total' => $carrinhoItems->sum(function ($item) {
                return $item->produto->preco * $item->quantidade;
            }),
            'status' => 'Pendente',
            'metodo_pagamento' => $request->input('metodo_pagamento'),
            'cartao_id' => $request->input('cartao') ?? null, // Adicionando o ID do cartão se for pago com cartão
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($carrinhoItems as $item) {
            PedidoProduto::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $item->produto_id,
                'quantidade' => $item->quantidade,
                'preco_unitario' => $item->produto->preco,
            ]);
        }

        Carrinho::where('user_id', $user->id)->delete();

        return redirect()->route('carrinho.index')->with('success', 'Compra realizada com sucesso!');
    }
}
