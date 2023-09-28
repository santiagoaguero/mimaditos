<?php
//esto verificaba si el usuario cerró sesion en otra pagina externa
//y no permitirle navegar mas en nuestra pagina
//pero no hay manera que nuestra pagina se entere cuando google cierra sesion externamente
//el token sigue almacenado y seguira en nuestra pagina hasta que cierre sesion de nuestra pagina


require_once 'g-config.php';

// Función para verificar el token de acceso
function verificarTokenDeAcceso($tokenDeAcceso) {
    global $client;

    try {
        $client->setAccessToken($tokenDeAcceso);

        // Verificar si el token es válido haciendo una solicitud a la API de Google
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        if ($google_account_info) {
            // El token de acceso es válido, el usuario está autenticado con Google
            return true;
        } else {
            // El token de acceso no es válido, el usuario no está autenticado con Google
            return false;
        }
    } catch (Exception $e) {
        // Error al verificar el token de acceso
        return false;
    }
}