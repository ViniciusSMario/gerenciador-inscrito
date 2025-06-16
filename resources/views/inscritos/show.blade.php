@extends('app', ['activePage' => 'inscritos', 'titlePage' => 'Informações do Inscrito'])

@section('title', $inscrito->nome)

@section('content')
    <div class="">
        <div class="row">
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
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="card-title text-white fw-bold mb-0">{{ $inscrito->nome }}</h3>
                    </div>

                    <div class="card-body p-4">
                        <div class="row">

                            <div class="col-md-6">


                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-info me-3" style="font-size: 36px;">mail</i>
                                    <div>
                                        <strong class="d-block">E-mail:</strong>
                                        <p class="text-muted mb-0 text-wrap">{{ $inscrito->email }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-warning me-3" style="font-size: 36px;">person_pin</i>
                                    <div>
                                        <strong class="d-block">CPF:</strong>
                                        <p class="text-muted mb-0 text-wrap">{{ $inscrito->cpf }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-success me-3" style="font-size: 36px;">phone</i>
                                    <div>
                                        <strong class="d-block">WhatsApp:</strong>
                                        <p class="text-muted mb-0 text-wrap">{{ $inscrito->telefone }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-danger me-3" style="font-size: 36px;">face</i>
                                    <div>
                                        <strong class="d-block">Estado Cívil:</strong>
                                        <p class="text-muted mb-0 text-wrap">{{ ucfirst($inscrito->estado_civil) }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-dark me-3" style="font-size: 36px;">event</i>
                                    <div>
                                        <strong class="d-block">Data de nascimento:</strong>
                                        <p class="text-muted mb-0 text-wrap">
                                            {{ ucfirst($inscrito->data_nascimento->format('d/m/Y')) }}</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                @if ($inscrito->ticket)
                                    <div class="info-card mb-3 d-flex align-items-start">
                                        <i class="material-icons text-primary me-3"
                                            style="font-size: 36px;">confirmation_number</i>
                                        <div>
                                            <strong class="d-block">Ticket:</strong>
                                            <p class="text-muted mb-0 text-wrap">{{ ucfirst($inscrito->ticket->nome) }}</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-success me-3" style="font-size: 36px;">check</i>
                                    <div>
                                        <strong class="d-block">Aceitou os termos:</strong>
                                        <p class="text-muted mb-0 text-wrap">
                                            {{ $inscrito->autorizacao == 1 ? 'Sim' : 'Não' }}
                                        </p>
                                    </div>
                                </div>


                                <!-- Observação -->
                                <div class="info-card mb-3 d-flex align-items-start">
                                    <i class="material-icons text-warning me-3" style="font-size: 36px;">note_add</i>
                                    <div>
                                        <strong class="d-block">Observação:</strong>
                                        <p class="text-muted mb-0 text-wrap">
                                            {{ $inscrito->observacao ? $inscrito->observacao : 'Não informado' }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                    <!-- Ações -->
                    <div class="card-footer gap-2 d-flex align-items-center justify-content-end">
                        <a href="{{ route('inscritos.edit', $inscrito) }}"
                            class="btn btn-warning d-flex align-items-center">
                            <i class="material-icons icon-button me-1">edit</i>Editar
                        </a>

                        <form action="{{ route('inscritos.destroy', $inscrito) }}" method="POST"
                            onsubmit="return confirm('Deseja realmente excluir este evento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mt-3 d-flex align-items-center">
                                <i class="material-icons icon-button me-1">delete</i>Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
