@extends('layouts.app')

@section('title', 'Editar Produtos')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Editar Produto</h1>
            <hr>
            <form action="{{ route('produtos.update', ['id' => $produtos->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" value="{{ old('nome', $produtos->nome) }}"
                        placeholder="Digite o nome do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="preco" class="form-label">Preço:</label>
                    <input type="number" class="form-control" name="preco" value="{{ old('preco', $produtos->preco) }}"
                        placeholder="Digite o preço do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nome }}" {{ old('categoria', $produtos->categoria) == $categoria->nome ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="tipos" class="form-label">Tipos:</label>
                    <div id="tipos-container">
                        @foreach(explode(',', $produtos->tipos) as $tipo)
                            <input type="text" class="form-control mb-2" name="tipos[]"
                                value="{{ trim($tipo) }}" maxlength="50" placeholder="Digite o tipo do produto">
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addTipo()">Adicionar Tipo</button>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" class="form-control" name="descricao"
                        value="{{ old('descricao', $produtos->descricao) }}"
                        placeholder="Adicione a descrição do produto" maxlength="250" required>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="produto_arquivo" class="form-label">Adicionar foto principal:</label>
                        <input type="file" name="produto_arquivo" id="produto_arquivo" class="form-control"
                            onchange="previewImage(1)">
                        <img id="preview1" src="{{ asset('storage/' . $produtos->produto_arquivo) }}"
                            class="img-thumbnail mt-2"
                            style="width: 200px; display: {{ $produtos->produto_arquivo ? 'block' : 'none' }};" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(1)" id="remove1"
                            style="display: {{ $produtos->produto_arquivo ? 'inline-block' : 'none' }};">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem2-group"
                        style="{{ $produtos->produto_arquivo2 ? '' : 'display:none;' }}">
                        <label for="produto_arquivo2" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo2" id="produto_arquivo2" class="form-control"
                            onchange="previewImage(2)">
                        <img id="preview2" src="{{ asset('storage/' . $produtos->produto_arquivo2) }}"
                            class="img-thumbnail mt-2"
                            style="width: 200px; display: {{ $produtos->produto_arquivo2 ? 'block' : 'none' }};" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(2)" id="remove2"
                            style="display: {{ $produtos->produto_arquivo2 ? 'inline-block' : 'none' }};">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem3-group"
                        style="{{ $produtos->produto_arquivo3 ? '' : 'display:none;' }}">
                        <label for="produto_arquivo3" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo3" id="produto_arquivo3" class="form-control"
                            onchange="previewImage(3)">
                        <img id="preview3" src="{{ asset('storage/' . $produtos->produto_arquivo3) }}"
                            class="img-thumbnail mt-2"
                            style="width: 200px; display: {{ $produtos->produto_arquivo3 ? 'block' : 'none' }};" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(3)" id="remove3"
                            style="display: {{ $produtos->produto_arquivo3 ? 'inline-block' : 'none' }};">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem4-group"
                        style="{{ $produtos->produto_arquivo4 ? '' : 'display:none;' }}">
                        <label for="produto_arquivo4" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo4" id="produto_arquivo4" class="form-control"
                            onchange="previewImage(4)">
                        <img id="preview4" src="{{ asset('storage/' . $produtos->produto_arquivo4) }}"
                            class="img-thumbnail mt-2"
                            style="width: 200px; display: {{ $produtos->produto_arquivo4 ? 'block' : 'none' }};" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(4)" id="remove4"
                            style="display: {{ $produtos->produto_arquivo4 ? 'inline-block' : 'none' }};">Remover</button>
                    </div>
                </div>

                <input type="hidden" name="produto_arquivo_removed" id="produto_arquivo_removed"
                    value="{{ $produtos->produto_arquivo }}">
                <input type="hidden" name="produto_arquivo2_removed" id="produto_arquivo2_removed"
                    value="{{ $produtos->produto_arquivo2 }}">
                <input type="hidden" name="produto_arquivo3_removed" id="produto_arquivo3_removed"
                    value="{{ $produtos->produto_arquivo3 }}">
                <input type="hidden" name="produto_arquivo4_removed" id="produto_arquivo4_removed"
                    value="{{ $produtos->produto_arquivo4 }}">

                <div class="form-group">
                    <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Salvar</button>
                    <a href="{{ route('produtos') }}" class="btn"
                        style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addTipo() {
        const container = document.getElementById('tipos-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control mb-2';
        input.name = 'tipos[]';
        input.placeholder = 'Digite o tipo do produto';
        container.appendChild(input);
    }

    function previewImage(imageNumber) {
        const fileInput = document.getElementById('produto_arquivo' + imageNumber);
        const preview = document.getElementById('preview' + imageNumber);
        const removeBtn = document.getElementById('remove' + imageNumber);
        const imageGroup = document.getElementById('imagem' + imageNumber + '-group');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                removeBtn.style.display = 'inline-block';
                imageGroup.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    function removeImage(imageNumber) {
        const fileInput = document.getElementById('produto_arquivo' + imageNumber);
        const preview = document.getElementById('preview' + imageNumber);
        const removeBtn = document.getElementById('remove' + imageNumber);
        const imageGroup = document.getElementById('imagem' + imageNumber + '-group');
        const removedInput = document.getElementById('produto_arquivo' + imageNumber + '_removed');

        fileInput.value = '';
        preview.src = '';
        preview.style.display = 'none';
        removeBtn.style.display = 'none';
        imageGroup.style.display = 'none';
        removedInput.value = '';
    }

    function addTipo() {
        var container = document.getElementById('tipos-container');
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control mb-2';
        input.name = 'tipos[]';
        input.placeholder = 'Digite o tipo do produto';
        container.appendChild(input);
    }

    // Function to remove a tipo input
    function removeTipo(button) {
        var tipoDiv = button.parentElement;
        tipoDiv.remove();
    }
</script>

@endsection