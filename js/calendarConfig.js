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
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            daysOfWeek: [ 1, 2, 3, 4, 5], // Monday - Friday
          
            startTime: '09:00', // a start time (09am in this project)
            endTime: '16:00', // an end time (3pm in this project)
        },
        nowIndicator: true,
        events:[
            {
                title: 'Baño',
                start: '2023-09-06',
                estado: 'Pendiente'
            },
            {
                title: 'Peluqueria',
                start: '2023-09-07',
                end: '2023-09-09',
                estado: 'Pendiente'
            },
            {
                title: 'Consulta',
                start: '2023-09-07T12:30:00',
                allDay: false,
                estado: 'Pendiente'
            }
        ],
        dateClick: function(info) {
            // Abre el modal utilizando las funciones de Bootstrap 5
            let modal = new bootstrap.Modal(document.getElementById('calendarModal'));

            // Actualiza el título del modal con la fecha seleccionada
            let modalTitle = document.getElementById('turnoTitulo');
            modalTitle.innerText = 'Reserva para el: ' + info.dateStr;
            modal.show();
        },
        eventClick: function(info){
            // Abre el modal utilizando las funciones de Bootstrap 5
            let modal = new bootstrap.Modal(document.getElementById('calendarModal'));

            // Actualiza el título del modal con la fecha seleccionada
            let modalTitle = document.getElementById('turnoTitulo');
            let modalDesc = document.getElementById('turnoDescripcion');
            modalTitle.innerText = 'Servicio: ' + info.event.title;
            modalDesc.innerText = 'Estado: ' + info.event.extendedProps.estado;//new prop goes here
            modal.show();
        }
    });
    calendar.render();
});