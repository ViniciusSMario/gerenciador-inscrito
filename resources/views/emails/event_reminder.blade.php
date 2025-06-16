<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembrete do Evento</title>
</head>
<body>
    <h1>Olá, {{ $inscrito->nome }}!</h1>
    <p>Estamos a apenas uma semana do seu evento, <strong>{{ $evento->nome }}</strong>!</p>
    <p>Aqui estão os detalhes:</p>
    <ul>
        <li><strong>Nome do Evento:</strong> {{ $evento->nome }}</li>
        <li><strong>Local:</strong> {{ $evento->local }}</li>
        <li><strong>Data de Início:</strong> {{ $evento->data_inicio->format('d/m/Y') }}</li>
        <li><strong>Data de Término:</strong> {{ $evento->data_fim->format('d/m/Y') }}</li>
    </ul>
    <p>Estamos ansiosos para vê-lo no evento!</p>
</body>
</html>
