const reservaAjax = document.querySelectorAll(".reserva");

function enviarForm (evt){
    evt.preventDefault();

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
        if (response.includes("Reserva Solicitada")) {
            window.location.href="index.php?vista=calendar";
        } else {
            let contenedor = this.querySelector(".form-rest");
            contenedor.innerHTML = response;
        }

    } );


}

reservaAjax.forEach(form =>{
    form.addEventListener("submit", enviarForm)
});