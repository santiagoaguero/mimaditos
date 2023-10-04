<?php

//almacenando datos
$usuario=limpiar_cadena($_POST["login_email"]);
$clave=limpiar_cadena($_POST["login_clave"]);

//verifica campos obligatorios
if($usuario == "" || $clave == "" ){
    echo '
    <div class="alert alert-danger" role="alert">
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

if(verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$clave)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La contraseña no coincide con el formato esperado.<br>
        La contraseña debe contener mínimo 6 caracteres.
    </div>';
    exit();
}

//verificar en la bd
$check_user=con();
$check_user=$check_user->query("SELECT * from cliente WHERE
 cliente_email='$usuario'");

 if($check_user->rowCount()==1){//user found
    $check_user=$check_user->fetch();//fetch only one user. fetchAll fetchs all users
    if($check_user["cliente_email"] == $usuario && password_verify($clave, $check_user["cliente_clave"])){//hashea y compara con las claves guardadas

        //variables de sesion local
            $_SESSION["id"]=$check_user["cliente_id"];
            $_SESSION["rol"]=$check_user["rol_id"];;
            $_SESSION["nombre"]=$check_user["cliente_nombre"];
            $_SESSION["apellido"]=$check_user["cliente_apellido"];
            $_SESSION["email"]=$check_user["cliente_email"];
            $_SESSION["cuenta"]="local";
            $_SESSION["signin"]= true;//


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
        echo (password_verify($clave, $check_user["usuario_clave"]));
        echo '
        <<div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Contraseña incorrecta.
        </div>';
    }

 } else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        no se encontró el correo.
    </div>';
 }

 $check_user=null;