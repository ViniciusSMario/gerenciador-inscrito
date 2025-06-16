@extends('app', ['activePage' => 'calendario', 'titlePage' => 'Calendário'])

@section('content')
    <div class="card card-body">
        <h4 class="text-center">Calendário de Eventos</h4>
        <!-- Div onde o calendário será renderizado -->
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById(
            'calendar'); // Pega o elemento onde o calendário será renderizado

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Visualização inicial como grade mensal
                locale: 'pt-br', // Configura o calendário para Português
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                events: '/calendario/eventos', // URL da API que fornece os eventos
                weekText: 'Sm', // Abreviação para semana
                allDayText: 'Dia Inteiro',
                noEventsText: 'Nenhum evento para mostrar',
            });

            calendar.render(); // Renderiza o calendário
        });
    </script>
@endsection
