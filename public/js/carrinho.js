// Função para abrir o pop-up de pagamento
function openPaymentPopup() {
    document.getElementById("paymentPopup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

// Função para fechar os pop-ups
function closePopup() {
    document.getElementById("paymentPopup").style.display = "none";
    document.getElementById("messagePopup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

// Função para adicionar um novo cartão
function addNewCard() {
    var newCard = prompt("Por favor, insira o número do novo cartão:");
    if (newCard != null) {
        var select = document.querySelector('select');
        var option = document.createElement('option');
        option.text = newCard;
        select.add(option);
    }
}

// Função para selecionar um endereço já cadastrado
function selectAddress(address) {
    document.querySelector('input[placeholder="Endereço"]').value = address;
}

// Função para editar um endereço já cadastrado
function editAddress(address) {
    var newAddress = prompt("Por favor, insira o novo endereço:", address);
    if (newAddress != null) {
        // Aqui você pode adicionar a lógica para atualizar o endereço no sistema
        // Por enquanto, vamos apenas atualizar o valor no campo de entrada
        selectAddress(newAddress);
    }
}

// Função para excluir um endereço cadastrado
function deleteAddress(address) {
    if (confirm("Tem certeza de que deseja excluir este endereço?")) {
        // Aqui você pode adicionar a lógica para excluir o endereço do sistema
        // Por enquanto, vamos apenas remover o elemento da lista de endereços
        var addressOptions = document.getElementById("addressOptions");
        var addressElements = addressOptions.getElementsByClassName("address-option");
        for (var i = 0; i < addressElements.length; i++) {
            var span = addressElements[i].getElementsByTagName("span")[0];
            if (span.innerHTML === address) {
                addressOptions.removeChild(addressElements[i]);
                break;
            }
        }
    }
}

// Função para selecionar um cartão já cadastrado
function selectCard(card) {
    var select = document.querySelector('select');
    select.value = card;
}

// Função para excluir um cartão cadastrado
function deleteCard(card) {
    if (confirm("Tem certeza de que deseja excluir este cartão?")) {
        var select = document.querySelector('select');
        var options = select.getElementsByTagName('option');
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === card) {
                select.removeChild(options[i]);
                break;
            }
        }
    }
}

// Função para realizar o pagamento
function makePayment() {
    // Simulando um tempo de entrega entre 15 e 30 minutos
    var deliveryTime = Math.floor(Math.random() * (30 - 15 + 1)) + 15;
    document.getElementById("deliveryTime").innerHTML = deliveryTime;
    document.getElementById("paymentPopup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
    document.getElementById("messagePopup").style.display = "block";
}
