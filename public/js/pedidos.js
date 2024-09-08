function anotarPedido() {
    var nomeProduto = "Café"; // Nome do produto que você deseja adicionar ao pedido
    var quantidade = parseInt(document.getElementById("quantidade").value); // Quantidade selecionada

    // Montar o texto do novo pedido
    var novoPedido = quantidade + "x " + nomeProduto;

    // Atualizar o parágrafo com o novo pedido
    document.getElementById("pedido").innerText = "Pedido: " + novoPedido;
}
