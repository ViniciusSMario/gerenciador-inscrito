@extends('app', ['activePage' => 'eventos', 'titlePage' => 'Visualizar Evento'])

@section('title', $evento->nome)

@section('content')
    <div class="">
        <div class="row">
            <!-- Exibição de Mensagens de Erro -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Ops! Algo deu errado.</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Exibição de Mensagem de Sucesso -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                    <strong><i class="bi bi-check-circle-fill"></i> Sucesso!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>
        <div class="row">
            <div class="col-sm-7 col-md-7 col-lg-7">
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <!-- Header com título do evento -->
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="card-title text-white fw-bold mb-0">{{ $evento->nome }}</h3>
                    </div>

                    <div class="card-body p-4">
                        <!-- Descrição -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-primary me-3" style="font-size: 36px;">description</i>
                            <div>
                                <strong class="d-block">Descrição:</strong>
                                <p class="text-muted mb-0 text-wrap">{{ $evento->descricao }}</p>
                            </div>
                        </div>

                        <!-- Local -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-danger me-3" style="font-size: 36px;">location_on</i>
                            <div>
                                <strong class="d-block">Local:</strong>
                                <p class="text-muted mb-0 text-wrap">{{ $evento->local }}</p>
                            </div>
                        </div>

                        <!-- Contato -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-info me-3" style="font-size: 36px;">contact_phone</i>
                            <div>
                                <strong class="d-block">Contato:</strong>
                                <p class="text-muted mb-0">
                                    {{ $evento->contato ? $evento->contato : 'Não informado' }}
                                </p>
                            </div>
                        </div>

                        <!-- Datas do Evento -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-success me-3" style="font-size: 36px;">event</i>
                            <div>
                                <strong class="d-block">Data Início:</strong>
                                <p class="text-muted mb-1">{{ $evento->data_inicio->format('d/m/Y') }}</p>
                                <strong class="d-block">Data Final:</strong>
                                <p class="text-muted mb-0">{{ $evento->data_fim->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <!-- Observação -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-warning me-3" style="font-size: 36px;">note_add</i>
                            <div>
                                <strong class="d-block">Observação:</strong>
                                <p class="text-muted mb-0 text-wrap">
                                    {{ $evento->observacao ? $evento->observacao : 'Não informado' }}
                                </p>
                            </div>
                        </div>

                        <!-- Termo -->
                        <div class="info-card mb-3 d-flex align-items-start">
                            <i class="material-icons text-danger me-3" style="font-size: 36px;">description</i>
                            <div>
                                <strong class="d-block">Termo de Autorização/Responsabilidade:</strong>
                                <p class="text-muted mb-0 text-wrap">
                                    {{ $evento->termo_autorizacao ? $evento->termo_autorizacao : 'Não informado' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer gap-2 d-flex align-items-center justify-content-between">
                        <a target="_blank" href="{{ route('eventos.compartilhar', $evento) }}"
                            id="form-evento-compartilhar" class="btn btn-info d-flex align-items-center">
                            <i class="material-icons icon-button me-1">share</i>Compartilhar
                        </a>

                        <a href="{{ route('eventos.edit', $evento) }}"
                            class="btn btn-warning d-flex align-items-center" id="form-evento-editar">
                            <i class="material-icons icon-button me-1">edit</i>Editar
                        </a>
                    
                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST"
                            onsubmit="return confirm('Deseja realmente excluir este evento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mt-3 d-flex align-items-center" id="form-excluir">
                                <i class="material-icons icon-button me-1">delete</i>Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 col-md-5 col-lg-5">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold mb-3">🎟️ Tickets Vinculados</h5>

                        @if ($evento->tickets->count() > 0)
                            <div class="accordion" id="accordionTickets">
                                @foreach ($evento->tickets as $ticket)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $ticket->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $ticket->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $ticket->id }}">
                                                {{ $ticket->nome }} -
                                                <span class="badge bg-primary ms-2">{{ $ticket->quantidade }}
                                                    Tickets</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $ticket->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $ticket->id }}"
                                            data-bs-parent="#accordionTickets">
                                            <div class="accordion-body">
                                                <ul class="list-unstyled">
                                                    <li class="mb-2">
                                                        <strong>Cliente:</strong> {{ $ticket->cliente->nome }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <strong>Quantidade:</strong> {{ $ticket->quantidade }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <strong>Valor Unitário:</strong>
                                                        R$ {{ number_format($ticket->valor, 2, ',', '.') }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <strong>Valor Total:</strong>
                                                        R$
                                                        {{ number_format($ticket->quantidade * $ticket->valor, 2, ',', '.') }}
                                                    </li>
                                                </ul>
                                                <span class="collapse"
                                                    id="link{{ $ticket->id }}">{{ url('inscricao/' . $evento->token . '/' . $ticket->id) }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    onclick="copyToClipboard('link{{ $ticket->id }}')">
                                                    <i class="fa fa-copy icon-button me-2"></i> Copiar Link de inscrição
                                                </button>

                                                <!-- Gerando o QR Code para cada ticket -->
                                                @php
                                                    $link = url('inscricao/' . $evento->token . '/' . $ticket->id);
                                                    $qrCode = \Endroid\QrCode\Builder\Builder::create()
                                                        ->data($link)
                                                        ->size(150)
                                                        ->margin(10)
                                                        ->build();

                                                    $qrCodeBase64 = base64_encode($qrCode->getString());
                                                @endphp

                                                <!-- Exibindo o QR Code -->
                                                <p>
                                                    <strong>QR Code:</strong>
                                                    <br>
                                                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}"
                                                        alt="QR Code do Link de Acesso">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="grey-text text-center">Nenhum ticket vinculado a este evento.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .accordion-button {
            font-weight: bold;
            background-color: #f8f9fa;
            color: #333;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion-body {
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        function copyToClipboard(elementId) {
            // Seleciona o texto no elemento pelo ID
            var text = document.getElementById(elementId).innerText;

            // Cria um elemento de input temporário para copiar o texto
            var tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);

            // Seleciona o texto e copia para a área de transferência
            tempInput.select();
            document.execCommand("copy");

            // Remove o elemento de input temporário
            document.body.removeChild(tempInput);

            // Alerta de confirmação (opcional)
            alert("Link copiado para a área de transferência!");
        }
    </script>

@endsection
