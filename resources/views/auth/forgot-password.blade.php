@extends('layouts.auth')

@section('content')
    <!-- Left Panel -->
    <div class="col-md-6 left-panel">
        <img src="{{ asset('images/logo_eventure_white.png') }}" class="img-fluid" alt="Eventure Logo">
        <h5>Sistema de Gestão de Eventos</h5>
    </div>

    <div class="col-md-6 right-panel">
        @if ($errors->any())
            <div class="card-panel red lighten-4 red-text">
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
                <a href="{{ route('login')}}" class="btn btn-primary">Voltar para Login</a>
            </div>
        @endif

        <!-- Right Panel -->
        <h2>Esqueceu a Senha?</h2>
        <p>Não tem problema! Informe o seu e-mail e enviaremos um link para redefinir sua senha.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail"
                    required>
            </div>

            <div class="d-sm-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Enviar Link</button>
            </div>
        </form>

        <div class="footer center mt-5">© <span id="current-year"></span> InovaFlow - Todos direitos reservados</div>
    </div>
@endsection
