<?php

//se crea esta pagina para que cuando google verifique y autorice la cuenta lo mande acá
// para luego asignarle una variable de session
// una vez obtenido la variable, recien ahi se redirecciona la pagina permitida

require_once './php/g-config.php';

// Verificar si se recibe el código de autorización de Google
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        // Verificar si se obtuvo el token correctamente
        if (isset($token['access_token'])) {
            $client->setAccessToken($token['access_token']);

            // Obtener información del perfil
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            // Verificar si se obtuvo la información del perfil correctamente
            if ($google_account_info) {
                // Establecer variables de sesión
                $_SESSION["id"] = $google_account_info['id'];
                $_SESSION["nombre"] = $google_account_info['givenName'];
                $_SESSION["apellido"] = $google_account_info['familyName'];
                $_SESSION["email"] = $google_account_info['email'];
                $_SESSION["cuenta"]="google";
                $_SESSION["token"]=$token['access_token'];
                $_SESSION["signin"]= true;// para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url
            } else {
                // Manejo de error: No se pudo obtener la información del perfil
                echo "Error: No se pudo obtener la información del perfil de Google.";
            }
        } else {
            // Manejo de error: No se pudo obtener el token de acceso
            echo "Error: No se pudo obtener el token de acceso de Google.";
        }
    } catch (Exception $e) {
        // Manejo de error: Capturar excepciones generadas durante la autenticación
        echo "Error: " . $e->getMessage();
    }
}

// Redirigir a la vista 'home'
if (!headers_sent()) {
    header("Location: index.php?vista=home");
} else {
    echo '
    <script>
        window.location.href="index.php?vista=home";
    </script>
    ';
}
?>
