@extends('app', ['activePage' => 'clientes', 'titlePage' => 'Detalhes do Cliente'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0 text-white">Detalhes do Cliente</h4>
                </div>

                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Nome:</strong>
                            <span>{{ $cliente->nome }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Email:</strong>
                            <span>{{ $cliente->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Telefone:</strong>
                            <span>{{ $cliente->telefone }}</span>
                        </li>

                        <li class="list-group-item">
                            <strong>Tickets:</strong>
                            @if ($cliente->tickets->count() > 0)
                                <ul class="list-inline mb-0">
                                    @foreach ($cliente->tickets as $ticket)
                                        <li class="list-inline-item badge bg-primary text-white me-1 mb-1">
                                            {{ $ticket->nome }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">Nenhum ticket vinculado.</span>
                            @endif
                        </li>

                    </ul>
                </div>

                <div class="card-footer d-flex justify-content-end gap-2 p-3">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary d-flex align-items-center">
                        <i class="material-icons me-2">arrow_back</i>Voltar
                    </a>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning d-flex align-items-center">
                        <i class="material-icons me-2">edit</i>Editar
                    </a>
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-flex align-items-center">
                            <i class="material-icons me-2">delete</i>Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
