<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria</title>
</head>
<link rel="stylesheet" href="css/pedidos.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

<body>
    <header>

        <a href="#"   class="icon"><ion-icon name="menu-outline"></ion-icon></a>
        <div>
            <a href="cafeteria_adm.html" class="head">Página inicial</a>
            <a href="login/login.html" class="head">Ver Perfil</a>

        </div>
    </header>
   

    <div class="container">        
        <div class="mesa">   
            <div class="selecmesa">   
                <h3>Mesas:</h3>        
                <input type="number" id="mesa" min="1" value="1" placeholder="Mesa">               
            </div>
        </div>
    </div>
        <div></div>
    <div id="cardapio-details" class="item-details">
        <h3>Cardápio</h3>


       
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .produto {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
    }
    .mesa{
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
    }

    .produto img {
        max-width: 150px;
        height: auto;
        margin-right: 20px;
    }

    .descricao {
        flex-grow: 1;
    }
    .selecmesa{
        flex-grow: 1;
    }

    .descricao h2 {
        margin-top: 0;
    }

    .preco {
        font-weight: bold;
        color: #009688;
        margin-bottom: 15px;
    }

    button {
        background-color: #009688;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #00796b;
    }

    .carrinho {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
    }

    #carrinho h3 {
        margin-top: 0;
    }

    #carrinho ul {
        padding: 0;
    }

    #carrinho li {
        list-style: none;
        margin-bottom: 5px;
    }

    #carrinho li span {
        font-weight: bold;
    }

    #carrinho button {
        margin-top: 10px;
    }

    #carrinho #total {
        font-weight: bold;
    }

    .notification {
        position: fixed;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        transition: bottom 0.5s ease;
        scale: 120%;
        align-content: center;
        margin: 5px;


    }
    .car-link{
        color: #f1f1f1;
        text-decoration: none;
    }
</style>
</head>

<body>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Nome do Produto">
            <div class="descricao">
                <h2>Café Espresso</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Nome do Produto">
            <div class="descricao">
                <h2>Cappuccino</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Nome do Produto">
            <div class="descricao">
                <h2>Chá</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Chocolate quente">
            <div class="descricao">
                <h2>Chocolate quente</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Muffins">
            <div class="descricao">
                <h2>Muffins</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Croissants">
            <div class="descricao">
                <h2>Croissants</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Bolos">
            <div class="descricao">
                <h2>Bolos</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Sanduíches">
            <div class="descricao">
                <h2>Sanduíches</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Salgados">
            <div class="descricao">
                <h2>Salgados</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="produto">
            <img src="produto.jpg" alt="Muffin">
            <div class="descricao">
                <h2>Muffin</h2>
                <p>Descrição do Produto.</p>
                <p class="preco">R$ 99,99</p>
                <input type="number" id="quantidade" min="1" value="1">
                <button onclick="anotarPedido()">Anotar Pedido</button>
            </div>
        </div>
    </div>

    <p id="pedido"></p>

    <script>
        function anotarPedido() {
          const productName = document.querySelector('h2').innerText;
          const quantity = document.getElementById('quantidade').value;
          const tableNumber = document.getElementById('mesa').value;
          const pedido = document.getElementById('pedido');
        
          const newPedido = document.createElement('p');
          newPedido.innerText = `Pedido: ${productName} - Quantidade: ${quantity} - Mesa: ${tableNumber}`;
        
          pedido.appendChild(newPedido);
        }
        </script>
</body>

</html>