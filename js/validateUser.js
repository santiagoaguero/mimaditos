// Obtener el parámetro 'vista' de la URL
var urlParams = new URLSearchParams(window.location.search);
var vista = urlParams.get('vista');

// Verificar la vista actual y activar/desactivar los eventos según corresponda
//esto para evitar que se activen los eventslistener y de errores en lugares no solicitados
if (vista === 'signup' || vista === 'perfil' || vista === 'cliente_update' || vista === 'cliente_new' || vista === 'user_update' || vista === 'user_new') {

    document.getElementById("inputUser").addEventListener("keyup", checkUser);
}

function checkUser(){
    let inputCp = document.getElementById("inputUser").value;
    let message = document.getElementById('username-validation-message')
   

    if(inputCp.length == 0){
        message.innerText = "";
    }  else if(inputCp.length < 4){
        message.classList.remove("text-danger"); 
        message.classList.add("text-warning-emphasis"); 
        message.innerHTML = '<i class="fa-solid fa-triangle-exclamation fa-fade fa-xs"></i><span style="font-size: 16px;"> Nombre de Usuario debe contener mínimo 4 caracteres</span>';
    }
    else {
        let url = "./php/validateUserSignUp.php";
        let formData = new FormData();
        formData.append("inputUser", inputCp);

        fetch(url, {
            method: "POST",
            body: formData,
            mode: "cors"
        })
        .then(response => response.text())
        .then(data => {
            if(data){
                message.classList.remove("text-warning-emphasis"); 
                message.classList.add("text-danger"); 
                message.innerHTML = '<i class="fa-solid fa-xmark fa-beat fa-xs"></i><span style="font-size: 16px;"> Nombre de Usuario en uso, por favor elija otro</span>';
            } else{
                message.classList.remove("text-warning-emphasis"); 
                message.classList.remove("text-danger"); 
                message.classList.add("text-success");
                message.innerHTML = '<i class="fa-solid fa-check-circle fa-bounce fa-xs"></i><span style="font-size: 16px;"> Disponible</span>';
            }
        })
        .catch(err=> console.log("catch->",err));
    }
}