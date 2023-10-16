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

                // Envía la fecha al servidor PHP utilizando una solicitud AJAX con Fetch API
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
                let modal = new bootstrap.Modal(document.getElementById('calendarModal'));
   
                let fecha = new Date(info.event.startStr);

                // Obtener el día, mes y año
                let dia = fecha.getDate();
                let mes = fecha.getMonth() + 1; // Nota: los meses en JavaScript se cuentan desde 0 (enero) a 11 (diciembre)
                let año = fecha.getFullYear();
                let hora = fecha.getHours();
                let minutos = fecha.getMinutes();
                
                // Formatear la fecha en DD-MM-YYYY HH:MM
                let fechaFormateada = dia + '-' + mes + '-' + año + ' a las ' + hora + ':' + (minutos < 10 ? '0' : '') + minutos;

                estado = info.event.extendedProps.estado == 1 ? 'Confirmado' : 'Pendiente'

                // Actualiza el título del modal con la fecha seleccionada
                let modalTitle = document.getElementById('reservaTitulo');
                modalTitle.innerText = estado + ': ' + fechaFormateada;

                let modalMascota = document.getElementById('mimadito');
                modalMascota.innerText = "Mimadito: " + info.event.title;
                
                console.log(info.event.extendedProps);
                let cliente = document.getElementById('dueno');
                cliente.innerText = "Dueño: " + info.event.extendedProps.cliente_nombre;

                

                //transporte
                if(info.event.extendedProps.transporte == 1){
                    transporte =  'Solicita Transporte';
                    // Actualiza el título del modal con la fecha seleccionada
                    let transporteText = document.getElementById('transporte');
                    transporteText.classList.add("p-2", "bg-info", "bg-opacity-10", "border", "border-info", "rounded");
                    transporteText.innerText = transporte ;
                }

                let iptConfirmar = document.getElementById('iptConfirmar');
                iptConfirmar.value = info.event.id;
                let iptCancelar = document.getElementById('iptCancelar');
                iptCancelar.value = info.event.id;


                //se hace async para que no muestre el cambio de lista mientras se abre el modal
                //lo muestra una vez obtenga y liste todos los datos
                async function fetchData() {
                    try {
                        const response = await fetch('./php/getServiciosReserva.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                reserva: info.event.id,
                                cliente: info.event.extendedProps.cliente,
                                mascota: info.event.extendedProps.mascota
                            }),
                        });
                
                        if (response.ok) {
                            const data = await response.json();
                            let ol = document.getElementById('servicios');
                            ol.innerHTML = ''; // Limpia las opciones existentes
                            if (data.length > 0) {
                                data.forEach(servicio => {
                                    let li = document.createElement('li');
                                    li.classList.add("list-group-item");
                                    li.textContent = servicio.servicio; // Usar servicio.servicio para obtener el nombre
                                    ol.appendChild(li);
                                });
                            } else {
                                let li = document.createElement('li');
                                li.textContent = 'No hay servicios solicitados para esta reserva';
                                ol.appendChild(li);
                            }
                
                            // Mostrar el modal después de cargar los datos
                            modal.show();
                        } else {
                            console.error('Error en la respuesta del servidor:', response.status);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
                
                // Llamar a la función fetchData para cargar los datos y mostrar el modal
                fetchData();

            }
        }
    });
    
    calendar.render();
});