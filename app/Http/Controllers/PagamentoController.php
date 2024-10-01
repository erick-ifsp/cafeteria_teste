<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use App\Models\Carrinho;
use App\Models\PedidoProduto;
use App\Models\Pedido;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PagamentoController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function checkout(): View|Factory|Application
    {
        $user = auth()->user();
        $carrinhoItems = Carrinho::where('user_id', $user->id)->with('produto')->get();
        return view('carrinho.index', compact('carrinhoItems'));
    }

    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */
    public function cartao(): RedirectResponse
    {
        Stripe::setApiKey('sk_test_51Q4s3QE9igCg6bKZG6Evh297FlIwgjCLxO5LyZunEOKmeR3Mxnhc6iB3r0KNoz1m2IO7LM2SkMYsdaEDmAZ0EudL0034bar7gP');

        $user = auth()->user();

        $carrinhoItems = Carrinho::where('user_id', $user->id)->with('produto')->get();

        if ($carrinhoItems->isEmpty()) {
            return redirect()->back()->with('error', 'Seu carrinho está vazio.');
        }

        $lineItems = $carrinhoItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $item->produto->nome,
                    ],
                    'unit_amount' => $item->preco * 100,
                ],
                'quantity' => $item->quantidade,
            ];
        })->toArray();

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('pagamento.success'),
            'cancel_url' => route('carrinho.index'),
        ]);

        return redirect()->away($session->url);
    }

    /**
     * @return View|Factory|Application
     */
    public function success(Request $request): View|Factory|Application
    {
        $user = auth()->user();
        $enderecoId = null;

        $carrinhoItems = Carrinho::where('user_id', $user->id)->get();

        // Criar o pedido
        $pedido = Pedido::create([
            'user_id' => $user->id,
            'total' => $carrinhoItems->sum(function ($item) {
                return $item->preco * $item->quantidade;
            }),
            'status' => 'Pendente',
            'metodo_pagamento' => $request->input('metodo_pagamento'),
            'cartao_id' => $request->input('cartao') ?? null,
            'entrega' => $request->input('entrega'),
            'endereco_id' => $enderecoId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($carrinhoItems as $item) {
            PedidoProduto::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $item->produto_id,
                'quantidade' => $item->quantidade,
                'preco_unitario' => $item->preco,
            ]);
        }

        Carrinho::where('user_id', $user->id)->delete();

        $pedido = Pedido::where('user_id', auth()->id())
            ->with('usuario')
            ->latest()
            ->first();

        return view('pagamento.success', compact('pedido'));
    }

    public function pix(Request $request)
    {
        $copiaCola = '00020126760014BR.GOV.BCB.PIX0114+55119999999935204000053039865802BR5925MERCHANT NAME6009SAO PAULO62070503***6304' . rand(1000, 9999);

        $qrCode = QrCode::create($copiaCola);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getString();

        return view('pagamento.pix', ['copiaCola' => $copiaCola, 'qrCodeImage' => base64_encode($qrCodeImage)]);
    }
}
