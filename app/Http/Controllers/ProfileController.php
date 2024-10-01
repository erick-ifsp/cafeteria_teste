<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Endereco;
use App\Models\Cartao;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $enderecos = Endereco::where('user_id', $user->id)->get();
        $cartoes = Cartao::where('user_id', $user->id)->get();

        return view('profile.show', compact('user', 'enderecos', 'cartoes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.show')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Senha atual incorreta']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile.show')->with('success', 'Senha atualizada com sucesso!');
    }

    public function storeEndereco(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|max:14',
            'rua' => 'required|string|max:100',
            'cidade' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
            'cep' => [
                'required',
                'string',
                'regex:/^124(60|6[1-9]|7[0-9]|8[0-9]|89)-\d{3}$/',
            ],
        ]);

        Endereco::create([
            'user_id' => auth()->id(),
            'cpf' => $request->cpf,
            'rua' => $request->rua,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
        ]);

        return redirect()->route('profile.show')->with('success', 'Endereço cadastrado com sucesso!');
    }

    public function storeCartao(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:20',
            'nome' => 'required|string|max:255',
            'data' => 'required|date_format:m/y',
            'cvv' => 'required|string|max:5',
        ]);

        Cartao::create([
            'user_id' => auth()->id(),
            'numero' => $request->numero,
            'nome' => $request->nome,
            'data' => $request->data,
            'cvv' => $request->cvv,
        ]);

        return redirect()->route('profile.show')->with('success', 'Cartão cadastrado com sucesso!');
    }

    public function editEndereco($id)
    {
        $endereco = Endereco::findOrFail($id);

        return view('profile.endereco.edit', compact('endereco'));
    }

    public function editCartao($id)
    {
        $cartao = Cartao::findOrFail($id);

        return view('profile.cartao.edit', compact('cartao'));
    }

    public function updateEndereco(Request $request, $id = null)
    {
        $data = $request->validate([
            'cpf' => 'required|string|max:14',
            'rua' => 'required|string|max:100',
            'cidade' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
            'cep' => [
                'required',
                'string',
                'regex:/^124(60|6[1-9]|7[0-9]|8[0-9]|89)-\d{3}$/',
            ],
        ]);

        if ($id) {
            $endereco = Endereco::findOrFail($id);
            $endereco->update($data);
        } else {
            Endereco::create($data);
        }

        return redirect()->back()->with('success', 'Endereço atualizado com sucesso!');
    }

    public function destroyEndereco($id)
    {
        $endereco = Endereco::findOrFail($id);
        $endereco->delete();

        return redirect()->back()->with('success', 'Endereço removido com sucesso!');
    }

    public function updateCartao(Request $request, $id = null)
    {
        $data = $request->validate([
            'numero' => 'required|string',
            'nome' => 'required|string',
            'data' => 'required|string',
            'cvv' => 'required|string'
        ]);

        if ($id) {
            $cartao = Cartao::findOrFail($id);
            $cartao->update($data);
        } else {
            Cartao::create($data);
        }
        return redirect()->back()->with('success', 'Cartao atualizado com sucesso!');
    }

    public function destroyCartao($id)
    {
        $cartao = cartao::findOrFail($id);
        $cartao->delete();

        return redirect()->back()->with('success', 'Cartao removido com sucesso!');
    }
}
