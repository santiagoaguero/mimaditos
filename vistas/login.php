<div class="container">
    <form class="login shadow text-secondary" action="" method="POST" autocomplete="off">
        <div class="logo-login">
            <img src="./img/logo.png" alt="Mimaditos">
        </div>
        <div class="ingresa">Ingresa para ver nuestros servicios! 🤗 </div>
        <div class="input-group">
            <div class="input-group-text">
                <img src="./img/user-icon.png" alt="user-icon" class="user-icon">
            </div>
            <div class="col-12 form-floating">
                <input type="email" class="form-control" id="inputEmail4"  placeholder="name@example.com" name="login_email" required>
                <label for="inputEmail4">Email</label>
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-text">
                <img src="./img/pass-icon.png" alt="user-icon" class="pass-icon">
            </div>
            <div class="col-12 form-floating">
                <input type="password" class="form-control" name="login_clave" id="inputPassword4" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{6,100}" required>
                <label for="inputPassword4">Contraseña</label>
            </div>
        </div>
        <button class="btn btn-info mt-2" type="submit">Iniciar Sesión</button>
        <div class="forgot-container">
            <div class="forgot" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <div class="remember">
                    <input type="checkbox" name="login_recuerda" id="" class="form-check-input">
                    <div style="font-size: 0.9rem;" class="pt-2">Recuérdame!</div>
                </div>
                <div class="recover-pass">
                    <a href="#">Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
        <div class="create-account">
            <div>No tienes una cuenta?</div>
            <a href="index.php?vista=signup">Creemos una!</a>
        </div>
        <div class="p-2">
            <div class="border-bottom text-center text-secondary" style="height: 0.7rem;">
                <span class="bg-white px-3">O</span>
            </div>
        </div>
        <div class="btn btnGoogle">
            <img src="./img/google-icon.png" alt="google-icon" class="pass-icon">
            <?php
            require_once './php/g-config.php';

            //if (isset($_SESSION['id'])) {
            //    header("Location: index.php?vista=home");
            //} else {
                echo "
                
                    <a class='' href='" . $client->createAuthUrl() . "' onclick='showLoader()'>inicia sesión con tu cuenta Google</a>
                ";
            // }
           ?>
        </div>
        <?php 
            if(isset($_POST["login_email"]) && isset($_POST["login_clave"])){
                require_once("./php/main.php");
                require_once("./php/iniciar_sesion.php");
            }
        ?>
    </form>
    <div class="spinner-grow text-primary" role="status" id="loader">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<script>
    function showLoader(){
        document.getElementById('loader').style.display = 'block';
    }
</script>