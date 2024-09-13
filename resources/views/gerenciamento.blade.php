@extends('layouts.gerenciamento')

@section('content')

<div class="container mt-5">
    <main>
        <div class="row">
            <div class="col-md-4">
                <section class="mb-4">
                    <div class="card bg-light p-4 rounded shadow-sm">
                        <img src="images/produtos.jpeg" class="card-img-top" alt="..."
                            style="object-fit: cover; aspect-ratio: 1/1;">
                        <div class="card-body">
                            <h5 class="card-title">Produtos</h5>
                            <p class="card-text">Edição de produtos.</p>
                            <a href="{{ route('produtos') }}" class="btn"
                                style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="mb-4">
                    <div class="card bg-light p-4 rounded shadow-sm">
                        <img src="images/categorias.jpeg" class="card-img-top" alt="..."
                            style="object-fit: cover; aspect-ratio: 1/1;">
                        <div class="card-body">
                            <h5 class="card-title">Categorias</h5>
                            <p class="card-text">Edição de categorias.</p>
                            <a href="{{ route('categorias') }}" class="btn"
                                style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="mb-4">
                    <div class="card bg-light p-4 rounded shadow-sm">
                        <img src="images/despesas.jpeg" class="card-img-top" alt="..."
                            style="object-fit: cover; aspect-ratio: 1/1;">
                        <div class="card-body">
                            <h5 class="card-title">Despesas</h5>
                            <p class="card-text">Edição das despesas da cafeteria.</p>
                            <a href="{{ route('despesas') }}" class="btn"
                                style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
            </div>
            <div class="col-md-4">
                <section class="mb-4">
                    <div class="card bg-light p-4 rounded shadow-sm">
                        <img src="images/estoque.jpeg" class="card-img-top" alt="..."
                            style="object-fit: cover; aspect-ratio: 1/1;">
                        <div class="card-body">
                            <h5 class="card-title">Estoque</h5>
                            <p class="card-text">Edição do estoque de produtos.</p>
                            <a href="{{ route('estoques') }}" class="btn"
                                style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                        </div>
                    </div>
                </section>
            </div>
            @can ('admin')
                <div class="col-md-4">
                    <section>
                        <div class="card bg-light p-4 rounded shadow-sm">
                            <img src="images/financeiro.jpeg" class="card-img-top" alt="..."
                                style="object-fit: cover; aspect-ratio: 1/1;">
                            <div class="card-body">
                                <h5 class="card-title">Financeiro</h5>
                                <p class="card-text">Edição das finanças da cafeteria.</p>
                                <a href=" {{ route('financeiro') }} " class="btn"
                                    style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                            </div>
                        </div>
                    </section>
                </div>
            @endcan
            @can ('admin')
                <div class="col-md-4">
                    <section class="mb-4">
                        <div class="card bg-light p-4 rounded shadow-sm">
                            <img src="images/funcionarios.jpeg" class="card-img-top" alt="..."
                                style="object-fit: cover; aspect-ratio: 1/1;">
                            <div class="card-body">
                                <h5 class="card-title">Funcionários</h5>
                                <p class="card-text">Edição de funcionários.</p>
                                <a href="{{ route('funcionarios') }}" class="btn"
                                    style="background-color: #35221B; color: #f1f1f1">Acessar</a>
                            </div>
                        </div>
                    </section>
                </div>
            @endcan
        </div>
    </main>
</div>

@endsection