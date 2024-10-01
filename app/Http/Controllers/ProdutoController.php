<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Carrinho;
use Illuminate\Http\Request;
use App\Models\Variacao;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();

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
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'produto_arquivo' => 'required|file|image|max:2048',
            'tipos' => 'required|array',
            'tipos.*.nome' => 'required|string|max:255',
            'tipos.*.preco' => 'required|numeric',
        ]);

        $data = [
            'nome' => $validatedData['nome'],
            'categoria' => $validatedData['categoria'],
            'descricao' => $validatedData['descricao'],
            'preco' => $validatedData['tipos'][0]['preco'],
        ];

        if ($request->hasFile('produto_arquivo')) {
            $arquivo = $request->file('produto_arquivo');

            $novoNomeArquivo = time() . '-' . $arquivo->getClientOriginalName();

            $path = $arquivo->storeAs('public/uploads', $novoNomeArquivo);

            $data['produto_arquivo'] = $path;
        } else {
            return back()->withErrors(['produto_arquivo' => 'Erro ao carregar a imagem.']);
        }

        $produto = Produto::create($data);

        foreach ($validatedData['tipos'] as $tipo) {
            Variacao::create([
                'produto_id' => $produto->id,
                'nome' => $tipo['nome'],
                'preco' => $tipo['preco'],
            ]);
        }

        return redirect()->route('produtos')->with('success', 'Produto com variações criado com sucesso!');
    }

    public function edit($id)
    {
        $produtos = Produto::with('variacoes')->find($id);
        $categorias = Categoria::all();
        if ($produtos) {
            return view('produtos.edit', compact('produtos', 'categorias'));
        } else {
            return redirect()->route('produtos');
        }
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::with('variacoes')->findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'produto_arquivo' => 'nullable|file|image|max:2048',
            'tipos' => 'required|array',
            'tipos.*.nome' => 'required|string|max:255',
            'tipos.*.preco' => 'required|numeric',
        ]);

        $produto->nome = $request->input('nome');
        $produto->categoria = $request->input('categoria');
        $produto->descricao = $request->input('descricao');

        if ($request->hasFile('produto_arquivo')) {
            if ($produto->produto_arquivo) {
                Storage::delete($produto->produto_arquivo);
            }
            $produto->produto_arquivo = $request->file('produto_arquivo')->store('produtos');
        } elseif ($request->input('produto_arquivo_removed') === 'deleted') {
            $produto->produto_arquivo = null;
        }

        $produto->save();

        $variacoesExistentes = $produto->variacoes->pluck('id')->toArray();

        $variacoesMantidas = [];

        foreach ($request->tipos as $index => $tipo) {
            if (isset($tipo['id'])) {
                $variacao = Variacao::find($tipo['id']);
                if ($variacao) {
                    $variacao->nome = $tipo['nome'];
                    $variacao->preco = $tipo['preco'];
                    $variacao->save();
                    $variacoesMantidas[] = $variacao->id;
                }
            } else {
                $produto->variacoes()->create([
                    'nome' => $tipo['nome'],
                    'preco' => $tipo['preco']
                ]);
            }
        }

        $variacoesParaRemover = array_diff($variacoesExistentes, $variacoesMantidas);
        Variacao::destroy($variacoesParaRemover);

        return redirect()->route('produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Produto::where('id', $id)->delete();
        return redirect()->route('produtos');
    }

    public function show($id)
    {
        $produto = Produto::with('variacoes')->findOrFail($id);
        $carrinhoItems = Carrinho::all();
        return view('produtos.show', compact('produto', 'carrinhoItems'));
    }
}