@extends('layouts.auth')

@section('content')
    <div class="col-md-6 left-panel">
        <img src="{{ asset('images/logo_eventure_white.png') }}" class="img-fluid" alt="Eventure Logo">
        <h5>Sistema de Gestão de Eventos</h5>
    </div>

    <div class="col-md-6 right-panel">
        <div class="d-flex justify-content-center">
            <a href="{{ route('login')}}" class="btn btn-info">Voltar para Login</a>
        </div>
        <h3 class="py-0 center">Registre-se</h3>

        @if ($errors->any())
            <div class="card-panel red lighten-4 red-text">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-2">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    required>
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    required>
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Senha</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <i class="fa fa-eye eye-icon" id="toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <div class="mb-2">
                <label for="password-confirm" class="form-label">Confirmar Senha</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    <i class="fa fa-eye eye-icon" id="toggle-password-confirm"
                        onclick="toggleConfirmPasswordVisibility()"></i>
                </div>
            </div>

            <div class="d-sm-flex justify-content-center">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </form>

        <div class="footer center mt-2">© <span id="current-year"></span> InovaFlow - Todos direitos reservados</div>
    </div>
@endsection
