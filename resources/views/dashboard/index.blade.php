@extends('app', ['activePage' => 'dashboard', 'titlePage' => 'Dashboard'])

@section('content')
    <div class="card card-body">

        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="">Informações Gerais</h2>
            </div>

            <div class="col-sm-3 col-md-3 col-lg-3 mb-4">
                <div class="card border-1 shadow" style="border-radius: 15px;">
                    <div class="card-body text-center" style="border-radius: 15px;">
                        <h4 class="text-dark">Eventos</h4>
                        <h3 class="text-dark">{{ $eventos }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-md-3 col-lg-3 mb-4">
                <div class="card border-1 shadow" style="border-radius: 15px;">
                    <div class="card-body text-center" style="border-radius: 15px;">
                        <h4 class="text-dark">Tickets</h4>
                        <h3 class="text-dark">{{ $tickets }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-md-3 col-lg-3 mb-4">
                <div class="card border-1 shadow" style="border-radius: 15px;">
                    <div class="card-body text-center" style="border-radius: 15px;">
                        <h4 class="text-dark">Clientes</h4>
                        <h3 class="text-dark">{{ $clientes }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-md-3 col-lg-3 mb-4">
                <div class="card border-1 shadow" style="border-radius: 15px;">
                    <div class="card-body text-center" style="border-radius: 15px;">
                    <h4 class="text-dark">Inscritos</h4>
                    <h3 class="text-dark">{{ $inscritos }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mt-4">
                <h3>Tickets Pagos no Mês</h3>
                <canvas id="ticketsValoresChart" width="400" height="200"></canvas>
            </div>

            <div class="col-md-6 mt-4">
                <h3>Tickets Pagos no Ano</h3>
                <canvas id="ticketsValoresAnualChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-4">
                <h3>Tickets Pagos e Valores Totais por Evento</h3>
                <canvas id="ticketsValoresPorEventoChart" width="400" height="200"></canvas>
            </div>
        </div>

        @if (count($eventos_hoje) > 0)
            <hr>
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2 class="text-center text-primary">
                        🎉 Você tem evento(s) acontecendo hoje! 🎉
                    </h2>
                    <p class="lead">Não perca a chance de aproveitar esses momentos especiais!</p>
                </div>

                @foreach ($eventos_hoje as $evento_hoje)
                    <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
                        <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                            <div class="card-body" style="background-color: #ecf0f1; border-radius: 15px 15px 0 0;">
                                <h4 class="text-center">
                                    🎈 {{ $evento_hoje->nome }} 🎈
                                </h4>
                                <p><strong>📅 Início/Fim:</strong> {{ $evento_hoje->data_inicio->format('d/m/Y') }} -
                                    {{ $evento_hoje->data_fim->format('d/m/Y') }}</p>
                                <p><strong>📍 Local:</strong> {{ $evento_hoje->local }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between"
                                style="background-color: #dcdde1; border-radius: 0 0 15px 15px;">
                                <a href="{{ route('eventos.show', $evento_hoje) }}" class="btn btn-sm btn-primary">
                                    Ver Evento
                                </a>
                                @if ($evento_hoje->temInscritos())
                                    <a href="{{ route('eventos.inscritos', $evento_hoje) }}" class="btn btn-sm btn-success">
                                        Ver Inscritos
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <hr>
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-primary" style="font-weight: bold;">Próximos Eventos</h2>
                <p class="lead">Fique atento aos eventos que estão por vir!</p>
            </div>

            @foreach ($proximos_eventos as $proximo_evento)
                <div class="col-sm-6 col-md-6 col-lg-6 mt-3">
                    <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                        <div class="card-body" style="background-color: #ecf0f1; border-radius: 15px 15px 0 0;">
                            <h4 class="text-center" style="color: #070b3b; font-weight: bold;">
                                📅 {{ $proximo_evento->nome }}
                            </h4>
                            <p><strong>🕒 Início/Fim:</strong> {{ $proximo_evento->data_inicio->format('d/m/Y') }} -
                                {{ $proximo_evento->data_fim->format('d/m/Y') }}</p>
                            <p><strong>📍 Local:</strong> {{ $proximo_evento->local }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between"
                            style="background-color: #dcdde1; border-radius: 0 0 15px 15px;">
                            <a href="{{ route('eventos.show', $proximo_evento) }}" class="btn btn-sm btn-primary">
                                Ver Evento
                            </a>
                            @if ($proximo_evento->temInscritos())
                                <a href="{{ route('eventos.inscritos', $proximo_evento) }}" class="btn btn-sm btn-success">
                                    Ver Inscritos
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ticketsValoresChart').getContext('2d');

            const ticketsValoresChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!}, // Dias do mês no eixo X
                    datasets: [
                        {
                            label: 'Valor Total Pago (R$)',
                            data: {!! json_encode($valoresTotais) !!}, // Valores totais pagos
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Quantidade de Tickets Pagos',
                            data: {!! json_encode($quantidadesTickets) !!}, // Quantidade de tickets pagos
                            backgroundColor: 'rgba(255, 0, 0, 0.6)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Dias do Mês'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Valor Total (R$)'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Quantidade de Tickets'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });

            const ctxAnual = document.getElementById('ticketsValoresAnualChart').getContext('2d');

            const ticketsValoresChartAnual = new Chart(ctxAnual, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelsAnual) !!}, // Dias do mês no eixo X
                    datasets: [
                        {
                            label: 'Valor Total Pago (R$)',
                            data: {!! json_encode($valoresTotaisAnual) !!}, // Valores totais pagos
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Quantidade de Tickets Pagos',
                            data: {!! json_encode($quantidadesTicketsAnual) !!}, // Quantidade de tickets pagos
                            backgroundColor: 'rgba(255, 0, 0, 0.6)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Ano'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Valor Total (R$)'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Quantidade de Tickets'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });

            const ctxEvento = document.getElementById('ticketsValoresPorEventoChart').getContext('2d');

            const ticketsValoresPorEventoChart = new Chart(ctxEvento, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelsEvento) !!}, // Nome dos eventos no eixo X
                    datasets: [
                        {
                            label: 'Valor Total Pago (R$)',
                            data: {!! json_encode($valoresTotaisEvento) !!}, // Valores totais pagos
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Quantidade de Tickets Pagos',
                            data: {!! json_encode($quantidadesTicketsEvento) !!}, // Quantidade de tickets pagos
                            backgroundColor: 'rgba(255, 0, 0, 0.6)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Eventos'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Valor Total (R$)'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Quantidade de Tickets'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });
        });

    </script>

@endsection
