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

                //cambiamos el token access por el google id
                $gid = $google_account_info['id'];

                $nombre = $google_account_info['givenName'];
                $apellido = $google_account_info['familyName'];
                $email = $google_account_info['email'];

                require_once("./php/main.php");
                $pdo = con();
                $check_user = $pdo->query("SELECT * FROM cliente WHERE
                 google_id = '".$google_account_info['id']."' ");

                 //ya ingreso antes
                 if($check_user->rowCount() == 1){
                    $check_user= $check_user->fetch();
                    // Establecer variables de sesión
                    $_SESSION["id"] = $check_user["cliente_id"];
                    $_SESSION["gid"] = $check_user["google_id"];
                    $_SESSION["rol"]=$check_user["rol_id"];
                    $_SESSION["user"]= "cli";
                    $_SESSION["nombre"] = $check_user["cliente_nombre"];
                    $_SESSION["apellido"] = $check_user["cliente_apellido"];
                    $_SESSION["email"] = $check_user["cliente_email"];
                    $_SESSION["cuenta"]="google";
                    $_SESSION["token"]=$token['access_token'];
                    $_SESSION["signin"]= true;// para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url


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
                } else {
                    //crear nuevo usuario
                    $contraseña = "";
                    $telefono = 0000;
                    $direccion = "";
                    $ciudad = "";

                    //usaremos google id en vez del token en sí
                    //guardando datos
                    $guardar_cliente_query = $pdo->prepare("INSERT INTO
                    cliente(google_id, cliente_nombre, cliente_apellido, cliente_usuario, cliente_clave, cliente_email, cliente_telefono, cliente_direccion, cliente_ciudad, rol_id, cliente_estado)
                    VALUES(:gid, :nombre, :apellido, :usuario, :clave, :email, :telefono, :direccion, :ciudad, :rol, :estado)");

                    //evitando inyecciones sql xss
                    $marcadores=[
                    ":gid"=>$gid, ":nombre"=>$nombre, ":apellido"=>$apellido, ":usuario"=>$email, ":clave"=>$contraseña, ":email"=>$email, ":telefono"=>$telefono, ":direccion"=>$direccion, ":ciudad"=>$ciudad, ":rol"=> 4, ":estado"=> 1];

                    $guardar_cliente_query->execute($marcadores);

                    if($guardar_cliente_query->rowCount() == 1){
                        $id = $pdo->lastInsertId();
                        // Establecer variables de sesión
                        $_SESSION["id"] = $id;
                        $_SESSION["gid"] = $gid;
                        $_SESSION["rol"]=4;
                        $_SESSION["user"]= "cli";
                        $_SESSION["nombre"] = $nombre;
                        $_SESSION["apellido"] = $apellido;
                        $_SESSION["email"] = $email;
                        $_SESSION["cuenta"]="google";
                        $_SESSION["token"]=$token['access_token'];
                        $_SESSION["signup"]= true;// para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url

                        // Redirigir a la vista 'exito'
                        if (!headers_sent()) {
                            header("Location: index.php?vista=signup_exito");
                        } else {
                            echo '
                            <script>
                                window.location.href="index.php?vista=signup_exito";
                            </script>
                            ';
                        }
                    }
                    $guardar_cliente_query = null;
                }

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

?>
