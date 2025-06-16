@extends('app', ['activePage' => 'eventos', 'titlePage' => 'Editar Evento'])

@section('title', 'Editar Evento')

@section('content')
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
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-body">
                    <form id="evento-form" action="{{ route('eventos.update', $evento) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="token" value="{{ old('token', $evento->token) }}">

                        <!-- Nome do Evento -->
                        <div class="row">

                            <div class="input-group input-group-static mb-4">
                                <label for="nome">Nome do Evento</label>
                                <input class="form-control" id="nome" type="text" name="nome" class="validate"
                                value="{{ old('nome', $evento->nome) }}" required>
                            </div>
                        </div>

                        <div class="row">

                            <!-- Descrição -->
                            <div class="input-group input-group-static mb-4">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" class="materialize-textarea" required>{{ old('descricao', $evento->descricao) }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Data INICIO -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="data_inicio">Data Início do Evento</label>
                                    <input class="form-control" id="data_inicio" type="date" name="data_inicio" required
                                    value="{{ old('data_inicio', $evento->data_inicio->format('Y-m-d')) }}">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <!-- Data FIM -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="data_fim">Data Final do Evento</label>
                                    <input class="form-control" id="data_fim" type="date" name="data_fim" required
                                        value="{{ old('data_fim', $evento->data_fim->format('Y-m-d')) }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <!-- Horário -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="horario">Horário</label>
                                    <input class="form-control" id="horario" type="text" placeholder="Ex: 19:00 às 22:00" required
                                        value="{{ old('horario', $evento->horario) }}" name="horario" class="validate" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Contato -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="contato">Contato Principal</label>
                                    <input class="form-control phoneMask" id="contato" type="text" value="{{ old('contato', $evento->contato) }}"
                                        name="contato" class="validate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Local -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="local">Local do Evento</label>
                                    <input class="form-control" id="local" type="text" value="{{ old('local', $evento->local) }}" required
                                        placeholder="Ex: Rua, n°, bairro - Cidade/Estado" name="local" class="validate" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Observação -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="observacao">Observação</label>
                                    <textarea class="form-control" id="observacao" name="observacao" class="materialize-textarea">{{ old('observacao', $evento->observacao) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Termo autorizacao -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="termo_autorizacao">Termo de Autorização/Responsabilidade</label>
                                    <textarea class="form-control" id="termo_autorizacao" name="termo_autorizacao" class="materialize-textarea">{{ old('termo_autorizacao', $evento->termo_autorizacao) }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('eventos.index') }}" class="btn btn-sm btn-secondary">
                                <i class="material-icons icon-button me-2 left">arrow_back</i>Voltar
                            </a>
                            <button type="submit" id="submitButton" class="btn btn-sm btn-success">
                                <i class="material-icons icon-button me-2 left">save</i>Salvar
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
            const form = document.querySelector('#evento-form');

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
