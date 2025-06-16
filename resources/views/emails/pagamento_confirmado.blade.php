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
            background-color: #f5f8fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-top: 4px solid #3498db;
        }
        h1 {
            color: #3498db;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin: 10px 0;
        }
        .details {
            background-color: #f1f9ff;
            border: 1px solid #d0e7ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 16px;
        }
        .details p {
            margin: 5px 0;
            font-weight: bold;
        }
        .highlight {
            color: #3498db;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            color: #ffffff;
            background-color: #3498db;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            display: block;
            width: fit-content;
            margin: 0 auto;
        }
        .btn:hover {
            background-color: #2c7ec8;
        }
        .footer {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Pagamento Confirmado!</h1>
        <p>Olá, <span class="highlight">{{ $inscrito->nome }}</span>!</p>
        <p>Estamos felizes em confirmar que seu pagamento foi aprovado e sua inscrição foi confirmada com sucesso.</p>
    </div>
</body>
</html>
