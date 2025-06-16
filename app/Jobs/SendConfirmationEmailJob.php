<?php
namespace App\Jobs;

use App\Mail\ConfirmacaoPresencaMail;
use App\Models\Inscrito;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscrito;

    /**
     * Cria uma nova instância do Job.
     */
    public function __construct(Inscrito $inscrito)
    {
        $this->inscrito = $inscrito;
    }

    /**
     * Executa o Job.
     */
    public function handle()
    {
        Mail::to($this->inscrito->email)->send(new ConfirmacaoPresencaMail($this->inscrito));
    }
}
