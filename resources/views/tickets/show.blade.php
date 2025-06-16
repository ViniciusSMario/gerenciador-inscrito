@extends('app', ['activePage' => 'tickets', 'titlePage' => 'Detalhes do Ticket'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0 text-white">Detalhes do Ticket</h4>
                </div>

                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nome:</strong>
                            <span>{{ $ticket->nome }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Evento:</strong>
                            <span>{{ $ticket->evento->nome }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Cliente:</strong>
                            <span>{{ $ticket->cliente->nome }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Quantidade:</strong>
                            <span>{{ $ticket->quantidade }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Valor Unitário:</strong>
                            <span>R$ {{ number_format($ticket->valor, 2, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Valor Total:</strong>
                            <span>R$ {{ number_format($ticket->quantidade * $ticket->valor, 2, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>

                <div class="card-footer d-flex justify-content-end gap-2 p-3">
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary d-flex align-items-center">
                        <i class="material-icons me-1">arrow_back</i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
