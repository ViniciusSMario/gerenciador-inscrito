@extends('app', ['activePage' => 'tickets', 'titlePage' => 'Criar Ticket'])

@section('title', 'Adicionar Tickets')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form id="ticket-form" action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="nome">Nome do ticket</label>
                                <input id="nome" class="form-control" name="nome" type="text"
                                    value="{{ old('nome') }}" required>
                            </div>
                        </div>

                        <div class="row">

                            <div class="input-group input-group-static mb-4">
                                <label for="evento_id">Evento</label>
                                <select name="evento_id" class="form-control" required>
                                    <option value="" disabled selected>Selecione um evento</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->id }}">{{ $evento->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="cliente_id">Cliente</label>
                                <select name="cliente_id" class="form-control" required>
                                    <option value="" disabled selected>Selecione um cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="input-group input-group-static mb-4">
                                <label for="quantidade">Quantidade</label>
                                <input id="quantidade" class="form-control" name="quantidade" type="number"
                                    value="{{ old('quantidade') }}" required min="1">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-8">
                                <div class="input-group input-group-dynamic">
                                    <label class="form-label" for="valor">Valor Unitário</label>
                                    <input id="valor" class="form-control" name="valor" type="number" step="0.01" value="{{ old('valor') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ticket_gratuito" name="ticket_gratuito" onchange="toggleValorField()">
                                    <label class="form-check-label" for="ticket_gratuito">Ticket Gratuito</label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-sm btn-success" id="submitButton">
                            <i class="material-icons left" style="font-size: 20px;">save</i>Salvar
                        </button>
                    </form>
                    <div id="loadingOverlay"
                        style="
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
