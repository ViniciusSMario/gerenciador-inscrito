<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Inscrito;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::count();
        $tickets = Ticket::count();
        $eventos = Evento::count();
        $inscritos = Inscrito::count();

        $eventos_hoje = Evento::where('data_inicio', '<=', Carbon::now())
            ->where('data_fim', '>=', Carbon::now())
            ->limit(10)
            ->get();

        $proximos_eventos = Evento::where('data_inicio', '>=', Carbon::now())
            ->where('data_fim', '<=', Carbon::now()->addMonth(1))
            ->limit(10)
            ->get();

        // Consulta para somar valores e contar a quantidade de tickets pagos no mês atual, agrupados por data
        $dadosPagamentos = Inscrito::selectRaw('DATE(inscritos.created_at) as date, SUM(tickets.valor) as total_valor, COUNT(*) as total_tickets')
            ->join('tickets', 'inscritos.ticket_id', '=', 'tickets.id')
            ->where('inscritos.status_pagamento', 'pago')
            ->whereYear('inscritos.created_at', Carbon::now()->year)
            ->whereMonth('inscritos.created_at', Carbon::now()->month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Preparar os dados para o Chart.js
        $labels = $dadosPagamentos->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d/m'));
        $valoresTotais = $dadosPagamentos->pluck('total_valor');
        $quantidadesTickets = $dadosPagamentos->pluck('total_tickets');


        // Consulta para somar valores e contar a quantidade de tickets pagos no mês atual, agrupados por data
        $dadosPagamentosAnual = Inscrito::selectRaw('DATE(inscritos.created_at) as date, SUM(tickets.valor) as total_valor_anual, COUNT(*) as total_tickets_anual')
          ->join('tickets', 'inscritos.ticket_id', '=', 'tickets.id')
          ->where('inscritos.status_pagamento', 'pago')
          ->whereYear('inscritos.created_at', Carbon::now()->year)
          ->groupBy('date')
          ->orderBy('date', 'asc')
          ->get();

        // Preparar os dados para o Chart.js
        $labelsAnual = $dadosPagamentosAnual->pluck('date')->map(fn($date) => Carbon::parse($date)->format('Y'));
        $valoresTotaisAnual = $dadosPagamentosAnual->pluck('total_valor_anual');
        $quantidadesTicketsAnual = $dadosPagamentosAnual->pluck('total_tickets_anual');

        // Consulta para obter valores e quantidades de tickets pagos agrupados por evento
        $dadosPagamentosEvento = Inscrito::selectRaw('eventos.nome as evento_nome, SUM(tickets.valor) as total_valor_evento, COUNT(*) as total_tickets_evento')
            ->join('tickets', 'inscritos.ticket_id', '=', 'tickets.id')
            ->join('eventos', 'tickets.evento_id', '=', 'eventos.id')
            ->where('inscritos.status_pagamento', 'pago')
            ->groupBy('evento_nome')
            ->orderBy('evento_nome', 'asc')
            ->get();

        // Preparar os dados para o Chart.js
        $labelsEvento = $dadosPagamentosEvento->pluck('evento_nome'); // Nome dos eventos para o eixo X
        $valoresTotaisEvento = $dadosPagamentosEvento->pluck('total_valor_evento'); // Valores totais pagos por evento
        $quantidadesTicketsEvento = $dadosPagamentosEvento->pluck('total_tickets_evento'); // Quantidade de tickets pagos por evento

        return view('dashboard.index', compact(
            'clientes',
            'eventos',
            'inscritos',
            'tickets',
            'proximos_eventos',
            'eventos_hoje',
            'labels',
            'valoresTotais',
            'quantidadesTickets',
            'labelsAnual',
            'valoresTotaisAnual',
            'quantidadesTicketsAnual',
            'labelsEvento',
            'valoresTotaisEvento',
            'quantidadesTicketsEvento'
        ));
    }

    public function showNotifications()
    {
        // Recupera as notificações não lidas do administrador logado
        $notifications = auth()->user()->unreadNotifications;

        return view('dashboard.notifications', compact('notifications'));
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->route('notificacoes.notificacoes')->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function showCalendario()
    {
        return view('calendario.calendario');
    }

    public function showEventosCalendario()
    {
        $eventos = Evento::all(['nome as title', 'data_inicio as start', 'data_fim']);

        // Adiciona um dia à data_fim para que FullCalendar a inclua corretamente
        $eventos = $eventos->map(function ($evento) {
            $evento->end = Carbon::parse($evento->data_fim)->addDay()->format('Y-m-d');
            return $evento;
        });

        return response()->json($eventos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
