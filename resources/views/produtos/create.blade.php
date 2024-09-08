@extends('layouts.app')

@section('title', 'Adicionar Produtos')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Criar Produto</h1>
            <hr>
            <form id="produtoForm" action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="preco" class="form-label">Preço:</label>
                    <input type="text" class="form-control" name="preco" id="preco" placeholder="00,00" required>
                </div>

                <div class="form-group mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nome }}">{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="tipos" class="form-label">Tipos:</label>
                    <div id="tipos-container">
                        <input type="text" class="form-control mb-2" name="tipos[]"
                            placeholder="Digite o tipo do produto">
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addTipo()">Adicionar Tipo</button>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao"
                        placeholder="Adicione a descrição do produto" required oninput="updateCharacterCount()">
                    <div class="form-text">
                        Caracteres restantes: <span id="charCount" class="text" class="btn"
                            style="color: #35221B">250</span>
                    </div>
                    <div id="errorMsg" class="text-danger mt-2" style="display:none;">A descrição não pode ter mais de
                        250 caracteres.</div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="produto_arquivo" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo" id="produto_arquivo" class="form-control"
                            onchange="previewImage(1)">
                        <img id="preview1" class="img-thumbnail mt-2" style="display:none; width: 200px;" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(1)" style="display:none;"
                            id="remove1">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem2-group" style="display:none;">
                        <label for="produto_arquivo2" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo2" id="produto_arquivo2" class="form-control"
                            onchange="previewImage(2)">
                        <img id="preview2" class="img-thumbnail mt-2" style="display:none; width: 200px;" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(2)" style="display:none;"
                            id="remove2">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem3-group" style="display:none;">
                        <label for="produto_arquivo3" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo3" id="produto_arquivo3" class="form-control"
                            onchange="previewImage(3)">
                        <img id="preview3" class="img-thumbnail mt-2" style="display:none; width: 200px;" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(3)" style="display:none;"
                            id="remove3">Remover</button>
                    </div>

                    <div class="col-md-3 mb-3" id="imagem4-group" style="display:none;">
                        <label for="produto_arquivo4" class="form-label">Adicionar foto</label>
                        <input type="file" name="produto_arquivo4" id="produto_arquivo4" class="form-control"
                            onchange="previewImage(4)">
                        <img id="preview4" class="img-thumbnail mt-2" style="display:none; width: 200px;" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(4)" style="display:none;"
                            id="remove4">Remover</button>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn"
                        style="background-color: #35221B; color: #f1f1f1">Adicionar</button>
                    <a href="{{ route('produtos') }}" class="btn"
                        style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCharacterCount() {
        const maxLength = 250;
        const descricaoElement = document.getElementById('descricao');
        const charCount = descricaoElement.value.length;
        const charRemaining = maxLength - charCount;
        const charCountDisplay = document.getElementById('charCount');
        const errorMsg = document.getElementById('errorMsg');

        charCountDisplay.textContent = charRemaining;

        if (charRemaining < 0) {
            charCountDisplay.classList.add("text-danger");
            charCountDisplay.classList.remove("text");
            errorMsg.style.display = 'block';
        } else {
            charCountDisplay.classList.add("text");
            charCountDisplay.classList.remove("text-danger");
            errorMsg.style.display = 'none';
        }
    }

    document.getElementById('produtoForm').addEventListener('submit', function (event) {
        const descricaoElement = document.getElementById('descricao');
        if (descricaoElement.value.length > 250) {
            event.preventDefault();
            document.getElementById('errorMsg').style.display = 'block';
            document.getElementById('charCount').classList.add("text-danger");
        }
    });

    function previewImage(index) {
        var fileInput = document.getElementById('produto_arquivo' + (index === 1 ? '' : index));
        var preview = document.getElementById('preview' + index);
        var removeButton = document.getElementById('remove' + index);
        var nextGroup = document.getElementById('imagem' + (index + 1) + '-group');

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                removeButton.style.display = 'inline-block';
            }
            reader.readAsDataURL(fileInput.files[0]);

            if (nextGroup) {
                nextGroup.style.display = 'block';
            }
        }
    }

    function removeImage(index) {
        var fileInput = document.getElementById('produto_arquivo' + (index === 1 ? '' : index));
        var preview = document.getElementById('preview' + index);
        var removeButton = document.getElementById('remove' + index);

        fileInput.value = '';
        preview.style.display = 'none';
        removeButton.style.display = 'none';

        // Hide the next image group if it has no image
        var nextGroup = document.getElementById('imagem' + (index + 1) + '-group');
        if (nextGroup) {
            var nextFileInput = document.getElementById('produto_arquivo' + (index + 1));
            if (!nextFileInput.files || !nextFileInput.files[0]) {
                nextGroup.style.display = 'none';
            }
        }
    }

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', (e) => {
            if (e.target.files.length > 1) {
                alert('Você só pode adicionar uma foto por vez.');
                e.target.value = '';
            }
        });
    });

    function addTipo() {
        var container = document.getElementById('tipos-container');
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control mb-2';
        input.name = 'tipos[]';
        input.placeholder = 'Digite o tipo do produto';
        container.appendChild(input);
    }

    function removerTipo(button) {
        const tipoDiv = button.parentElement;
        tipoDiv.remove();
    }

    $('#preco').mask('00,00');
</script>

@endsection