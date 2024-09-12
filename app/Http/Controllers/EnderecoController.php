<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|max:15',
            'rua' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
        ]);

        $user = Auth::user();

        $endereco = Endereco::create([
            'user_id' => $user->id,
            'cpf' => $request->input('cpf'),
            'rua' => $request->input('rua'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'cep' => $request->input('cep'),
        ]);

        return redirect()->back()->with('success', 'Endereço adicionado com sucesso!');
    }
}
