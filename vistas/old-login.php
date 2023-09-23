<div class="container">
    <form class="login row g-3 shadow" action="" method="POST" autocomplete="off">
        <div class="text-center">
            <img src="./img/logo.png" alt="reservet"  class="img-logo">
        </div>
        <h3 class="text-center">Bienvenido!</h3>
        <p class="text-center">inicie sesión para acceder a nuestros servicios</p>
        <div class="col-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4"  placeholder="name@example.com" name="login_email" required>
            <label for="inputEmail4">Email</label>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" name="login_clave" id="inputPassword4" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{7,100}" required>
            <label for="inputPassword4">Contraseña</label>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-2">Iniciar Sesión</button>
        </div>
        <div class="text-center">
           -- O --
        </div>

        <?php
            require_once './php/g-config.php';
            echo isset($_SESSION['user_token']) ?
                header("Location: home.php") : 
                "<a class='g-signin2' href='" . $client->createAuthUrl() . "'>Google Login</a>";
        ?>
        <!-- <div class="g-signin2 is-centered" data-onsuccess="onSignIn"></div> -->
        <a href="index.php?vista=signup" class="text-center">Cree una cuenta para acceder</a>

        <?php 
            if(isset($_POST["login_email"]) && isset($_POST["login_clave"])){
                require_once("./php/main.php");
                require_once("./php/iniciar_sesion.php");
            }
        ?>
    </form>
</div>

<!-- <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log("Name: " + profile.getName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
      };
</script> -->