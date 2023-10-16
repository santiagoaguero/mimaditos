document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'America/Asuncion',
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
          
            startTime: '08:00', // a start time (09am in this project)
            endTime: '16:00', // an end time (3pm in this project)
        },
        nowIndicator: true,
        events: './php/getReservas.php',
        selectOverlap: function(event) {
            return event.rendering === 'background';
          },
        dateClick: function(info) {
            //checks roles of user prev setted on calendar
            if(roleus == 4){
            // Abre el modal utilizando las funciones de Bootstrap 5
                let modal = new bootstrap.Modal(document.getElementById('calendarModal'));

                // Actualiza el título del modal con la fecha seleccionada
                let modalTitle = document.getElementById('reservaTitulo');
                modalTitle.innerText = 'Reserva para el: ' + info.dateStr;
                let fechaInput = document.getElementById('reservaFecha');
                fechaInput.value = info.dateStr;

                let fechaSeleccionada = info.dateStr;

                // Envía la fecha al servidor PHP utilizando una solicitud AJAX (por ejemplo, con Fetch API)
                fetch('./php/check_horario_disponible.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ fechaSeleccionada: fechaSeleccionada }),
                })
                .then(response => response.json())
                .then(data => {

                    let select = document.getElementById('horario_disponible');
                    select.innerHTML = ''; // Limpia las opciones existentes
                        // Agrega la opción "Seleccione un horario"
                    let defaultOption = document.createElement('option');
                    defaultOption.value = ''; // Puedes dejar el valor vacío o establecerlo como sea necesario
                    defaultOption.text = 'Seleccione un horario';
                    select.appendChild(defaultOption);
            
                    if (data.length > 0) {
                        data.forEach(horario => {
                            let option = document.createElement('option');
                            option.value = horario.horario_id;
                            option.text = `${horario.horario_inicio} - ${horario.horario_fin}`;
                            select.appendChild(option);
                        });
                    } else {
                        let option = document.createElement('option');
                        option.value = '0';
                        option.text = 'No hay horarios disponibles para esta fecha';
                        select.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                modal.show();
            }
        },
        eventClick: function(info){
            if(roleus >= 1 && roleus <= 3){

                // Abre el modal utilizando las funciones de Bootstrap 5
                let modal = new bootstrap.Modal(document.getElementById('calendarModalAd'));

                // Actualiza el título del modal con la fecha seleccionada
                let modalTitle = document.getElementById('reservaTitulo');
                let modalDesc = document.getElementById('reservaDescripcion');
                modalTitle.innerText = 'Servicio: ' + info.event.title;
                modalDesc.innerText = 'Estado: ' + info.event.extendedProps.estado;//new prop goes here
                modal.show();
            }
        }
    });
    
    calendar.render();
});