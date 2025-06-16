<?php

namespace App\Mail;

use App\Models\Inscrito;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkPagamentoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscrito;
    public $linkPagamento;

    public function __construct(Inscrito $inscrito, $linkPagamento)
    {
        $this->inscrito = $inscrito;
        $this->linkPagamento = $linkPagamento;
    }

    public function build()
    {
        return $this->subject('Link para Pagamento do Evento')
                    ->view('emails.link_pagamento');
    }
}

