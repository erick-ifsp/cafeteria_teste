<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cartao;

class CartaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string',
            'nome' => 'required|string',
            'data' => 'required|string',
            'cvv' => 'required|string',
        ]);

        Cartao::create([
            'user_id' => auth()->id(),
            'numero' => $request->numero,
            'nome' => $request->nome,
            'data' => $request->data,
            'cvv' => $request->cvv,
        ]);

        return redirect()->back()->with('success', 'Cartão adicionado com sucesso!');
    }
}
