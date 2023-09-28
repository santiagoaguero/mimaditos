const formAjax = document.querySelectorAll(".formularioAjax");

function enviarForm (evt){
    evt.preventDefault();

    let enviar=confirm("quieres enviar este formulario?")

    if(enviar){
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

formAjax.forEach(form =>{
    form.addEventListener("submit", enviarForm)
});

