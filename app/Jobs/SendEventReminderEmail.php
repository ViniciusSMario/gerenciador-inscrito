<?php

namespace App\Jobs;

use App\Mail\EventReminderEmail;
use App\Models\Inscrito;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inscrito;
    public $evento;

    /**
     * Cria uma nova instância do Job.
     */
    public function __construct(Inscrito $inscrito, $evento)
    {
        $this->inscrito = $inscrito;
        $this->evento = $evento;
    }

    /**
     * Executa o Job.
     */
    public function handle()
    {
        // Envia o e-mail de lembrete para o inscrito
        Mail::to($this->inscrito->email)->send(new EventReminderEmail($this->inscrito, $this->evento));
    }
}
