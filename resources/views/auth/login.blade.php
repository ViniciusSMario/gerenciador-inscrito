@extends('layouts.auth')

@section('content')
    <!-- Left Panel -->
    <div class="col-md-6 left-panel">
        <img src="{{ asset('images/logo_eventure_white.png') }}" class="img-fluid" alt="Eventure Logo">
        <h5>Sistema de Gestão de Eventos</h5>
    </div>

    <div class="col-md-6 right-panel">
        <h3 class="center">Seja bem-vindo!</h3>
        @if ($errors->any())
            <div class="card-panel red lighten-4 red-text">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu e-mail">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Digite sua senha">
                    <i class="fa fa-eye eye-icon" id="toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <div class="d-sm-flex justify-content-center">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </form>

        {{-- <div class="d-sm-flex justify-content-center mt-5">
            <div class="field-wrapper">
                <a href="{{ route('register') }}" class="btn btn-info">Criar Conta</a>
            </div>
        </div> --}}

        <div class="text-center mt-5">
            <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        </div>

        <div class="footer center mt-5">© <span id="current-year"></span> InovaFlow - Todos direitos reservados</div>
    </div>
@endsection
