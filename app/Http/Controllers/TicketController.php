<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Evento;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('cliente')->with('evento')->paginate(5);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $eventos = Evento::all();
        return view('tickets.create', compact('clientes', 'eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'evento_id' => 'required|exists:eventos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
        ]);

        $ticket = new Ticket();
        $ticket->nome = $request->nome;
        $ticket->evento_id = $request->evento_id;
        $ticket->cliente_id = $request->cliente_id;
        $ticket->quantidade = $request->quantidade;

        // Define o valor como 0 se o ticket for gratuito
        $ticket->valor = $request->has('ticket_gratuito') ? 0 : $request->valor;

        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }


    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        // Carrega todos os clientes e eventos para os selects
        $clientes = Cliente::all();
        $eventos = Evento::all();

        // Retorna a view de edição com os dados necessários
        return view('tickets.edit', compact('ticket', 'clientes', 'eventos'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required',
            'cliente_id' => 'required|exists:clientes,id',
            'evento_id' => 'required|exists:eventos,id',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
        ]);

        // Atualiza o ticket com os dados do request
        $ticket->update($request->all());

        // Redireciona para a lista de tickets com mensagem de sucesso
        return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket excluído com sucesso!');
    }
}
