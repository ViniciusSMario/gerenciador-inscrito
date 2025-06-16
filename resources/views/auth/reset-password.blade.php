@extends('layouts.auth')

@section('title', 'Recuperação de Senha')

@section('content')
    <div class="col-md-6 left-panel">
        <img src="{{ asset('images/logo_eventure_white.png') }}" class="img-fluid" alt="Eventure Logo">
        <h5>Sistema de Gestão de Eventos</h5>
    </div>

    <div class="col-md-6 right-panel">

        <h5 class="center">Recuperação de Senha</h5>

        <!-- Exibição de Mensagens de Erro -->
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

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <a href="{{ route('login') }}" class="btn btn-primary">Voltar para Login</a>
            </div>
        @endif

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token de Redefinição de Senha -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="input-field">
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus>
                <label for="email">Email</label>
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Nova Senha</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <i class="fa fa-eye eye-icon" id="toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <div class="mb-2">
                <label for="password-confirm" class="form-label">Confirme a Nova Senha</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    <i class="fa fa-eye eye-icon" id="toggle-password-confirm"
                        onclick="toggleConfirmPasswordVisibility()"></i>
                </div>
            </div>

            <!-- Botão de Enviar -->
            <div class="center">
                <button type="submit" class="btn waves-effect waves-light blue">
                    <i class="material-icons left">refresh</i>Redefinir Senha
                </button>
            </div>
        </form>

    </div>
@endsection
