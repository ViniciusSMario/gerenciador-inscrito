<?php

namespace App\Http\Controllers;

use App\Jobs\SendConfirmationEmail;
use App\Jobs\SendConfirmationEmailJob;
use App\Models\Evento;
use App\Models\Inscrito;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewInscritoNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\PaymentService;

class InscricaoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($token = null, $ticket_id = null)
    {
        // Executa a consulta para obter a definição do campo 'estado_civil'
        $type = DB::select(DB::raw("SHOW COLUMNS FROM inscritos LIKE 'estado_civil'"))[0]->Type;

        // Extrai os valores do enum e remove 'enum(' e ')'
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        // Transforma os valores em um array removendo aspas simples
        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));

        // Verifica se o token foi fornecido
        if (is_null($token) || trim($token) === '') {
            $message = 'Token não fornecido!';
            return response()->view('errors.404', ['message' => $message], 404);
        }

        // Verifica se o ticket_id foi fornecido
        if (is_null($ticket_id) || trim($ticket_id) === '') {
            $message = 'Ticket não fornecido!';
            return response()->view('errors.404', ['message' => $message], 404);
        }

        // Verifica se o evento existe
        $evento = Evento::where('token', $token)->first();
        if (!$evento) {
            $message = 'Evento não encontrado!';
            return response()->view('errors.404', ['message' => $message], 404);
        }

        // Verifica se o evento já começou
        if ($evento && Carbon::now()->gte($evento->data_inicio)) {
            return response()->view('errors.default', ['message' => 'O evento já começou, não é possível realizar inscrições.'], 404);
        }

        // Obtém o ticket e verifica se ele existe
        $ticket = Ticket::find($ticket_id);
        if (!$ticket) {
            $message = 'Ticket não encontrado!';
            return response()->view('errors.404', ['message' => $message], 404);
        }

        // Verifica a quantidade de inscritos para o ticket
        $inscritosCount = $ticket->inscritos()->count(); // Assumindo que existe uma relação 'inscritos' no modelo Ticket
        if ($inscritosCount >= $ticket->quantidade) {
            $message = 'Este ticket está esgotado!'; // Define a mensagem de erro
            return response()->view('errors.404', ['message' => $message], 404);
        }

        // Redireciona para o formulário de inscrição se o ticket ainda está disponível
        return view('inscricao.create', compact('evento', 'ticket', 'enumValues'));
    }

    public function store(Request $request)
    {
        // Valida os dados de entrada
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'cpf' => 'required|unique:inscritos,cpf|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'telefone' => 'required|string',
            'data_nascimento' => 'required|date',
            'autorizacao' => 'required|boolean',
            'ticket_id' => 'nullable|exists:tickets,id',
            'estado_civil' => 'required|string',
            'observacao' => 'nullable|string',
        ]);

        // Recupera o ticket e o evento associado
        $ticket = Ticket::find($validatedData['ticket_id']);
        $evento = $ticket ? $ticket->evento : null;

        // Verifica se o evento já começou
        if ($evento && Carbon::now()->gte($evento->data_inicio)) {
            return redirect()->back()->withErrors(['data_inicio' => 'O evento já começou, não é possível realizar inscrições.'])->withInput();
        }

        // Verifica se já existe um inscrito com o mesmo e-mail ou telefone para o evento
        $existeInscricao = Inscrito::where(function ($query) use ($validatedData) {
                $query->where('email', $validatedData['email'])
                      ->orWhere('telefone', $validatedData['telefone']);
            })
            ->where('ticket_id', $validatedData['ticket_id'])
            ->exists();

        if ($existeInscricao) {
            return redirect()->back()->withErrors(['email' => 'Este e-mail ou telefone já está cadastrado para este evento.'])->withInput();
        }

        $validatedData['token'] = Str::random(64);

        $inscrito = Inscrito::create($validatedData);

        // Recupera o evento relacionado ao ticket
        $evento = $inscrito->ticket->evento;

        // Dispara a notificação para os administradores do sistema
        $admins = User::all();
        foreach ($admins as $admin) {
            $admin->notify(new NewInscritoNotification($inscrito, $evento));
        }

        // Dispara o Job para enviar o e-mail de confirmação, passando o inscrito e o evento
        SendConfirmationEmail::dispatch($inscrito, $evento);

        // Enfileira o Job para enviar o e-mail de confirmação
        SendConfirmationEmailJob::dispatch($inscrito);

        // Verifica se o valor do ticket é 0
        if ($ticket && $ticket->valor == 0) {
            $inscrito->status_pagamento = 'pago';
            $inscrito->save();
            // Redireciona diretamente para a página de confirmação
            return view('inscricao.confirmed', compact('inscrito', 'evento'));
        }

        return redirect()->route('inscricao.checkout', [
            'evento_id' => $evento->id,
            'ticket_id' => $ticket->id,
            'inscrito_id' => $inscrito->id,
        ]);
    }

    public function confirmarPresenca($token)
    {
        // Encontre o inscrito pelo token
        $inscrito = Inscrito::where('token', $token)->first();

        // Verifique se o inscrito foi encontrado
        if (!$inscrito) {
            return response()->view('errors.404')->withErrors(['message' => 'Inscrição não encontrada.']);
        }

        if ($inscrito->presenca_confirmada == 1) {
            return view('inscricao.presenca_confirmada');
        }

        // Atualize o status de presença para confirmado
        $inscrito->presenca_confirmada = true;
        $inscrito->save();

        // Redirecione com uma mensagem de confirmação
        return view('inscricao.confirmacao_presenca', compact('inscrito'))->with('success', 'Sua presença foi confirmada com sucesso!');
    }

    public function acessoComQRCode($token)
    {
        $inscrito = Inscrito::where('token', $token)->first();

        if (!$inscrito) {
            // Redirecione para a página de erro 404 com uma mensagem de erro
            return response()->view('errors.404', ['message' => 'Token inválido ou inscrito não encontrado.'], 404);
        }

        if (!$inscrito->pagamentoConfirmado()) {
            return response()->view('inscricao.acessoNegado', ['message' => 'Desculpe. O pagamento não está confirmado!.'], 403);
        }

        if (!$inscrito->temAcessoAoEvento()) {
            // Redirecione para a página de erro 404 com uma mensagem de acesso negado
            return response()->view('errors.404', ['message' => 'Acesso ao evento não permitido.'], 403);
        }

        if ($inscrito->acessouOEvento()) {
            // Redirecione para a página de erro 404 com uma mensagem de evento já acessado
            return response()->view('inscricao.acessoNegado', ['message' => 'Desculpe. O inscrito já acessou o evento.'], 403);
        }

        // Atualize o status de presença para confirmado
        $inscrito->acessou_evento = true;
        $inscrito->save();

        return view('inscricao.acessoConfirmado', compact('inscrito'));
    }

    public function checkout($evento_id, $ticket_id, $inscrito_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $ticket = Ticket::findOrFail($ticket_id);
        $inscrito = Inscrito::findOrFail($inscrito_id);

        if (!$ticket) {
            return redirect()->back()->withErrors('Este evento não possui tickets disponíveis.');
        }

        $paymentService = new PaymentService();

        // Cria o pagamento Pix usando os valores do ticket
        $linkPagamento = $paymentService->criarPagamento($evento->nome, $ticket->valor, 1, $inscrito);

        // Retorna a view de checkout com o link do pagamento
        return view('inscricao.checkout', compact('evento', 'ticket','inscrito', 'linkPagamento'));
    }

    public function inscricaoConfirmada()
    {
        return view('inscricao.confirmed');
    }

}
