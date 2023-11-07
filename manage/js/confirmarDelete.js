const formConfirmarDelete = document.querySelectorAll(".confirmarDelete");

function btnDelete (evt){
    evt.preventDefault();

    let eliminar=confirm("Realmente quieres eliminar?")

    if(eliminar){
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

formConfirmarDelete.forEach(form =>{
    form.addEventListener("submit", btnDelete)
});