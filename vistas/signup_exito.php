<?php
    if (isset($_SESSION['signup']) && $_SESSION['signup']){//se creo el cliente
        if(isset($_SESSION['crea_mascota']) && $_SESSION['crea_mascota']) {//se creo la mascota
            echo '
            <div class="signup-exito-container">
                <div class="card w-100 signup-exito border-0 text-center text-info-emphasis">
                    <div class="card-body">
                        <h5 class="card-title fs-1">Hola <?php echo $_SESSION["nombre"]?>!</h5>
                        <h6 class="card-subtitle mb-2 fs-3">Gracias por elegirnos para cuidar a tu mimadito 💖</h6>
                        <p class="card-text fs-6">Recordá que una vez accedas podrás completar más información sobre vos o tu mimadito 🐾</p>
                        <a href="index.php?vista=calendar" class="btn btn-outline-primary">Solicita un servicio ahora!</a>
                    </div>
                    <div class="card-footer text-body-secondary">
                        o serás redireccionado en <span id="countdown">15</span> segundos 
                    </div>
                </div>
            </div>
        ';
        } else {
            header("Location: index.php?vista=signup_error2");
        }
    } else if (isset($_SESSION['signin']) && $_SESSION['signin']){//usuario inicio sesion
    
        header("Location: index.php?vista=home");
    }
    
    else {// no se creo el cliente
        header("Location: index.php?vista=signup_error");
    }
?>

<script>
    let seconds = 15;
    let countdownElement = document.getElementById("countdown");
    
    function updateCountdown() {
        countdownElement.textContent = seconds;
        seconds--;

        if (seconds < 0) {
            window.location.href = "index.php?vista=calendar";
        } else {
            setTimeout(updateCountdown, 1000); // Actualizar cada 1 segundo
        }
    }

    updateCountdown();
</script>