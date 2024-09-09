<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\FinanceiroController;
use App\Models\Produto;

Route::get('/', function () {
    return view('cafeteria');
})->name('/');

Route::get('/', function () {
    $produtos = Produto::take(4)->get();
    return view('cafeteria', ['produtos' => $produtos]);
})->name('cafeteria');

Route::get('/gerenciamento', function () {
    return view('gerenciamento');
})->name('gerenciamento')->middleware('can:func');

Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/cardapio', [ProdutoController::class, 'cardapio'])->name('cardapio');

Route::get('/produtos', [ProdutoController::class, 'categoria_produtos'])->name('produtos')->middleware('can:func');

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizarCompra'])->name('carrinho.finalizar');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/endereco', [ProfileController::class, 'storeEndereco'])->name('profile.endereco.store');
    Route::post('/profile/cartao', [ProfileController::class, 'storeCartao'])->name('profile.cartao.store');

    // Rotas para Endereços
    Route::post('/profile/endereco', [ProfileController::class, 'storeEndereco'])->name('profile.endereco.store');
    Route::get('/profile/endereco/{id}/edit', [ProfileController::class, 'editEndereco'])->name('profile.endereco.edit');
    Route::put('/profile/endereco/{id}', [ProfileController::class, 'updateEndereco'])->name('profile.endereco.update');
    Route::delete('/profile/endereco/{id}', [ProfileController::class, 'destroyEndereco'])->name('profile.endereco.destroy');

    // Rotas para Cartões
    Route::post('/profile/cartao', [ProfileController::class, 'storeCartao'])->name('profile.cartao.store');
    Route::get('/profile/cartao/{id}/edit', [ProfileController::class, 'editCartao'])->name('profile.cartao.edit');
    Route::put('/profile/cartao/{id}', [ProfileController::class, 'updateCartao'])->name('profile.cartao.update');
    Route::delete('/profile/cartao/{id}', [ProfileController::class, 'destroyCartao'])->name('profile.cartao.destroy');
    Route::post('/cartoes', [CartaoController::class, 'store'])->name('cartoes.store');


    // PRODUTOS
    Route::prefix('produtos')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index')->middleware('can:func');
        Route::get('/create', [ProdutoController::class, 'create'])->name('produtos.create')->middleware('can:func');
        Route::post('/', [ProdutoController::class, 'store'])->name('produtos.store')->middleware('can:func');
        Route::get('/{id}', [ProdutoController::class, 'show'])->name('produtos.show');
        Route::get('/{id}/edit', [ProdutoController::class, 'edit'])->where('id', '[0-9]+')->name('produtos.edit')->middleware('can:func');
        Route::put('/{id}', [ProdutoController::class, 'update'])->where('id', '[0-9]+')->name('produtos.update')->middleware('can:func');
        Route::delete('/{id}', [ProdutoController::class, 'destroy'])->where('id', '[0-9]+')->name('produtos.destroy')->middleware('can:func');
    });

    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos')->middleware('can:func');

    // DESPESAS
    Route::prefix('despesas')->group(function () {
        Route::get('/', [DespesaController::class, 'index'])->name('despesas.index')->middleware('can:func');
        Route::get('/create', [DespesaController::class, 'create'])->name('despesas.create')->middleware('can:func');
        Route::post('/', [DespesaController::class, 'store'])->name('despesas.store')->middleware('can:func');
        Route::get('/{id}', [DespesaController::class, 'show'])->name('despesas.show')->middleware('can:func');
        Route::get('/{id}/edit', [DespesaController::class, 'edit'])->where('id', '[0-9]+')->name('despesas.edit')->middleware('can:func');
        Route::put('/{id}', [DespesaController::class, 'update'])->where('id', '[0-9]+')->name('despesas.update')->middleware('can:func');
        Route::delete('/{id}', [DespesaController::class, 'destroy'])->where('id', '[0-9]+')->name('despesas.destroy')->middleware('can:func');
    });

    Route::get('/despesas', [DespesaController::class, 'index'])->name('despesas')->middleware('can:func');

    // ESTOQUE
    Route::prefix('estoques')->group(function () {
        Route::get('/', [EstoqueController::class, 'index'])->name('estoques.index')->middleware('can:func');
        Route::get('/create', [EstoqueController::class, 'create'])->name('estoques.create')->middleware('can:func');
        Route::post('/', [EstoqueController::class, 'store'])->name('estoques.store')->middleware('can:func');
        Route::get('/{id}', [EstoqueController::class, 'show'])->name('estoques.show')->middleware('can:func');
        Route::get('/{id}/edit', [EstoqueController::class, 'edit'])->where('id', '[0-9]+')->name('estoques.edit')->middleware('can:func');
        Route::put('/{id}', [EstoqueController::class, 'update'])->where('id', '[0-9]+')->name('estoques.update')->middleware('can:func');
        Route::delete('/{id}', [EstoqueController::class, 'destroy'])->where('id', '[0-9]+')->name('estoques.destroy')->middleware('can:func');
    });

    Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques')->middleware('can:func');

    // FUNCIONARIOS
    Route::prefix('funcionarios')->group(function () {
        Route::get('/', [FuncionarioController::class, 'index'])->name('funcionarios.index')->middleware('can:admin');
        Route::get('/create', [FuncionarioController::class, 'create'])->name('funcionarios.create')->middleware('can:admin');
        Route::post('/', [FuncionarioController::class, 'store'])->name('funcionarios.store')->middleware('can:admin');
        Route::get('/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show')->middleware('can:admin');
        Route::get('/{id}/edit', [FuncionarioController::class, 'edit'])->where('id', '[0-9]+')->name('funcionarios.edit')->middleware('can:admin');
        Route::put('/{id}', [FuncionarioController::class, 'update'])->where('id', '[0-9]+')->name('funcionarios.update')->middleware('can:admin');
        Route::delete('/{id}', [FuncionarioController::class, 'destroy'])->where('id', '[0-9]+')->name('funcionarios.destroy')->middleware('can:admin');
    });

    Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios')->middleware('can:admin');

    // PEDIDOS
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
        Route::put('/pedidos/{id}/status', [PedidoController::class, 'updateStatus'])->name('pedidos.updateStatus')->middleware('can:func');
    });
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos');

    //CATEGORIAS

    Route::prefix('categorias')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('categorias.index')->middleware('can:func');
        Route::get('/create', [CategoriaController::class, 'create'])->name('categorias.create')->middleware('can:func');
        Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store')->middleware('can:func');
        Route::get('/{id}', [CategoriaController::class, 'show'])->name('categorias.show')->middleware('can:func');
        Route::get('/{id}/edit', [CategoriaController::class, 'edit'])->where('id', '[0-9]+')->name('categorias.edit')->middleware('can:func');
        Route::put('/{id}', [CategoriaController::class, 'update'])->where('id', '[0-9]+')->name('categorias.update')->middleware('can:func');
        Route::delete('/{id}', [CategoriaController::class, 'destroy'])->where('id', '[0-9]+')->name('categorias.destroy')->middleware('can:func');
    });

    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias')->middleware('can:func');

    //ACCESS

    Route::prefix('accesses')->group(function () {
        Route::get('/', [AccessController::class, 'index'])->name('accesses.index')->middleware('can:func');
        Route::get('/create', [AccessController::class, 'create'])->name('accesses.create')->middleware('can:func');
        Route::post('/', [AccessController::class, 'store'])->name('accesses.store')->middleware('can:func');
        Route::get('/{id}', [AccessController::class, 'show'])->name('accesses.show')->middleware('can:func');
        Route::get('/{id}/edit', [AccessController::class, 'edit'])->where('id', '[0-9]+')->name('accesses.edit')->middleware('can:func');
        Route::put('/{id}', [AccessController::class, 'update'])->where('id', '[0-9]+')->name('accesses.update')->middleware('can:func');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->where('id', '[0-9]+')->name('accesses.destroy')->middleware('can:func');
    });

    Route::get('/accesses', [AccessController::class, 'index'])->name('accesses')->middleware('can:func');

    //CARRINHO

    Route::post('/carrinho/add/{id}', [CarrinhoController::class, 'AdicionarCarrinho'])->name('carrinho.add');
    Route::get('/carrinho', [CarrinhoController::class, 'viewCarrinho'])->name('carrinho.index');
    Route::put('/carrinho/{id}', [CarrinhoController::class, 'AtualizarCarrinho'])->name('carrinho.update');
    Route::delete('/carrinho/{carrinhoItemId}', [CarrinhoController::class, 'RemoverCarrinho'])->name('carrinho.remover');

    //FINANCEIRO
    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro')->middleware('can:admin');
});

require __DIR__ . '/auth.php';







