<?php

namespace App\Console\Commands;

use App\Jobs\SendEventReminderEmail;
use App\Models\Evento;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Envia lembretes de evento uma semana antes do início';

    public function handle()
    {
        // Encontra eventos que começarão em uma semana a partir de hoje
        $eventos = Evento::whereDate('data_inicio', Carbon::now()->addWeek()->toDateString())->get();

        foreach ($eventos as $evento) {
            // Envia o e-mail de lembrete para cada inscrito do evento
            foreach ($evento->inscritos as $inscrito) {
                SendEventReminderEmail::dispatch($inscrito, $evento);
            }
        }

        $this->info('Lembretes de eventos enviados com sucesso.');
    }
}
