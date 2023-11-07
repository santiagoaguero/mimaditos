const formConfirmarReserva = document.querySelectorAll(".confirmarReserva");

function btnConfirmar (evt){
    evt.preventDefault();

    let confirmar=confirm("Realmente quieres confirmar?")

    if(confirmar){
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
            let contenedor = this.querySelector(".form-rest");
            contenedor.innerHTML = response;
        } );
    }

}

formConfirmarReserva.forEach(form =>{
    form.addEventListener("submit", btnConfirmar)
});