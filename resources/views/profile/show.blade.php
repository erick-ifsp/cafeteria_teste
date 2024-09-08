@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="text-center mb-4 mt-4">Perfil</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-3 vh-100">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" id="dados-pessoais-tab">Dados
                    Pessoais</a>
                <a href="#" class="list-group-item list-group-item-action" id="enderecos-tab">Endereços</a>
                <a href="#" class="list-group-item list-group-item-action" id="cartoes-tab">Cartões</a>
            </div>
        </div>

        <div class="col-md-9">
            <div id="dados-pessoais-content" class="content-section">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" maxlength="50" id="name" name="name" value="{{ $user->name }}"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" maxlength="100" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Atualizar Perfil</button>
                </form>

                <hr class="my-4">

                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="current_password" class="form-label">Senha Atual</label>
                        <input type="password" maxlength="50" class="form-control" id="current_password" name="current_password"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Nova Senha</label>
                        <input type="password" maxlength="50" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" maxlength="50" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Atualizar Senha</button>
                </form>
            </div>

            <div id="enderecos-content" class="content-section d-none">
                <h4 class="mb-3">Meus Endereços</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Rua</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Estado</th>
                            <th scope="col">CEP</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enderecos as $endereco)
                            <tr>
                                <td>{{ $endereco->rua }}</td>
                                <td>{{ $endereco->cidade }}</td>
                                <td>{{ $endereco->estado }}</td>
                                <td>{{ $endereco->cep }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning"
                                        data-edit-endereco='@json($endereco)'>
                                        Editar
                                    </button>
                                    <form action="{{ route('profile.endereco.destroy', $endereco->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEnderecoModal">
                    Adicionar Endereço
                </button>
            </div>

            <div id="cartoes-content" class="content-section d-none">
                <h4 class="mb-3">Meus Cartões</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Número do Cartão</th>
                            <th scope="col">Nome no Cartão</th>
                            <th scope="col">Data de Expiração</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartoes as $cartao)
                            <tr>
                                <td>{{ $cartao->numero }}</td>
                                <td>{{ $cartao->nome }}</td>
                                <td>{{ $cartao->data }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-edit-cartao='@json($cartao)'>
                                        Editar
                                    </button>
                                    <form action="{{ route('profile.cartao.destroy', $cartao->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCartaoModal">
                    Adicionar Cartão
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEnderecoModal" tabindex="-1" aria-labelledby="addEnderecoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEnderecoModalLabel">Cadastrar Novo Endereço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="enderecoForm" action="{{ route('profile.endereco.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="endereco_id" name="endereco_id">
                    <div class="form-group mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" maxlength="100" name="rua" placeholder="Digite o nome da rua"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" maxlength="50" id="cidade" name="cidade"
                            placeholder="Digite o nome da cidade" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" maxlength="50" id="estado" name="estado"
                            placeholder="Digite o nome do estado" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Endereço</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCartaoModal" tabindex="-1" aria-labelledby="addCartaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCartaoModalLabel">Cadastrar Novo Cartão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cartaoForm" action="{{ route('profile.cartao.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="cartao_id" name="cartao_id">
                    <div class="form-group mb-3">
                        <label for="numero" class="form-label">Número do Cartão</label>
                        <input type="text" class="form-control" id="numero" name="numero"
                            placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nome" class="form-label">Nome no Cartão</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            placeholder="Nome impresso no cartão" maxlength="50" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="data" class="form-label">Data de Expiração</label>
                        <input type="text" class="form-control" id="data" name="data" placeholder="MM/AA" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Cartão</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function mostrarConteudo(id) {
            document.querySelectorAll('.content-section').forEach(function (section) {
                section.classList.add('d-none');
            });
            document.getElementById(id + '-content').classList.remove('d-none');
        }

        document.querySelectorAll('.list-group-item').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.list-group-item').forEach(function (item) {
                    item.classList.remove('active');
                });
                this.classList.add('active');
                mostrarConteudo(this.id.replace('-tab', ''));
            });
        });

        document.querySelectorAll('[data-edit-endereco]').forEach(function (button) {
            button.addEventListener('click', function () {
                const endereco = JSON.parse(this.getAttribute('data-edit-endereco'));
                const form = document.getElementById('enderecoForm');
                form.action = '{{ route('profile.endereco.update', '') }}/' + endereco.id;
                document.getElementById('addEnderecoModalLabel').textContent = 'Editar Endereço';
                document.getElementById('rua').value = endereco.rua;
                document.getElementById('cidade').value = endereco.cidade;
                document.getElementById('estado').value = endereco.estado;
                document.getElementById('cep').value = endereco.cep;

                form.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
                document.getElementById('endereco_id').value = endereco.id;

                new bootstrap.Modal(document.getElementById('addEnderecoModal')).show();
            });
        });

        document.querySelectorAll('[data-edit-cartao]').forEach(function (button) {
            button.addEventListener('click', function () {
                const cartao = JSON.parse(this.getAttribute('data-edit-cartao'));
                const form = document.getElementById('cartaoForm');
                form.action = '{{ route('profile.cartao.update', '') }}/' + cartao.id;
                document.getElementById('addCartaoModalLabel').textContent = 'Editar Cartão';
                document.getElementById('numero').value = cartao.numero;
                document.getElementById('nome').value = cartao.nome;
                document.getElementById('data').value = cartao.data;
                document.getElementById('cvv').value = cartao.cvv;

                form.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
                document.getElementById('cartao_id').value = cartao.id;

                new bootstrap.Modal(document.getElementById('addCartaoModal')).show();

                $('#numero').trigger('input');
                $('#data').trigger('input');
                $('#cvv').trigger('input');
            });
        });
    });
</script>
@endsection