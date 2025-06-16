@extends('layouts.inscricao') <!-- Altere o layout para um layout público -->

@section('title', $evento->nome)

@section('content')
    <div class="icon-container">
        <i class="bi bi-calendar-check-fill"></i>
    </div>
    <!-- Título do Evento -->
    <div class="text-center">
        <h1 class="text-primary fw-bold">{{ $evento->nome }}</h1>
        <p class="text-muted">
            <strong>Data:</strong>
            {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y') }}
        </p>
    </div>

    <hr class="my-1">

    <!-- Descrição do Evento -->
    <div class="mb-3">
        <h5 class="text-secondary fw-semibold mb-3">
            <i class="bi bi-info-circle-fill text-primary"></i> Descrição do Evento
        </h5>
        <p class="fs-5">{{ $evento->descricao }}</p>
    </div>

    <!-- Detalhes do Evento -->
    <div class="mb-3">
        <h5 class="text-secondary fw-semibold mb-3">
            <i class="bi bi-calendar-event-fill text-success"></i> Detalhes do Evento
        </h5>
        <ul class="list-group list-group-flush fs-5">
            <li class="list-group-item">
                <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y H:i') }}
            </li>
            <li class="list-group-item">
                <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}
            </li>
            <li class="list-group-item">
                <strong>Local:</strong> {{ $evento->local }}
            </li>
            <li class="list-group-item">
                <strong>Contato:</strong> {{ $evento->contato }}
            </li>
        </ul>
    </div>
@endsection
