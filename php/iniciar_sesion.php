<?php

//almacenando datos
$usuario=limpiar_cadena($_POST["login_email"]);
$clave=limpiar_cadena($_POST["login_clave"]);

//verifica campos obligatorios
if($usuario == "" || $clave == "" ){
    echo '
    <div class="bg-danger">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

/*verifica email
if($usuario != ""){
    if(filter_var($usuario, FILTER_VALIDATE_EMAIL)){
        $check_email=con();
        $check_email=$check_email->query("SELECT usuario_email FROM usuario 
        WHERE usuario_email = '$usuario'");//checks if email exists
        if($check_email->rowCount()>0){//email found and emails gotta be unique
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El email ya está registrado en la base de datos, por favor elija otro email.
            </div>';
            exit();
        }
        $check_email=null;//close db connection
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El email no coincide con el formato esperado.
        </div>';
        exit();
    }
}
*/

if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La CLAVE no coincide con el formato esperado.
    </div>';
    exit();
}

//verificar en la bd
$check_user=con();
$check_user=$check_user->query("SELECT * from cliente WHERE
 cliente_email='$usuario'");

 if($check_user->rowCount()==1){//user found
    echo "uusario encontrado";
    $check_user=$check_user->fetch();//fetch only one user. fetchAll fetchs all users
    if($check_user["usuario_email"] == $usuario && password_verify($clave, $check_user["usuario_clave"])){//hashea y compara con las claves guardadas
        echo "claves coiniciden";
        echo (password_verify($clave, $check_user["usuario_clave"]));

        //variables de sesion
            $_SESSION["id"]=$check_user["usuario_id"];
            $_SESSION["nombre"]=$check_user["usuario_nombre"];
            $_SESSION["apellido"]=$check_user["usuario_apellido"];
            $_SESSION["email"]=$check_user["usuario_email"];


            if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
                echo '
                <script>
                    window.location.href="index.php?vista=home"
                </script>
                ';

            } else {
                header("Location: index.php?vista=home");
            }

    } else {
        echo "claves no coiniciden";
        echo (password_verify($clave, $check_user["usuario_clave"]));
        echo '
        <div class="text-bg-danger bg-gradient">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Usuario o clave incorrecto.
        </div>';
    }

 } else {
    echo ' usuario no encontraro...
    <div class="bg-danger-subtle text-white">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Usuario o clave incorrecto.
    </div>';
 }

 $check_user=null;