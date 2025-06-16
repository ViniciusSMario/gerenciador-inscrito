<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'evento_id', 'cliente_id', 'quantidade', 'valor'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class);
    }

    // Verifica se ainda há vagas disponíveis para este ticket
    public function temVaga()
    {
        return $this->inscritos()->count() < $this->quantidade;
    }

    // Verifica se ainda há vagas disponíveis para este ticket
    public function qtdVagasDisponiveis()
    {
        return ($this->quantidade - $this->inscritos()->count());
    }
}

