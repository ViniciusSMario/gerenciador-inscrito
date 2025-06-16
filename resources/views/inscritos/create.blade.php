@extends('app', ['activePage' => 'inscritos', 'titlePage' => 'Cadastrar Inscrito'])

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
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

        <div class="card">
            <div class="card-body">
                <form id="inscrito-form" action="{{ route('inscritos.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="nome">Nome Completo: <strong class="text-danger">*</strong></label>
                                <input id="nome" class="form-control" name="nome" type="text"
                                    value="{{ old('nome') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="email">Email: <strong class="text-danger">*</strong></label>
                                <input id="email" class="form-control" name="email" type="email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="cpf">CPF: <strong class="text-danger">*</strong></label>
                                <input id="cpf" class="form-control cpfMask" name="cpf" type="text"
                                    value="{{ old('cpf') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="telefone">Contato: <strong class="text-danger">*</strong></label>
                                <input id="telefone" class="form-control phoneMask" name="telefone" type="text"
                                value="{{ old('telefone') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <!-- Estado Civil -->
                                <label for="estado_civil">Estado Civil:</label>
                                <select class="form-control" name="estado_civil" required>
                                    <option value="" disabled selected>Selecione o estado civil</option>
                                    @foreach ($enumValues as $estadoCivil)
                                        <option value="{{ $estadoCivil }}">{{ ucfirst($estadoCivil) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="data_nascimento">Data de Nascimento:</label>
                                <input id="data_nascimento" class="form-control" name="data_nascimento" class="datepicker"
                                    type="date" value="{{ old('data_nascimento') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Observação -->
                        <div class="input-group input-group-static mb-4">
                            <label for="observacao">Observação:</label>
                            <textarea class="form-control" id="observacao" name="observacao" class="materialize-textarea">{{ old('observacao') }}</textarea>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label>Associar a um Ticket: <strong class="text-danger">*</strong></label>
                                <select class="form-control" required name="ticket_id">
                                    <option value="" disabled selected>Selecione um Ticket</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->nome }} ({{ $ticket->evento->nome }}) - R$
                                            {{ number_format($ticket->valor, 2, ',', '.') }} (Disponível:
                                            {{ $ticket->quantidade - $ticket->inscritos()->count() }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-3">Aceita o Termo de Autorização/Responsabilidade?</label>

                            <div class="form-check mb-2" style="padding-left: 0px">
                                <input class="form-check-input" type="radio" name="autorizacao" id="autorizo" value="1" required>
                                <label class="form-check-label" for="autorizo">
                                    Autorizo
                                </label>
                            </div>

                            <div class="form-check" style="padding-left: 0px">
                                <input class="form-check-input" type="radio" name="autorizacao" id="nao_autorizo" value="0">
                                <label class="form-check-label" for="nao_autorizo">
                                    Não autorizo
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-success" id="submitButton">
                            <i class="material-icons icon-button me-2 left">save</i>Cadastrar
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#inscrito-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Exibe o overlay de loading
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Desativa o botão de envio e exibe o spinner interno
                document.getElementById('submitButton').disabled = true;

                setTimeout(() => form.submit(), 100);
            });
        });
    </script>

@endsection
