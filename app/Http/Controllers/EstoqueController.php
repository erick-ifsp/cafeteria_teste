<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index(Request $request)
    {
        $query = Financeiro::where('tipo', 'estoque');

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('updated_at', [$request->data_inicio, $request->data_fim]);
        } elseif ($request->filled('data_inicio')) {
            $query->where('updated_at', '>=', $request->data_inicio);
        } elseif ($request->filled('data_fim')) {
            $query->where('updated_at', '<=', $request->data_fim);
        }

        $estoques = $query->get();

        return view('estoques.index', [
            'estoques' => $estoques,
        ]);
    }

    public function create()
    {
        return view('estoques.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['gerenciamento_id'] = $data['id'];
        $data['valor'] = -abs($data['valor']);
        $data['tipo'] = 'Estoque';

        Financeiro::create($data);

        return redirect()->route('estoques');
    }

    public function edit($id)
    {
        $estoques = Financeiro::where('id', $id)->first();
        if (!empty($estoques)) {
            return view('estoques.edit', ['estoques' => $estoques]);
        } else {
            return redirect()->route('estoques');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'valor' => $request->valor
        ];
        Financeiro::where('id', $id)->update($data);
        return redirect()->route('estoques');
    }

    public function destroy($id)
    {
        Financeiro::where('id', $id)->delete();
        return redirect()->route('estoques');
    }
}
