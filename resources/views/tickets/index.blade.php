@extends('app', ['activePage' => 'tickets', 'titlePage' => 'Tickets'])

@section('title', 'Tickets')

@section('content')
    <div class="">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- Exibição de Mensagens de Erro -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill"></i> Ops! Algo deu errado.</strong>
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Exibição de Mensagem de Sucesso -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> Sucesso!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-success">
                                Adicionar Ticket
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ticket</th>
                                        <th>Evento</th>
                                        <th>Cliente</th>
                                        <th>Quantidade</th>
                                        <th>Valor Unitário</th>
                                        <th>Valor Total</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tickets) <= 0)
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                Não há tickets cadastrados
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($tickets as $ticket)
                                            <tr class="text-center">
                                                <td>{{ $ticket->id }}</td>
                                                <td>{{ $ticket->nome }}</td>
                                                <td>{{ $ticket->evento->nome }}</td>
                                                <td>{{ $ticket->cliente->nome }}</td>
                                                <td>{{ $ticket->quantidade }} Ticket(s)</td>
                                                <td>R$ {{ number_format($ticket->valor, 2, ',', '.') }}</td>
                                                <td>R$ {{ number_format($ticket->quantidade * $ticket->valor, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('tickets.show', $ticket) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="material-icons icon-button">visibility</i>
                                                    </a>
                                                    <a href="{{ route('tickets.edit', $ticket) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="material-icons icon-button">edit</i>
                                                    </a>
                                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Deseja excluir este ticket?')">
                                                            <i class="material-icons icon-button">delete</i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
