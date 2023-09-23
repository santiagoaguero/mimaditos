document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1,
        headerToolbar:{
            left: 'dayGridDay,timeGridWeek,dayGridMonth',
            center: 'title',
            right: 'prev,next today'
        },
        hiddenDays: [ 0 ],
        dateClick: function(info) {
            console.log(info);
            // Abre el modal utilizando las funciones de Bootstrap 5
            var modal = new bootstrap.Modal(document.getElementById('calendarModal'));

            // Actualiza el título del modal con la fecha seleccionada
            var modalTitle = modal._element.querySelector('.modal-title');
            modalTitle.innerText = 'Reserva para el: ' + info.date;
            modal.show();
        }
    });
    calendar.render();
});