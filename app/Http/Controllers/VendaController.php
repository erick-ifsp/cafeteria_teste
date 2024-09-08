<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::all();
        return view('vendas.index', ['vendas' => $vendas]);
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        Venda::create($request->all());
        return redirect()->route('vendas');
    }

    public function edit($id)
    {
        $vendas = Venda::where('id',$id)->first();
        if (!empty($vendas)) {
            return view('vendas.edit', ['vendas' => $vendas]);
        } else {
            return redirect()->route('vendas');
        } 
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nome' => $request->nome,
            'preco'=> $request->preco,
        ];
        Venda::where('id', $id)->update($data);
        return redirect()->route('vendas');
    }

    public function destroy($id)
    {
        Venda::where('id', $id)->delete();
        return redirect()->route('vendas');
    }
}
