@extends('app', ['activePage' => 'tickets', 'titlePage' => 'Editar Ticket'])

@section('title', 'Editar Ticket')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form id="ticket-form" action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label  for="nome">Nome do ticket</label>
                                <input id="nome" class="form-control" name="nome" type="text"
                                    value="{{ old('nome', $ticket->nome) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="evento_id">Evento</label>
                                <select name="evento_id" class="form-control" required>
                                    <option value="" disabled>Selecione um evento</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->id }}"
                                            {{ old('evento_id', $ticket->evento_id) == $evento->id ? 'selected' : '' }}>
                                            {{ $evento->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="cliente_id">Cliente</label>
                                <select name="cliente_id" class="form-control" required>
                                    <option value="" disabled>Selecione um cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ old('cliente_id', $ticket->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label  for="quantidade">Quantidade</label>
                                <input id="quantidade" class="form-control" name="quantidade" type="number"
                                    value="{{ old('quantidade', $ticket->quantidade) }}" required min="1">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-8">
                                <div class="input-group input-group-dynamic">
                                    <label class="form-label" for="valor">Valor Unitário</label>
                                    <input id="valor" class="form-control" value="{{ old('quantidade', $ticket->valor) }}" name="valor" type="number" step="0.01" value="{{ old('valor') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ticket_gratuito" name="ticket_gratuito" onchange="toggleValorField()">
                                    <label class="form-check-label" for="ticket_gratuito">Ticket Gratuito</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                                <i class="material-icons left" style="font-size: 20px;">arrow_back</i>Voltar
                            </a>

                            <button type="submit" id="submitButton"  class="btn btn-sm btn-success">
                                <i class="material-icons left" style="font-size: 20px;">save</i>Salvar Alterações
                            </button>
                        </div>
                    </form>
                    <div id="loadingOverlay" style="
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(255, 255, 255, 0.8);
                        z-index: 9999;
                        align-items: center;
                        justify-content: center;
                    ">
                        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#ticket-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Exibe o overlay de loading
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Desativa o botão de envio e exibe o spinner interno
                document.getElementById('submitButton').disabled = true;

                setTimeout(() => form.submit(), 100);
            });
        });

        function toggleValorField() {
            const gratuitoCheckbox = document.getElementById('ticket_gratuito');
            const valorField = document.getElementById('valor');

            if (gratuitoCheckbox.checked) {
                valorField.value = 0;
                valorField.setAttribute('readonly', true);
            } else {
                valorField.removeAttribute('readonly');
                valorField.value = '';
            }
        }
    </script>
@endsection
