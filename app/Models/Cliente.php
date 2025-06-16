<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
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
}

