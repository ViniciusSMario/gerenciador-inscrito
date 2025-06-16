<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link para Pagamento do Evento</title>
    <style>
        /* Estilos globais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #094b83;
            font-size: 24px;
            text-align: center;
        }
        
        p {
            font-size: 16px;
            line-height: 1.6;
            text-align: center;
            margin: 10px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #057ecf;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px auto;
            text-align: center;
        }
        
        .btn:hover {
            background-color: #094b83;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Olá, {{ $inscrito->nome }}!</h1>
        <p>Para completar sua inscrição no evento, por favor, realize o pagamento clicando no botão abaixo:</p>
        <p>
            <a href="{{ $linkPagamento }}" target="_blank" class="btn">Pagar Agora</a>
        </p>
        <p>Estamos ansiosos para ver você no evento!</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} - Gerenciador de Inscrições
    </div>
</body>
</html>
