<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($request->filled('ordem')) {
            switch ($request->input('ordem')) {
                case 'ultima_editada':
                    $query->orderBy('updated_at', 'desc');
                    break;
                case 'primeira_editada':
                    $query->orderBy('updated_at', 'asc');
                    break;
                case 'az':
                    $query->orderBy('nome', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nome', 'desc');
                    break;
            }
        }

        $categorias = $query->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        Categoria::create($request->all());
        return redirect()->route('categorias');
    }

    public function edit($id)
    {
        $categorias = Categoria::where('id', $id)->first();
        if (!empty($categorias)) {
            return view('categorias.edit', ['categorias' => $categorias]);
        } else {
            return redirect()->route('categorias');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nome' => $request->nome,
        ];
        Categoria::where('id', $id)->update($data);
        return redirect()->route('categorias');
    }

    public function destroy($id)
    {
        Categoria::where('id', $id)->delete();
        return redirect()->route('categorias');
    }
}
