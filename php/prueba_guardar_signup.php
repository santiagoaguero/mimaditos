<?php
include_once("main.php");

//ya que se utilizan varias llamadas a con() esto puede generar una nueva instancia de pdo
//por lo que aseguramos que se use siempre la misma y no genere errores en las inserciones
$pdo = con();

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$ciudad=limpiar_cadena($_POST["ciudad"]);
$direccion=limpiar_cadena($_POST["direccion"]);
$mascota=limpiar_cadena($_POST["mascota"]);
$tipo=(int)limpiar_cadena($_POST["tipo"]);
$email=limpiar_cadena($_POST["email"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);

$crea_cliente = true;
$crea_mascota = true;


        //variables de sesion
        $_SESSION["id"]=$contraseña;
        $_SESSION["nombre"]=$nombre;
        $_SESSION["apellido"]=$apellido;
        $_SESSION["email"]=$email;
        $_SESSION["cuenta"]="local";
        $_SESSION["signup"]= true;// para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url

        $_SESSION["crea_mascota"]= true;//

if($crea_cliente){//crea cliente
    if($crea_mascota){//crea mascota
        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=signup_exito"
            </script>
            ';
        } else {
            header("Location: index.php?vista=signup_exito");
        }
    } else {// no crea mascota
        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=signup_error2"
            </script>
            ';
        } else {
            header("Location: index.php?vista=signup_error2");
        }
    }
} else {// no crea cliente
    if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
        echo '
        <script>
            window.location.href="index.php?vista=signup_error"
        </script>
        ';
    } else {
        header("Location: index.php?vista=signup_error");
    }
};