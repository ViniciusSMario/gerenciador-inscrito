<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada - 404</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container-404 {
            text-align: center;
        }

        .container-404 h1 {
            font-size: 8rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .container-404 h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-404">
        <h1>404</h1>
        <h2>Página Não Encontrada</h2>
        <p class="text-muted">{{ $message ?? 'A página solicitada não foi encontrada.' }}</p>
    </div>
</body>
</html>
