<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Access;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();
        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        $AccessLevels = Access::all();
        return view('funcionarios.create', compact('AccessLevels'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:14|unique:funcionarios',
            'cargo' => 'required|string|max:100',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|unique:funcionarios|unique:users', // Validação também para a tabela 'users'
            'data_contratacao' => 'required|date',
            'salario' => 'required|numeric',
            'access_id' => 'required|exists:accesses,id',
        ]);

        try {
            // Criar o funcionário
            Funcionario::create($validatedData);

            // Criar o usuário correspondente
            User::create([
                'name' => $request->nome, // Nome do funcionário
                'email' => $request->email, // Email do funcionário
                'password' => Hash::make('senha123'), // Senha padrão
                'access' => $request->input('access_id'), // Nível de acesso
            ]);

            return redirect()->route('funcionarios')->with('success', 'Funcionário e usuário criado com sucesso.');

        } catch (\Exception $e) {
            // Registrar erro no log
            \Log::error('Erro ao criar funcionário e usuário: ' . $e->getMessage());

            // Retornar com mensagem de erro
            return redirect()->back()->withErrors('Ocorreu um erro ao salvar o funcionário e usuário. Tente novamente.');
        }
    }

    public function show($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $AccessLevels = Access::all();
        return view('funcionarios.edit', compact('funcionario', 'AccessLevels'));
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'telefone' => 'required|string|max:20',
            'email' => 'required|string|email|max:100|unique:funcionarios,email,' . $funcionario->id,
            'cargo' => 'required|string|max:100',
            'data_contratacao' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'access_id' => 'required|exists:accesses,id',
        ]);

        $funcionario->update($request->all());

        return redirect()->route('funcionarios')->with('success', 'Funcionário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->route('funcionarios')->with('success', 'Funcionário removido com sucesso.');
    }
}
