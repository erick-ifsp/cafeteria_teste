<?php

namespace App\Http\Controllers;

use App\Models\Access;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function index(Request $request)
    {
        $query = Access::query();

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

        $accesses = $query->get();
        return view('accesses.index', compact('accesses'));
    }

    public function create()
    {
        return view('accesses.create');
    }

    public function store(Request $request)
    {
        Access::create($request->all());
        return redirect()->route('accesses');
    }

    public function edit($id)
    {
        $accesses = Access::where('id', $id)->first();
        if (!empty($accesses)) {
            return view('accesses.edit', ['accesses' => $accesses]);
        } else {
            return redirect()->route('accesses');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nome' => $request->nome,
        ];
        Access::where('id', $id)->update($data);
        return redirect()->route('accesses');
    }

    public function destroy($id)
    {
        Access::where('id', $id)->delete();
        return redirect()->route('accesses');
    }
}
