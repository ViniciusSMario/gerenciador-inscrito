@extends('app', ['activePage' => 'inscritos', 'titlePage' => 'Editar Inscrito'])

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="d-flex justify-content-end">
                <a href="{{ route('inscritos.index') }}" class="btn btn-sm btn-primary">
                    Voltar para a Lista
                </a>
            </div>

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
                <div class="card-header">
                    <h4>Editar Inscrito: {{ $inscrito->nome }}</h4>
                </div>
                <div class="card-body">
                    <form id="inscrito-form" action="{{ route('inscritos.update', $inscrito->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-group input-group-static mb-4">
                            <label for="nome">Nome: <strong class="text-danger">*</strong></label>
                            <input type="text" name="nome" id="nome" class="form-control"
                                   value="{{ old('nome', $inscrito->nome) }}" required>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="email">Email: <strong class="text-danger">*</strong></label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $inscrito->email) }}" required>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label for="cpf">CPF: <strong class="text-danger">*</strong></label>
                            <input type="text" name="cpf" id="cpf" class="form-control cpfMask"
                                   value="{{ old('cpf', $inscrito->cpf) }}" required>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="telefone">Telefone: <strong class="text-danger">*</strong></label>
                            <input type="text" name="telefone" id="telefone" class="form-control phoneMask"
                                   value="{{ old('telefone', $inscrito->telefone) }}" required>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="data_nascimento">Data de Nascimento:</label>
                            <input id="data_nascimento" class="form-control" name="data_nascimento" class="datepicker"
                                type="date" value="{{ old('data_nascimento', $inscrito->data_nascimento->format('Y-m-d')) }}" required>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="estado_civil">Estado Civil:</label>
                            <select name="estado_civil" id="estado_civil" class="form-control">
                                @foreach ($enumValues as $value)
                                    <option value="{{ $value }}"
                                        {{ $inscrito->estado_civil == $value ? 'selected' : '' }}>
                                        {{ ucfirst($value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="ticket_id">Ticket:</label>
                            <select name="ticket_id" id="ticket_id" required class="form-control">
                                <option value="">Selecione um ticket</option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->id }}"
                                        {{ $inscrito->ticket_id == $ticket->id ? 'selected' : '' }}>
                                        {{ $ticket->nome }} (Vagas: {{ $ticket->qtdVagasDisponiveis() }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="observacao">Observação: </label>
                            <textarea name="observacao" id="observacao" class="form-control">{{ old('observacao', $inscrito->observacao) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="mb-3">Aceita o Termo de Autorização/Responsabilidade?</label>

                            <div class="form-check mb-2" style="padding-left: 0px">
                                <input class="form-check-input" type="radio" name="autorizacao" id="autorizo" value="1"
                                       {{ old('autorizacao', $inscrito->autorizacao) == '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="autorizo">
                                    Autorizo
                                </label>
                            </div>

                            <div class="form-check" style="padding-left: 0px">
                                <input class="form-check-input" type="radio" name="autorizacao" id="nao_autorizo" value="0"
                                       {{ old('autorizacao', $inscrito->autorizacao) == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="nao_autorizo">
                                    Não autorizo
                                </label>
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-success">Salvar Alterações</button>
                        <a href="{{ route('inscritos.index') }}" class="btn btn-secondary">Cancelar</a>
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
