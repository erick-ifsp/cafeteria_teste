<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\Cartao;
use App\Models\Pedido;
use App\Models\Endereco;
use App\Models\Notas_fiscais;
use App\Models\PedidoProduto;
use App\Models\Variacao;

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
        $enderecos = Endereco::where('user_id', $user->id)->get();

        if ($carrinhoItems->isEmpty()) {
            return view('carrinho.index')->with([
                'message' => 'Seu carrinho está vazio.',
                'cartoes' => $cartoes,
                'enderecos' => $enderecos
            ]);
        }

        return view('carrinho.index', compact('carrinhoItems', 'cartoes', 'enderecos'));
    }

    public function AdicionarCarrinho(Request $request, $produtoId)
    {
        $tipo = $request->input('tipo');
        $quantidade = $request->input('quantidade', 1);

        if (is_null($tipo)) {
            return redirect()->back()->with('error', 'O tipo do produto não pode ser nulo.');
        }

        $variacao = Variacao::where('nome', $tipo)->first();

        if (is_null($variacao)) {
            return redirect()->back()->with('error', 'Tipo de produto não encontrado.');
        }

        $carrinhoItem = Carrinho::where('user_id', auth()->id())
            ->where('produto_id', $produtoId)
            ->where('tipo', $variacao->nome)
            ->first();

        if ($carrinhoItem) {
            $carrinhoItem->quantidade += $quantidade;
        } else {
            $carrinhoItem = new Carrinho();
            $carrinhoItem->user_id = auth()->id();
            $carrinhoItem->produto_id = $produtoId;
            $carrinhoItem->tipo = $variacao->nome;
            $carrinhoItem->quantidade = $quantidade;
            $carrinhoItem->preco = (float) $variacao->preco;
        }

        if (!$carrinhoItem->save()) {
            \Log::error('Erro ao salvar o carrinho:', $carrinhoItem->getErrors());
            return redirect()->back()->with('error', 'Erro ao adicionar produto ao carrinho.');
        }

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

    public function pagar(Request $request)
    {
        $user = auth()->user();
        $carrinhoItems = Carrinho::where('user_id', $user->id)->with('produto')->get();
        $cartoes = Cartao::where('user_id', $user->id)->get();
        $enderecos = Endereco::where('user_id', $user->id)->get();

        $enderecoId = null;
        $endereco = null;
        if ($request->input('endereco') === 'novo') {
            $endereco = Endereco::create([
                'user_id' => $user->id,
                'cpf' => $request->input('cpf'),
                'rua' => $request->input('rua'),
                'cidade' => $request->input('cidade'),
                'estado' => $request->input('estado'),
                'cep' => $request->input('cep'),
            ]);
            $enderecoId = $endereco->id;
        } else {
            $enderecoId = $request->input('endereco');
        }

        return view('carrinho.pagar', compact('carrinhoItems', 'enderecos'));
    }
}
