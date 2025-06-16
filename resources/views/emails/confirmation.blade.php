<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Inscrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #070b3b;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            margin: 15px 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            font-size: 16px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }
        .highlight {
            color: #3498db;
            font-weight: bold;
        }
        .footer {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Olá, <span class="highlight">{{ $inscrito->nome }}</span>!</h1>
        <p>Obrigado por se inscrever no evento <strong>{{ $evento->nome }}</strong>!</p>
        <p><strong>Detalhes do Evento:</strong></p>
        <ul>
            <li><strong>Nome do Evento:</strong> {{ $evento->nome }}</li>
            <li><strong>Local:</strong> {{ $evento->local }}</li>
            <li><strong>Data de Início:</strong> {{ $evento->data_inicio->format('d/m/Y') }}</li>
            <li><strong>Data de Término:</strong> {{ $evento->data_fim->format('d/m/Y') }}</li>
        </ul>
        <p><strong>Detalhes da sua Inscrição:</strong></p>
        <ul>
            <li><strong>Nome:</strong> {{ $inscrito->nome }}</li>
            <li><strong>Email:</strong> {{ $inscrito->email }}</li>
            <li><strong>Telefone:</strong> {{ $inscrito->telefone }}</li>
            <li><strong>Data de Nascimento:</strong> {{ $inscrito->data_nascimento->format('d/m/Y') }}</li>
        </ul>
        <p>Estamos ansiosos para vê-lo no evento!</p>

        <p class="footer">Se precisar de mais informações, entre em contato conosco. Agradecemos pela sua participação!</p>
    </div>
</body>
</html>
