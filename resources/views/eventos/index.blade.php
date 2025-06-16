@extends('app', ['activePage' => 'eventos', 'titlePage' => 'Eventos'])

@section('title', 'Eventos')

@section('content')
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('eventos.create') }}" class="btn btn-sm btn-success">
                                    Criar Evento
                                </a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Datas</th>
                                <th>Local</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($eventos) <= 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Não há eventos cadastrados
                                    </td>
                                </tr>
                            @else
                                @foreach ($eventos as $evento)
                                    <tr>
                                        <td> {{ $evento->id }} </td>
                                        <td class="wrap-column" width="30%"> {{ $evento->nome }} </td>
                                        <td>
                                            <p>
                                                <strong>Início:</strong> {{ $evento->data_inicio->format('d/m/Y') }}
                                                <br>
                                                <strong>Fim: </strong> {{ $evento->data_fim->format('d/m/Y') }}
                                                <br>
                                                <strong>Horário: </strong> {{ $evento->horario }}
                                            </p>
                                        </td>
                                        <td class="wrap-column" width="20%"> {{ $evento->local }} </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a href="{{ route('eventos.show', $evento) }}" class="dropdown-item">
                                                            <i class="material-icons icon-button">visibility</i> Visualizar
                                                        </a>
                                                    </li>

                                                    <!-- Exibe o botão "Ver Inscritos" se houver inscritos -->
                                                    @if ($evento->temInscritos())
                                                        <li>
                                                            <a href="{{ route('eventos.inscritos', $evento) }}"
                                                                class="dropdown-item">
                                                                <i class="material-icons icon-button">group</i> Ver
                                                                Inscritos
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <!-- Exibe o botão "Excluir" se não houver inscritos -->
                                                    @if (!$evento->temInscritos())
                                                        <li>
                                                            <form action="{{ route('eventos.destroy', $evento) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Deseja realmente excluir este evento?');">
                                                                    <i class="material-icons icon-button">delete</i> Excluir
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $eventos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .wrap-column {
            white-space: wrap !important;
        }
    </style>

@endsection
