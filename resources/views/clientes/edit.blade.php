@extends('app', ['activePage' => 'clientes', 'titlePage' => 'Editar Cliente'])

@section('title', 'Editar Cliente')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Editar Dados do Cliente</h3>

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

                    <form id="cliente-form" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="nome">Nome</label>
                                <input id="nome" type="text" name="nome" class="form-control"
                                       value="{{ old('nome', $cliente->nome) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" class="form-control"
                                       value="{{ old('email', $cliente->email) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="telefone">Telefone</label>
                                <input id="telefone" type="text" name="telefone" class="form-control phoneMask"
                                       value="{{ old('telefone', $cliente->telefone) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                <i class="material-icons icon-button left">arrow_back</i>Voltar
                            </a>

                            <button type="submit" id="submitButton" class="btn btn-success">
                                <i class="material-icons icon-button left">check</i>Salvar Alterações
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
            const form = document.querySelector('#cliente-form');

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
