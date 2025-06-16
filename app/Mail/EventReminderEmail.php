<?php

namespace App\Mail;

use App\Models\Inscrito;
use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscrito;
    public $evento;

    /**
     * Cria uma nova instância do Mailable.
     */
    public function __construct(Inscrito $inscrito, Evento $evento)
    {
        $this->inscrito = $inscrito;
        $this->evento = $evento;
    }

    /**
     * Constrói o e-mail.
     */
    public function build()
    {
        return $this->subject('Lembrete: Seu evento está se aproximando!')
                    ->view('emails.event_reminder')
                    ->with([
                        'inscrito' => $this->inscrito,
                        'evento' => $this->evento,
                    ]);
    }
}
