<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    public function index(Request $request)
    {
        $query = Financeiro::where('tipo', 'despesa');

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

        $despesas = $query->get();

        return view('despesas.index', [
            'despesas' => $despesas,
        ]);
    }

    public function create()
    {
        return view('despesas.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['gerenciamento_id'] = $data['id'];
        $data['valor'] = -abs($data['valor']);
        $data['tipo'] = 'Despesa';

        Financeiro::create($data);

        return redirect()->route('despesas');
    }

    public function edit($id)
    {
        $despesas = Financeiro::where('id', $id)->first();
        if (!empty($despesas)) {
            return view('despesas.edit', ['despesas' => $despesas]);
        } else {
            return redirect()->route('despesas');
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
        return redirect()->route('despesas');
    }

    public function destroy($id)
    {
        Financeiro::where('id', $id)->delete();
        return redirect()->route('despesas');
    }
}
