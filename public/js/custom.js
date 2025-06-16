document.addEventListener('DOMContentLoaded', function() {
    // Atualiza labels flutuantes nos inputs
    M.updateTextFields();

    // Inicializa o Datepicker com tradução e formatação
    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        format: 'dd/mm/yyyy',
        i18n: {
            months: [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ],
            monthsShort: [
                'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
            ],
            weekdays: [
                'Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira',
                'Quinta-feira', 'Sexta-feira', 'Sábado'
            ],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
            weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
            cancel: 'Cancelar',
            clear: 'Limpar',
            done: 'Confirmar'
        }
    });
});

// Intercepta o envio do formulário para converter a data
// document.getElementById('evento-form').addEventListener('submit', function(e) {
//     const dataInicio = document.getElementById('data_inicio').value; // Data no formato dd/mm/yyyy
//     const [diaInicio, mesInicio, anoInicio] = dataInicio.split('/'); // Divide a data

//     const dataFim = document.getElementById('data_fim').value; // Data no formato dd/mm/yyyy
//     const [diaFim, mesFim, anoFim] = dataFim.split('/'); // Divide a data

//     // Converte para yyyy-mm-dd
//     const dataInicioFormatada = `${anoInicio}-${mesInicio}-${diaInicio}`;
//     const dataFimFormatada = `${anoFim}-${mesFim}-${diaFim}`;

//     // Define o valor no campo hidden
//     document.getElementById('data_inicio').value = dataInicioFormatada;
//     document.getElementById('data_fim').value = dataFimFormatada;
// });