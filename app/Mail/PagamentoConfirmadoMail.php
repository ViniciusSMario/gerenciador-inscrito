<?php
namespace App\Mail;

use App\Models\Inscrito;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PagamentoConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscrito;

    public function __construct(Inscrito $inscrito)
    {
        $this->inscrito = $inscrito;
    }

    public function build()
    {
        return $this->subject('Pagamento Confirmado')
                    ->view('emails.pagamento_confirmado');
    }
}
