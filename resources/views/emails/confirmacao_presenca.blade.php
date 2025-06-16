<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Presença</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <h1 style="text-align: center; color: #4CAF50;">Confirmação de Presença</h1>

        <p style="font-size: 18px; text-align: center;">Olá, <strong>{{ $inscrito->nome }}</strong>!</p>

        <p style="font-size: 16px; line-height: 1.6;">
            Obrigado por se inscrever no evento. Para confirmar sua presença, clique no botão abaixo:
        </p>

        <p style="text-align: center; margin: 20px 0;">
            <a href="{{ $linkConfirmacao }}" style="background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                Confirmar Presença
            </a>
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Para acessar o evento no dia, utilize o QR Code abaixo. Lembre-se, ele é de uso único e exclusivo, não compartilhe com ninguém.
        </p>

        <div style="text-align: center; margin: 20px 0;">
            <!-- Link para download do QR Code -->
            <a href="data:image/png;base64,{{ $qrCodeBase64 }}" download="qr_code_acesso.png" style="text-decoration: none;">
                <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code de Acesso" style="border: 2px solid #ddd; border-radius: 8px; padding: 10px;">
            </a>
            <p style="font-size: 14px; color: #888; margin-top: 5px;">Clique no QR Code para baixá-lo</p>
        </div>

        <p style="font-size: 16px; line-height: 1.6; text-align: center; color: #555;">
            Estamos ansiosos para vê-lo no evento!
        </p>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <p style="text-align: center; font-size: 14px; color: #999;">
            Caso tenha alguma dúvida, entre em contato com a nossa equipe.
        </p>
    </div>
</body>
</html>
