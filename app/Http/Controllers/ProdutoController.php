<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Carrinho;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();

        // Filtros de busca e categoria
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('categorias')) {
            $query->whereIn('categoria', $request->categorias);
        }

        // Aplicar a ordenação
        if ($request->filled('ordem')) {
            switch ($request->ordem) {
                case 'az':
                    $query->orderBy('nome', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nome', 'desc');
                    break;
                case 'preco_asc':
                    $query->orderBy('preco', 'asc');
                    break;
                case 'preco_desc':
                    $query->orderBy('preco', 'desc');
                    break;
                case 'ultima_editada':
                    $query->orderBy('updated_at', 'desc');
                    break;
                case 'primeira_editada':
                    $query->orderBy('updated_at', 'asc');
                    break;
            }
        }

        $produtos = $query->get();
        $categorias = Categoria::all();

        return view('produtos.index', compact('produtos', 'categorias'));
    }

    public function cardapio(Request $request)
    {
        $query = Produto::query();

        // Filtros de busca e categoria
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('categorias')) {
            $query->whereIn('categoria', $request->categorias);
        }

        if ($request->filled('ordem')) {
            switch ($request->ordem) {
                case 'az':
                    $query->orderBy('nome', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nome', 'desc');
                    break;
                case 'preco_asc':
                    $query->orderBy('preco', 'asc');
                    break;
                case 'preco_desc':
                    $query->orderBy('preco', 'desc');
                    break;
            }
        }

        $produtos = $query->get();
        $categorias = Categoria::all();

        return view('cardapio', compact('produtos', 'categorias'));
    }
    public function create()
    {
        $categorias = Categoria::all();
        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|string',
            'categoria' => 'required|string|max:255',
            'tipos' => 'required|array',
            'tipos.*' => 'string|max:255',
            'descricao' => 'required|string|max:250',
            'produto_arquivo' => 'required|file|image',
            'produto_arquivo2' => 'nullable|file|image',
            'produto_arquivo3' => 'nullable|file|image',
            'produto_arquivo4' => 'nullable|file|image',
        ]);

        // Converte a vírgula para ponto e garante que o valor é numérico
        $precoConvertido = str_replace(',', '.', $validatedData['preco']);

        if (!is_numeric($precoConvertido)) {
            return redirect()->back()->withErrors(['preco' => 'O preço informado é inválido.']);
        }

        $tiposConcatenados = implode(', ', $validatedData['tipos']);

        // Preparar dados para criação do produto
        $data = [
            'nome' => $validatedData['nome'],
            'preco' => $precoConvertido,
            'categoria' => $validatedData['categoria'],
            'descricao' => $validatedData['descricao'],
            'tipos' => $tiposConcatenados,
        ];

        // Processar arquivos
        if ($request->hasFile('produto_arquivo')) {
            $arquivo = rand(0, 999999) . '-' . $request->file('produto_arquivo')->getClientOriginalName();
            $path = $request->file('produto_arquivo')->storeAs('uploads', $arquivo);
            $data['produto_arquivo'] = $path;
        }

        if ($request->hasFile('produto_arquivo2')) {
            $arquivo2 = rand(0, 999999) . '-' . $request->file('produto_arquivo2')->getClientOriginalName();
            $path2 = $request->file('produto_arquivo2')->storeAs('uploads', $arquivo2);
            $data['produto_arquivo2'] = $path2;
        }

        if ($request->hasFile('produto_arquivo3')) {
            $arquivo3 = rand(0, 999999) . '-' . $request->file('produto_arquivo3')->getClientOriginalName();
            $path3 = $request->file('produto_arquivo3')->storeAs('uploads', $arquivo3);
            $data['produto_arquivo3'] = $path3;
        }

        if ($request->hasFile('produto_arquivo4')) {
            $arquivo4 = rand(0, 999999) . '-' . $request->file('produto_arquivo4')->getClientOriginalName();
            $path4 = $request->file('produto_arquivo4')->storeAs('uploads', $arquivo4);
            $data['produto_arquivo4'] = $path4;
        }

        // Criar o produto
        Produto::create($data);

        return redirect()->route('produtos')->with('success', 'Produto criado com sucesso!');
    }



    public function edit($id)
    {
        $produtos = Produto::where('id', $id)->first();
        $categorias = Categoria::all();
        if (!empty($produtos)) {
            return view('produtos.edit', compact('produtos', 'categorias'));
        } else {
            return redirect()->route('produtos', );
        }
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'categoria' => 'required|string|max:255',
            'produto_arquivo' => 'required_if:produto_arquivo_removed,null|file|image|max:2048',
        ]);

        $produto->nome = $request->input('nome');
        $produto->preco = $request->input('preco');
        $produto->categoria = $request->input('categoria');
        $produto->descricao = $request->input('descricao');

        if ($request->hasFile('produto_arquivo')) {
            $produto->produto_arquivo = $request->file('produto_arquivo')->store('produtos');
        } elseif ($request->input('produto_arquivo_removed') === 'deleted') {
            $produto->produto_arquivo = null;
        }

        foreach (['produto_arquivo2', 'produto_arquivo3', 'produto_arquivo4'] as $key) {
            if ($request->hasFile($key)) {
                $produto->$key = $request->file($key)->store('produtos');
            } elseif ($request->input("{$key}_removed") === 'deleted') {
                $produto->$key = null;
            }
        }

        $produto->save();

        return redirect()->route('produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Produto::where('id', $id)->delete();
        return redirect()->route('produtos');
    }

    public function show($id)
    {
        $carrinhoItems = Carrinho::all();
        $produto = Produto::findOrFail($id);
        return view('produtos.show', compact('produto', 'carrinhoItems'));
    }
}
