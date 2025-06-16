@extends('app', ['activePage' => 'notificacoes', 'titlePage' => 'Notificações'])

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">


            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Novas notificações</h2>
                @if (!$notifications->isEmpty())
                    <form action="{{ route('notificacoes.markAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Marcar todos como lido</button>
                    </form>
                @endif
            </div>

            @if ($notifications->isEmpty())
                <p>Você não tem notificações.</p>
            @else
                <ul class="list-unstyled">
                    @foreach ($notifications as $notification)
                        <li>
                            <div class="alert alert-info text-white lert-dismissible fade show">
                                <p>{{ $notification->data['mensagem'] }}</p>
                                <small>Recebida em {{ $notification->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>
@endsection
