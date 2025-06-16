@extends('layouts.inscricao')

@section('title', 'Confirmar Presença')

@section('content')
    <h2 class="text-center my-5">Confirmar Presença</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message') }}
        </div>
    @endif

    <p class="lead text-center">Por favor, clique no botão abaixo para confirmar sua presença no evento.</p>

    <div class="text-center">
        <a href="{{ route('inscricao.confirmar', ['token' => $inscrito->token]) }}" class="btn btn-primary">Confirmar Presença</a>
    </div>
@endsection
