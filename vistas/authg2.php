<?php

//se crea esta pagina para que cuando google verifique y autorice la cuenta lo mande acá
// para luego asignarle una variable de session
// una vez obtenido la variable, recien ahi se redirecciona la pagina permitida

require_once './php/g-config.php';

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    /*$userinfo = [
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];*/

    //variables de sesion google
    $_SESSION["id"]=$google_account_info['id'];
    $_SESSION["nombre"]=$google_account_info['givenName'];
    $_SESSION["apellido"]=$google_account_info['familyName'];
    $_SESSION["email"]= $google_account_info['email'];


}
echo 'hola';
/*else if(isset($_SESSION["id"])){
    aca se comprobaba si iniciaba cuenta local o google,
    ya no hace falta al asignar variables de session
    $nombre= $_SESSION["nombre"];
    }

if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
    echo '
    <script>
        window.location.href="index.php?vista=home"
    </script>
    ';

} else {
    header("Location: index.php?vista=home");
}
*/
?>
    <script>
        console.log("auth google...")
    </script>