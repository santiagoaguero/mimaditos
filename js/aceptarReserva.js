const formAceptarReserva = document.querySelectorAll(".aceptarReserva");

function btnAceptar(evt) {
    evt.preventDefault();

    let data = new FormData(this);

    let method = this.getAttribute("method");
    let action = this.getAttribute("action");

    let encabezado = new Headers();

    let config = {
        method: method,
        headers: encabezado,
        mode: "cors",
        cache: "no-cache",
        body: data
    }

    fetch(action, config)
        .then(response => {
            if (response.ok) {
                console.log("Solicitud exitosa");
            } else {
                console.error("Error en la solicitud");
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
        });
}

formAceptarReserva.forEach(form => {
    form.addEventListener("submit", btnAceptar);
});
