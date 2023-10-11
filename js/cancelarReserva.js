const formCancelarReserva = document.querySelectorAll(".cancelarReserva");

function btnCancelar (evt){
    evt.preventDefault();

    let cancelar=confirm("Esta reserva pasará a estar Pendiente")

    if(cancelar){
        let data = new FormData(this);

        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezado= new Headers();

        let config = {
            method: method,
            headers: encabezado,
            mode: "cors",
            cache: "no-cache",
            body: data
        }

        fetch(action, config)
        .then(response => response.text())
        .then(response => {
            let contenedor = document.querySelector(".form-rest");
            contenedor.innerHTML = response;
        } );
    }

}

formCancelarReserva.forEach(form =>{
    form.addEventListener("submit", btnCancelar)
});