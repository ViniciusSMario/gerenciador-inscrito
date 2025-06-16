@extends('app', ['activePage' => 'eventos', 'titlePage' => 'Adicionar Evento'])

@section('title', 'Criar Evento')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Dados do Evento</h3>
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

                    <form id="evento-form" action="{{ route('eventos.store') }}" method="POST">
                        @csrf
                        <!-- Nome do Evento -->
                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="nome">Nome do Evento</label>
                                <input id="nome" type="text" name="nome" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Descrição -->
                            <div class="input-group input-group-static mb-4">
                                <label for="descricao">Descrição</label>
                                <input id="descricao" type="text" name="descricao" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Data INICIO -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="data_inicio">Data Início do Evento</label>
                                    <input id="data_inicio" type="date" name="data_inicio"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Data FIM -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="data_fim">Data Final do Evento</label>
                                    <input id="data_fim" type="date" name="data_fim" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <!-- Horário -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="horario">Horário</label>
                                    <input id="horario" type="text" name="horario" class="validate form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-static mb-4">
                                    <label for="contato">Contato Principal</label>
                                    <input id="contato" type="text" name="contato" class="validate form-control phoneMask">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Local -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="local">Local do Evento</label>
                                    <input id="local" type="text" name="local" class="validate form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Contato -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Observação -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="observacao">Observação</label>
                                    <textarea id="observacao" name="observacao" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Termo de autorizacao -->
                                <div class="input-group input-group-static mb-4">
                                    <label for="termo_autorizacao">Termo de
                                        Autorização/Responsabilidade</label>
                                    <textarea id="termo_autorizacao" name="termo_autorizacao" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class=" d-flex justify-content-between">
                            <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                                <i class="material-icons icon-button left">arrow_back</i>Voltar
                            </a>

                             <!-- Botão de Envio -->
                            <button type="submit" class="btn btn-success" id="submitButton">
                                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                                <span id="submitButtonText">Criar Evento</span>
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
            // Adiciona evento ao formulário para mostrar o overlay de loading apenas no envio
            const form = document.querySelector('#evento-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Exibe o overlay de loading
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Desativa o botão de envio e exibe o spinner interno
                document.getElementById('submitButton').disabled = true;
                document.getElementById('loadingSpinner').classList.remove('d-none');
                document.getElementById('submitButtonText').textContent = 'Enviando...';

                setTimeout(() => form.submit(), 100);
            });
        });
    </script>

@endsection
