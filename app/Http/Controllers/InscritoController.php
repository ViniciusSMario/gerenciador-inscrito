<?php

namespace App\Http\Controllers;

use App\Jobs\SendConfirmationEmail;
use App\Jobs\SendConfirmationEmailJob;
use App\Models\Evento;
use App\Models\Inscrito;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\PaymentService;
use App\Mail\LinkPagamentoMail;
use Illuminate\Support\Facades\Mail;

class InscritoController extends Controller
{
    public function index()
    {
        $inscritos = Inscrito::with('ticket')->paginate(5);
        return view('inscritos.index', compact('inscritos'));
    }

    public function create()
    {
        // Filtra apenas os tickets com quantidade disponível
        $tickets = Ticket::all()->filter(function ($ticket) {
            return $ticket->temVaga(); // Exibe apenas tickets com vagas disponíveis
        });

        // Executa a consulta para obter a definição do campo 'estado_civil'
        $type = DB::select(DB::raw("SHOW COLUMNS FROM inscritos LIKE 'estado_civil'"))[0]->Type;

        // Extrai os valores do enum e remove 'enum(' e ')'
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        // Transforma os valores em um array removendo aspas simples
        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));

        return view('inscritos.create', compact('tickets', 'enumValues'));
    }

    public function store(Request $request)
    {
        // Validação inicial dos campos
        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|max:20',
            'email' => 'required|email',
            'ticket_id' => 'required|exists:tickets,id',
            'autorizacao' => 'required',
            'cpf' => 'required|unique:inscritos,cpf|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
        ]);

        // Verifica se o e-mail ou telefone já estão cadastrados para o mesmo evento
        $verificaDuplicidade = Inscrito::where(function ($query) use ($request) {
                $query->where('email', $request->email)
                      ->orWhere('telefone', $request->telefone);
            })
            ->where('ticket_id', $request->ticket_id)
            ->exists();

        if ($verificaDuplicidade) {
            return redirect()->back()
                ->withErrors(['email' => 'Este e-mail ou telefone já está cadastrado para este evento.'])
                ->withInput();
        }

        // Criação do novo inscrito
        $inscrito = new Inscrito();
        $inscrito->nome = $request->nome;
        $inscrito->email = $request->email;
        $inscrito->cpf = $request->cpf;
        $inscrito->telefone = $request->telefone;
        $inscrito->autorizacao = $request->autorizacao;
        $inscrito->token = Str::random(64);
        $inscrito->observacao = $request->observacao;
        $inscrito->data_nascimento = $request->data_nascimento;
        $inscrito->estado_civil = $request->estado_civil;

        // Verifica se o ticket ainda tem vagas e atribui o ID ao inscrito
        if ($request->ticket_id) {
            $ticket = Ticket::find($request->ticket_id);

            if ($ticket->temVaga()) {
                $inscrito->ticket_id = $ticket->id;
            } else {
                return redirect()->back()
                    ->withErrors(['ticket_id' => 'Este ticket já atingiu o limite de inscritos.'])
                    ->withInput();
            }
        }

        // Salva o inscrito no banco de dados
        $inscrito->save();

        // Recupera o evento relacionado ao ticket
        $evento = $inscrito->ticket->evento;

        // Dispara o Job para enviar o e-mail de confirmação, passando o inscrito e o evento
        SendConfirmationEmail::dispatch($inscrito, $evento);

        // Enfileira o Job para enviar o e-mail de confirmação
        SendConfirmationEmailJob::dispatch($inscrito);

        if ($ticket && $ticket->valor == 0) {
            $inscrito->status_pagamento = 'pago';
            $inscrito->save();

            return redirect()->route('inscritos.index')->with('success', 'Inscrito cadastrado com sucesso!');
        }

        // Inicializa o serviço de pagamento
        $paymentService = new PaymentService();

        // Gera o link de pagamento com base no inscrito e no ticket do evento
        $linkPagamento = $paymentService->criarPagamento($evento->nome, $ticket->valor, 1, $inscrito);

        // Enfileira o envio do e-mail com o link de pagamento
        Mail::to($inscrito->email)->queue(new LinkPagamentoMail($inscrito, $linkPagamento));

        return redirect()->route('inscritos.index')->with('success', 'E-mail com o link de pagamento enviado com sucesso!');
    }

    public function show(Inscrito $inscrito)
    {
        return view('inscritos.show', compact('inscrito'));
    }

    public function edit(Inscrito $inscrito)
    {
        // Filtra apenas os tickets com quantidade disponível
        $tickets = Ticket::all()->filter(function ($ticket) use($inscrito) {
            return $ticket->temVaga() || $ticket->id == $inscrito->ticket_id;
        });

        // Executa a consulta para obter a definição do campo 'estado_civil'
        $type = DB::select(DB::raw("SHOW COLUMNS FROM inscritos LIKE 'estado_civil'"))[0]->Type;

        // Extrai os valores do enum e remove 'enum(' e ')'
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        // Transforma os valores em um array removendo aspas simples
        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));

        return view('inscritos.edit', compact('inscrito', 'tickets', 'enumValues'));
    }

    public function update(Request $request, Inscrito $inscrito)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|max:20',
            'cpf' => 'required|unique:inscritos,cpf|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'email' => 'required|email|unique:inscritos,email,' . $inscrito->id,
            'ticket_id' => 'required|exists:tickets,id',
            'autorizacao' => 'required'
        ]);

        $inscrito->nome = $request->nome;
        $inscrito->email = $request->email;
        $inscrito->cpf = $request->cpf;
        $inscrito->telefone = $request->telefone;
        $inscrito->autorizacao = $request->autorizacao;
        $inscrito->observacao = $request->observacao;
        $inscrito->data_nascimento = $request->data_nascimento;
        $inscrito->estado_civil = $request->estado_civil;

        if ($request->ticket_id) {
            $ticket = Ticket::find($request->ticket_id);

            // Verifica se o ticket ainda tem vagas ou se é o ticket original do inscrito
            if ($ticket->temVaga() || $ticket->id == $inscrito->ticket_id) {
                $inscrito->ticket_id = $ticket->id;
            } else {
                return redirect()->back()
                    ->withErrors(['ticket_id' => 'Este ticket já atingiu o limite de inscritos.'])
                    ->withInput();
            }
        } else {
            $inscrito->ticket_id = null;
        }

        $inscrito->save();

        return redirect()->route('inscritos.index')->with('success', 'Inscrito atualizado com sucesso!');
    }

    public function destroy(Inscrito $inscrito)
    {
        $inscrito->delete();
        return redirect()->route('inscritos.index')->with('success', 'Inscrito excluído com sucesso!');
    }

    public function verInscritos(Evento $evento)
    {
        // Carrega os tickets e seus inscritos associados ao evento
        $evento->load('tickets.inscritos');

        return view('inscritos.visualizar', compact('evento'));
    }

    public function confirmarPresencaInterna($token)
    {
        // Encontre o inscrito pelo token
        $inscrito = Inscrito::where('token', $token)->first();

        // Verifique se o inscrito foi encontrado
        if (!$inscrito) {
            return redirect()->back()->withErrors(['message' => 'Inscrição não encontrada.']);
        }

        if ($inscrito->presenca_confirmada == 1) {
            return redirect()->back()->withErrors(['message' => 'Presença já confirmada.']);
        }

        // Atualize o status de presença para confirmado
        $inscrito->presenca_confirmada = true;
        $inscrito->save();

        // Redirecione com uma mensagem de confirmação
        return redirect()->back()->with('success', 'Inscrito confirmado com sucesso!');
    }
}
