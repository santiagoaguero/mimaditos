<?php
    if (isset($_SESSION['signup']) && $_SESSION['signup']){//se creo el cliente
        if((!isset($_SESSION["crea_mascota"])) || isset($_SESSION['crea_mascota']) && $_SESSION['crea_mascota'] == false) {//no mascota
            echo '
                <div class="signup-error2-container">
                    <div class="signup-error2 card text-bg-warning mb-3 text-center shadow">
                        <div class="card-header">Oops ocurrió algo</div>
                        <div class="card-body">
                            <h5 class="card-title fs-1">Tu cuenta ha sido creada</h5>
                            <h6 class="card-subtitle mb-2 fs-3">Pero no pudimos registrar los datos de tu mimadito :(</h6>
                            <p class="card-text fs-5">Podes acceder a tu perfil y registrar sus datos</p>
                            <a href="index.php?vista=home" class="btn btn-outline-dark">Ir a mi perfil</a>
                            <a href="index.php?vista=home" class="btn btn-outline-dark">Registrar más tarde</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            ir a mi perfil en <span id="countdown">15</span> segundos 
                        </div>
                    </div>
                </div>
                <script>
                    let seconds = 15;
                    let countdownElement = document.getElementById("countdown");
                    
                    function updateCountdown() {
                        countdownElement.textContent = seconds;
                        seconds--;

                        if (seconds < 0) {
                            window.location.href = "index.php?vista=home";
                        } else {
                            setTimeout(updateCountdown, 1000); // Actualizar cada 1 segundo
                        }
                    }

                    updateCountdown();
                </script>

        ';
        //si por algun motivo se crea el cliente y mascota y llega acá se le lleva a home
        } else if(isset($_SESSION['crea_mascota']) && $_SESSION['crea_mascota']){
            header("Location: index.php?vista=home");
        }
    } else if (isset($_SESSION['signin']) && $_SESSION['signin']){//usuario inicio sesion
    
        header("Location: index.php?vista=home");
    }
    
    else {// no se creo el cliente
        header("Location: index.php?vista=signup_error");
    }
?>