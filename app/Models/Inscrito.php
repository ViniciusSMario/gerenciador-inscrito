<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'ticket_id',
        'telefone',
        'token',
        'observacao',
        'data_nascimento',
        'estado_civil',
        'autorizacao',
        'presenca_confirmada',
        'acessou_evento',
    ];

    protected $dates = ['data_nascimento'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->cpf && !self::isCpfValid($model->cpf)) {
                throw new Exception('O CPF fornecido é inválido.');
            }
        });
    }

    public static function isCpfValid($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Accessor para formatar o Telefone.
     */
    public function getTelefoneAttribute($value)
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
     * Mutator para salvar o Telefone sem formatação no banco de dados.
     */
    public function setTelefoneAttribute($value)
    {
        // Remove todos os caracteres não numéricos antes de salvar no banco
        $this->attributes['telefone'] = preg_replace('/\D/', '', $value);
    }

    public function temAcessoAoEvento()
    {
        return $this->presenca_confirmada == true;
    }

    public function acessouOEvento()
    {
        return $this->acessou_evento == true;
    }

    public function pagamentoConfirmado()
    {
        return $this->status_pagamento == 'pago';

    }
}
