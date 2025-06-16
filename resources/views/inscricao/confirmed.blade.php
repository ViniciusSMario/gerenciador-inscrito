@extends('layouts.inscricao')

@section('title', 'Inscrição Realizada')

@section('content')
    <style>
        .btn-home {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #218838;
        }
    </style>
    <div class="text-center">
        <h1 class="mb-4">Inscrição Confirmada!</h1>
        <p class="lead mb-4">Obrigado por se inscrever no nosso evento. Em breve, enviaremos mais detalhes para o seu email.</p>
        <p class="text-muted mb-4">Caso tenha dúvidas, entre em contato com nossa equipe de suporte.</p>
    </div>
@endsection
