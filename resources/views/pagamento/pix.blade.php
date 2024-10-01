@extends('layouts.gerenciamento')

@section('content')
<div class="container text-center mt-3 mb-3">
    <div class="row mt-3 mb-3">
        <div class="col-8 rounded mx-auto" style="background-color: #ffffff">
            <h1 class="mt-5">Pagamento com Pix</h1>

            <div class="mt-4">
                <img src="data:image/png;base64,{{ $qrCodeImage }}" alt="QR Code Pix">
            </div>

            <div class="mt-4">
                <p><strong>Código Copia e Cola:</strong></p>
                <div class="alert alert-info">
                    {{ $copiaCola }}
                </div>
                <button class="btn" style="background-color: #35221B; color: #f1f1f1" onclick="copyToClipboard()">Copiar Código</button>
            </div>

            <div class="mt-4">
                <p><strong>Tempo restante:</strong></p>
                <div id="timer" class="h4"></div>
            </div>

            <div class="mt-5 mb-3">
                <button class="btn" style="background-color: #35221B; color: #f1f1f1"
                    onclick="continuePayment()">Continuar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = "{{ $copiaCola }}";
        navigator.clipboard.writeText(copyText);
        alert('Código copiado!');
    }

    var timeLeft = 15 * 60;
    var timerElement = document.getElementById('timer');

    function updateTimer() {
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;

        seconds = seconds < 10 ? '0' + seconds : seconds;

        timerElement.innerHTML = minutes + ":" + seconds;

        if (timeLeft <= 0) {
            window.location.href = "{{ route('carrinho.pagar') }}";
        } else {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
    }

    updateTimer();

    function continuePayment() {
        window.location.href = "{{ route('pagamento.success') }}";
    }
</script>
@endsection