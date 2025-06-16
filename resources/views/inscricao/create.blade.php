@extends('layouts.inscricao')

@section('title', 'Inscrição para Evento')

@section('content')
    <div class="icon-container">
        <i class="bi bi-person-circle"></i>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card z-depth-2">
                <div class="card-content">
                    <span class="card-title center">Inscrição para {{$evento->nome}}</span>

                    <!-- Exibição de Erros -->
                    @if ($errors->any())
                        <div class="card-panel red lighten-4 red-text text-darken-4">
                            <strong><i class="material-icons left">error</i> Ops! Algo deu errado:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Exibição de Sucesso -->
                    @if (session('success'))
                        <div class="card-panel green lighten-4 green-text text-darken-4">
                            <strong><i class="material-icons left">check_circle</i> Sucesso!</strong>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulário -->
                    <form action="{{ route('inscricao.store') }}" method="POST">
                        @csrf

                        <!-- Nome, Email e CPF -->
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="nome" type="text" name="nome" class="@error('nome') invalid @enderror"
                                    value="{{ old('nome') }}" required>
                                <label for="nome">Nome Completo *</label>
                                @error('nome')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="email" type="email" name="email"
                                    class="@error('email') invalid @enderror" value="{{ old('email') }}" required>
                                <label for="email">Email *</label>
                                @error('email')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="cpf" type="text" name="cpf"
                                    class="cpfMask @error('cpf') invalid @enderror" value="{{ old('cpf') }}" required>
                                <label for="cpf">CPF *</label>
                                @error('cpf')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="telefone" type="text" name="telefone"
                                    class="phoneMask @error('telefone') invalid @enderror" value="{{ old('telefone') }}"
                                    required>
                                <label for="telefone">Telefone *</label>
                                @error('telefone')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Data de Nascimento e Estado Civil -->
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="data_nascimento" type="date" name="data_nascimento"
                                    value="{{ old('data_nascimento') }}">
                                <label for="data_nascimento">Data de Nascimento</label>
                                @error('data_nascimento')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6">
                                <select name="estado_civil" required>
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($enumValues as $estadoCivil)
                                        <option value="{{ $estadoCivil }}"
                                            {{ old('estado_civil') == $estadoCivil ? 'selected' : '' }}>
                                            {{ ucfirst($estadoCivil) }}</option>
                                    @endforeach
                                </select>
                                <label>Estado Civil</label>
                                @error('estado_civil')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ticket -->
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input id="ticket" type="text"
                                    value="{{ $ticket->evento->nome }} - R$ {{ number_format($ticket->valor, 2, ',', '.') }}"
                                    disabled>
                                <label for="ticket">Ticket Selecionado *</label>
                            </div>
                        </div>

                        <!-- Termo de Autorização -->
                        <fieldset>
                            <legend class="h6">Aceita o Termo de Autorização?</legend>
                            <p>
                                <label>
                                    <input name="autorizacao" type="radio" value="1" required
                                        {{ old('autorizacao') == '1' ? 'checked' : '' }} />
                                    <span>Autorizo</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="autorizacao" type="radio" value="0"
                                        {{ old('autorizacao') == '0' ? 'checked' : '' }} />
                                    <span>Não autorizo</span>
                                </label>
                            </p>
                        </fieldset>

                        <!-- Observação -->
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea id="observacao" name="observacao" class="materialize-textarea">{{ old('observacao') }}</textarea>
                                <label for="observacao">Observação</label>
                            </div>
                        </div>

                        <!-- Botão de Envio -->
                        <div class="row">
                            <div class="col s12 center">
                                <button type="submit" class="btn waves-effect waves-light green">
                                    Enviar Inscrição
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
