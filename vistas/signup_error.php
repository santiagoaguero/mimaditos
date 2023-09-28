<?php
    if (isset($_SESSION['signup']) && $_SESSION['signup'] == false){//se creo el cliente
        echo '
            <div class="signup-error-container">
                <div class="signup-error card text-bg-danger text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title fs-1">No pudimos crear tu cuenta :(</h5>
                        <h6 class="card-subtitle mb-2 fs-3">Por favor, inténtalo de vuelta</h6>
                        <a href="index.php?vista=signup" class="btn btn-outline-dark">Crea una cuenta</a>
                    </div>
                    <div class="card-footer text-body-secondary">
                        o serás redireccionado en <span id="countdown">15</span> segundos 
                    </div>
                </div>
            </div>
        ';
    } else if (isset($_SESSION['signin']) && $_SESSION['signin']){//usuario inicio sesion
        
        header("Location: index.php?vista=home");

    } else {
        header("Location: index.php?vista=login");//cualquier fuga, login
    }


?>
<script>
    let seconds = 15;
    let countdownElement = document.getElementById("countdown");
    
    function updateCountdown() {
        countdownElement.textContent = seconds;
        seconds--;

        if (seconds < 0) {
            window.location.href = "index.php?vista=signup";
        } else {
            setTimeout(updateCountdown, 1000); // Actualizar cada 1 segundo
        }
    }

    updateCountdown();
</script>