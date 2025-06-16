<?php

namespace App\Notifications;

use App\Models\Evento;
use App\Models\Inscrito;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInscritoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $inscrito;
    public $evento;

    /**
     * Cria uma nova instância da notificação.
     */
    public function __construct(Inscrito $inscrito, Evento $evento)
    {
        $this->inscrito = $inscrito;
        $this->evento = $evento;
    }

    /**
     * Determina os canais de notificação.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Notificação via banco de dados.
     */
    public function toDatabase($notifiable)
    {
        return [
            'nome' => $this->inscrito->nome,
            'email' => $this->inscrito->email,
            'telefone' => $this->inscrito->telefone,
            'id' => $this->inscrito->id,
            'mensagem' => "Um novo inscrito, {$this->inscrito->nome}, foi cadastrado no evento {$this->evento->nome}.",
        ];
    }
}
