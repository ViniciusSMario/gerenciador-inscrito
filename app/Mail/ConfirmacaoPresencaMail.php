<?php
namespace App\Mail;

use App\Models\Inscrito;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoPresencaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscrito;
    public $linkConfirmacao;

    /**
     * Cria uma nova instância do Mailable.
     */
    public function __construct(Inscrito $inscrito)
    {
        $this->inscrito = $inscrito;
        $this->linkConfirmacao = route('inscricao.confirmar', ['token' => $inscrito->token]);
    }

    /**
     * Constrói a mensagem.
     */
    public function build()
    {
        $link = url('inscricao/acesso/qrcode/' . $this->inscrito->token);

        // Gerar o QR Code e obter o conteúdo binário da imagem PNG
        $qrCode = Builder::create()
            ->data($link)
            ->size(150)
            ->margin(10)
            ->build();

        $qrCodePng = $qrCode->getString(); // Obter os dados binários da imagem PNG

        return $this->subject('Confirmação de Presença no Evento')
            ->view('emails.confirmacao_presenca')
            ->with([
                'inscrito' => $this->inscrito,
                'linkConfirmacao' => $this->linkConfirmacao,
                'qrCodeBase64' => base64_encode($qrCodePng), // Passando o QR Code como base64 para a view
            ])
            ->attachData($qrCodePng, 'qrcode.png', [
                'mime' => 'image/png',
            ]);
    }
}
