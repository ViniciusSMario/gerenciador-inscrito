<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_inicio',
        'data_fim',
        'local',
        'token',
        'horario',
        'observacao',
        'contato',
        'termo_autorizacao',
        'flg_ativo',
    ];

    // Garantir que o campo 'data' seja tratado como Carbon
    protected $dates = ['data_inicio', 'data_fim'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Função para verificar se algum ticket tem inscritos
    public function temInscritos()
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->inscritos()->exists()) {
                return true; // Retorna verdadeiro se algum ticket tiver inscritos
            }
        }
        return false; // Retorna falso se nenhum ticket tiver inscritos
    }

    // /**
    //  * Mutator para formatar a data antes de salvar no banco de dados.
    //  */
    // public function setDataInicioAttribute($value)
    // {
    //     $this->attributes['data_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    // public function setDataFimAttribute($value)
    // {
    //     $this->attributes['data_fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    /**
     * Accessor para formatar o Contato.
     */
    public function getContatoAttribute($value)
    {
        // Remove caracteres não numéricos
        $numeroLimpo = preg_replace('/\D/', '', $value);

        // Aplica a máscara dependendo do tamanho do número
        if (strlen($numeroLimpo) === 11) {
            // Ex: (11) 98765-4321
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $numeroLimpo);
        } elseif (strlen($numeroLimpo) === 10) {
            // Ex: (11) 8765-4321
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $numeroLimpo);
        }

        // Retorna o número original se não corresponder ao formato esperado
        return $value;
    }

    /**
     * Mutator para salvar o Contato sem formatação no banco de dados.
     */
    public function setContatoAttribute($value)
    {
        // Remove todos os caracteres não numéricos antes de salvar no banco
        $this->attributes['contato'] = preg_replace('/\D/', '', $value);
    }
}
