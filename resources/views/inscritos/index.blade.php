@extends('app', ['activePage' => 'inscritos', 'titlePage' => 'Inscritos'])

@section('content')
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
                        <a href="{{ route('inscritos.create') }}" class="btn btn-sm btn-success">
                            Cadastrar Inscrito
                        </a>
                    </div>
                    <div class="">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Evento(Ticket) Associado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($inscritos) <= 0)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Não há inscritos cadastrados
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($inscritos as $inscrito)
                                        <tr>
                                            <td>{{ $inscrito->id }}</td>
                                            <td>
                                                {{ $inscrito->nome }} <br>
                                                <small>{{ $inscrito->email }}</small>
                                            </td>
                                            <td>
                                                @if ($inscrito->ticket)
                                                    {{ $inscrito->ticket->evento->nome }}
                                                    <br>
                                                    <small>
                                                        ({{ $inscrito->ticket->nome }})
                                                    </small>
                                                @else
                                                    Não associado
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <a href="{{ route('inscritos.show', $inscrito) }}" class="dropdown-item">
                                                                <i class="material-icons icon-button">visibility</i> Visualizar
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('inscritos.destroy', $inscrito) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Deseja excluir este inscrito?')">
                                                                    <i class="material-icons icon-button">delete</i> Excluir
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $inscritos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
