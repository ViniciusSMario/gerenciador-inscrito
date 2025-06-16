<?php
namespace App\Jobs;

use App\Mail\ConfirmationEmail;
use App\Models\Inscrito;
use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inscrito;
    public $evento;

    /**
     * Cria uma nova instância do Job.
     */
    public function __construct(Inscrito $inscrito, Evento $evento)
    {
        $this->inscrito = $inscrito;
        $this->evento = $evento;
    }

    /**
     * Executa o Job.
     */
    public function handle()
    {
        // Envia o e-mail de confirmação com o evento
        Mail::to($this->inscrito->email)->send(new ConfirmationEmail($this->inscrito, $this->evento));
    }
}

