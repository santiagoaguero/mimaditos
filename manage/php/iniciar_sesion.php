<?php

//almacenando datos
$usuario=limpiar_cadena($_POST["login_user"]);
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

if(verificar_datos("^[a-zA-Z0-9$@._]{4,40}$",$usuario)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Usuario no coincide con el formato esperado.
    </div>';
    exit();
}

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
$check_user=$check_user->query("SELECT * from empleado WHERE
(empleado_usuario='$usuario' OR empleado_email='$usuario') AND empleado_estado = 1");

if($check_user->rowCount()==1){//user found
    $check_user=$check_user->fetch();//fetch only one user. fetchAll fetchs all users
    if( ($check_user["empleado_usuario"] == $usuario && password_verify($clave, $check_user["empleado_clave"])) || ($check_user["empleado_email"] == $usuario && password_verify($clave, $check_user["empleado_clave"])) ){//hashea y compara con las claves guardadas

        //variables de sesion local
            $_SESSION["id"]=$check_user["empleado_id"];
            $_SESSION["rol"]=$check_user["rol_id"];
            $_SESSION["user"]= "emp";
            $_SESSION["nombre"]=$check_user["empleado_nombre"];
            $_SESSION["apellido"]=$check_user["empleado_apellido"];
            $_SESSION["email"]=$check_user["empleado_email"];
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
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Contraseña incorrecta.
        </div>';
    }

} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        no encontramos el usuario.
    </div>';
}


$check_user=null;