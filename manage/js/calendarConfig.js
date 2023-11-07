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
        displayEventTime:false,
        events: './php/getReservas.php',
        selectOverlap: function(event) {
            return event.rendering === 'background';
        },
        eventClassNames: function(arg) {
            if (arg.event.extendedProps.estado != 0) {
                return ['evento-tachado']; // Aplica una clase para eventos con estado 0
            }
            return ''; // No se aplica ninguna clase para otros eventos
        },
        eventClick: function(info){
            if(info.event.extendedProps.estado != 0){
                if(roleus >= 1 && roleus <= 3){
                    let modal = new bootstrap.Modal(document.getElementById('calendarModal'));

                    //elimina el mensaje del rest anterior
                    let formrest = document.querySelector('.form-rest');
                    formrest.innerHTML = "";

                    let fecha = new Date(info.event.startStr);

                    // Obtener el día, mes y año
                    let dia = fecha.getDate();
                    let mes = fecha.getMonth() + 1; // Nota: los meses en JavaScript se cuentan desde 0 (enero) a 11 (diciembre)
                    let año = fecha.getFullYear();
                    let hora = fecha.getHours();
                    let minutos = fecha.getMinutes();
                    
                    // Formatear la fecha en DD-MM-YYYY HH:MM
                    let fechaFormateada = dia + '-' + mes + '-' + año + ' a las ' + hora + ':' + (minutos < 10 ? '0' : '') + minutos;

                    estado = info.event.extendedProps.estado == 2 ? 'Confirmado' : 'Pendiente'

                    // Actualiza el título del modal con la fecha seleccionada
                    let modalTitle = document.getElementById('reservaTitulo');
                    modalTitle.innerText = estado + ': ' + fechaFormateada;

                    let modalMascota = document.getElementById('mimadito');
                    modalMascota.innerText = "Mimadito: " + info.event.extendedProps.mascota_nombre;

                    let cliente = document.getElementById('dueno');
                    cliente.innerText = "Dueño: " + info.event.extendedProps.cliente_nombre;

                    let notas = document.getElementById('notas');
                    if(info.event.extendedProps.notas != ""){
                        notas.value = info.event.extendedProps.notas;
                    } else {
                        notas.value = "";
                    }
                    

                    //transporte
                    let transporte = document.getElementById('transporte');
                    if(info.event.extendedProps.transporte == 1){
                        text =  'Solicita Transporte';
                        transporte.classList.add("p-2", "bg-info", "bg-opacity-10", "border", "border-info", "rounded");
                        transporte.innerText = text;
                    } else {
                        transporte.classList.remove("p-2", "bg-info", "bg-opacity-10", "border", "border-info", "rounded");
                        transporte.innerText = "";
                    }

                    //forms y botones confirmacion/cancelar reseva modal
                    let formConfirmar = document.querySelector('.confirmarReserva');
                    let formCancelar = document.querySelector('.cancelarReserva');
                    if(info.event.extendedProps.estado == 1){
                        formCancelar.style.display = "none";
                        let iptConfirmar = document.getElementById('iptConfirmar');
                        iptConfirmar.value = info.event.extendedProps.turno;
                        formConfirmar.style.display = "block";
                    } else {
                        formConfirmar.style.display = "none";
                        let iptCancelar = document.getElementById('iptCancelar');
                        iptCancelar.value = info.event.extendedProps.turno;
                        formCancelar.style.display = "block";
                    }


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
                                    reserva: info.event.extendedProps.reserva,
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
        }
    });
    
    calendar.render();
});