<?php 
    require("./inc/session_start.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
        include("./inc/head.php");
    ?>
</head>
<body>
    <?php
        if(!isset($_GET["vista"]) || $_GET["vista"] == ""){
            $_GET["vista"]= "login";
        }

        if($_GET["vista"] === "signup"){
                include("./vistas/signup.php");
                include("./inc/script.php");
        } 
        elseif ($_GET["vista"] === "authg"){
            include("./vistas/authg.php");
        }

        elseif (is_file("./vistas/".$_GET["vista"].".php") && $_GET["vista"] != "login" && $_GET["vista"] != "404"){
             //cierra sesion no autorizada
             if((!isset($_SESSION["id"]) || $_SESSION["id"]=="") || 
                (!isset($_SESSION["email"]) || $_SESSION["email"]=="")){
                 //redirecciona al login
                 include("./vistas/logout.php");
                 exit();//para no cargar ningun archivo mas
             }
             if ($_GET["vista"] == "signup_exito" || $_GET["vista"] == "signup_error" || $_GET["vista"] == "signup_error2"){
                //para estas vistas no mostrar el navbar ni nada, se cierran pasado 5 seg
                include("./vistas/".$_GET["vista"].".php");
             } else {
                include("./inc/navbar.php");
                include("./vistas/".$_GET["vista"].".php");
                include("./inc/script.php");
            }
        } else {
            if($_GET["vista"]=== "login"){
                include("./vistas/login.php");
            } else {
                include("./vistas/404.php");
            }
        }
    ?>
</body>
</html>