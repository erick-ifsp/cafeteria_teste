<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', ['pedidos' => $pedidos]);
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        Pedido::create($request->all());
        return redirect()->route('pedidos');
    }

    public function edit($id)
    {
        $pedidos = Pedido::where('id',$id)->first();
        if (!empty($pedidos)) {
            return view('pedidos.edit', ['pedidos' => $pedidos]);
        } else {
            return redirect()->route('pedidos');
        } 
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nome' => $request->nome,
            'preco'=> $request->preco,
        ];
        Pedido::where('id', $id)->update($data);
        return redirect()->route('pedidos');
    }

    public function destroy($id)
    {
        Pedido::where('id', $id)->delete();
        return redirect()->route('pedidos');
    }
}
