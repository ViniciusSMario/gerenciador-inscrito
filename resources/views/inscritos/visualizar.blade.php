@extends('app', ['activePage' => 'inscritos', 'titlePage' => 'Visualizar Inscritos do Evento'])

@section('content')
    <div class="row justify-content-center">

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
        <div class="card card-body col-md-12">
            <h4 class="text-center mb-5">Inscritos do Evento: <strong>{{ $evento->nome }}</strong></h4>

            <div class="accordion" id="accordionTickets">
                @foreach ($evento->tickets as $ticket)
                    <div class="accordion-item border rounded mb-3 shadow-sm">
                        <h2 class="accordion-header" id="heading{{ $ticket->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $ticket->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $ticket->id }}">
                                <div class="px-2 d-flex justify-content-between w-100 align-items-center">
                                    <span>Ticket: <strong>{{ $ticket->nome }}</strong></span>
                                    <span class="badge bg-primary ms-3">
                                        Disponíveis: {{ $ticket->quantidade - $ticket->inscritos()->count() }}
                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $ticket->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $ticket->id }}" data-bs-parent="#accordionTickets">
                            <div class="accordion-body p-3">
                                <div class="d-flex justify-content-between mb-2">

                                    <span><strong>Quantidade Total:</strong> {{ $ticket->quantidade }}</span>
                                    <span><strong>Valor:</strong> R$ {{ $ticket->valor }}</span>
                                    <span><strong>Valor Total:</strong> R$ {{ number_format($ticket->quantidade * $ticket->valor, 2, ',', '.') }} </span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr class="text-center">
                                                <th>Informações</th>
                                                <th>Confirmou Presença</th>
                                                <th>Pagamento</th>
                                                <th>Compareceu</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @if ($ticket->inscritos->count() <= 0)
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">
                                                        Nenhum inscrito vinculado
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($ticket->inscritos as $inscrito)
                                                    <tr>
                                                        <td>
                                                            {{ $inscrito->nome }}
                                                            <br>
                                                            <small>
                                                                {{ $inscrito->email }}
                                                            </small>
                                                            <br>
                                                            <small>
                                                                {{ $inscrito->telefone }}
                                                            </small>
                                                        </td>
                                                        <td class="text-center">{!! $inscrito->presenca_confirmada == 1 ? '<strong class="text-success">Sim</strong>' : '<strong class="text-danger">Não</strong>' !!}</td>
                                                        <td class="text-center">
                                                            @if ($inscrito->status_pagamento == 'pago')
                                                                <strong class="text-success">{{ ucfirst($inscrito->status_pagamento) }}</strong>
                                                            @else
                                                                <strong class="text-danger">{{ ucfirst($inscrito->status_pagamento) }}</strong>
                                                            @endif
                                                        </td>                                                        <td class="text-center">{!! $inscrito->acessou_evento == 1 ? '<strong class="text-success">Sim</strong>' : '<strong class="text-danger">Não</strong>' !!}</td>
                                                        <td>
                                                            @if ($inscrito->presenca_confirmada == 0)
                                                                <a href="{{ route('inscrito.confirmar', ['token' => $inscrito->token]) }}" class="btn btn-sm btn-primary">Confirmar Presença</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="material-icons me-1">arrow_back</i>Voltar
                </a>
            </div>
        </div>
    </div>

    <style>
        .accordion-button {
            font-weight: bold;
            color: #333;
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #e0e0e0;
        }

        .accordion-body {
            background-color: #fff;
            border-top: 1px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.9rem;
        }
    </style>
@endsection
