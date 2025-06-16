@extends('layouts.inscricao')

@section('title', 'Pagamento do Evento')

@section('content')
    <div class=" my-5">
        <div class=" ">
            <div class="">
                <h3 class="text-center text-primary">{{ $evento->nome }}</h3>
                <p class="text-muted text-center">
                    <strong>Data:</strong> {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y') }}
                </p>

                <hr class="my-4">

                <h4 class="text-primary">Descrição do Evento</h4>
                <p class="mb-4">{{ $evento->descricao }}</p>

                <h4 class="text-primary">Detalhes do Ticket</h4>
                <ul class="list-unstyled mb-4">
                    <li><strong>Tipo:</strong> {{ $ticket->tipo ?? 'Padrão' }}</li>
                    <li><strong>Valor:</strong> R$ {{ number_format($ticket->valor, 2, ',', '.') }}</li>
                </ul>

                <hr class="my-4">

                <!-- Botão para Pagamento -->
                <div class="text-center">
                    <p>Para concluir a inscrição, clique no botão abaixo para escolher o método de pagamento.</p>
                    <a href="{{ $linkPagamento }}" target="_blank" class="btn btn-primary btn-lg">
                        <i class="bi bi-wallet2"></i> Pagar Agora
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function verificarPagamento() {
            fetch(`/verificar-pagamento/{{ $inscrito->id }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'pago') {
                        window.location.href = '{{ route("inscricao.confirmed") }}';
                    }
                })
                .catch(error => console.error('Erro ao verificar pagamento:', error));
        }

        // Verifica o status do pagamento a cada 5 segundos
        setInterval(verificarPagamento, 5000);
    </script>

@endsection
