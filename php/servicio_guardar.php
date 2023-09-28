<?php
require_once("main.php");

//almacenando datos
$nombre=limpiar_cadena($_POST["servicio_nombre"]);
$duracion=limpiar_cadena($_POST["servicio_duracion"]);
$descripcion=limpiar_cadena($_POST["servicio_descripcion"]);
$precio=limpiar_cadena($_POST["servicio_precio"]);

//checkbox no marcados no se envian en el form
//se verifica para darle un valor y poder guardar
$hab= isset($_POST["servicio_disponible"]) ? 
    (limpiar_cadena($_POST["servicio_disponible"])) : 
    "off";

//verifica campos obligatorios
if($nombre == "" || $precio == "" || $duracion == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$",$nombre)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El NOMBRE no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[0-9]{1,11}",$duracion)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El precio no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[0-9]{1,11}",$precio)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El precio no coincide con el formato esperado.
    </div>';
    exit();
}

if($descripcion != ""){//al no ser obligatorio puede venir vacio
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}",$descripcion)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La descripción no coincide con el formato esperado.
        </div>';
        exit();
    }
}

if($hab == "" && $hab != "on"){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo establecer el estado del Servicio.
    </div>';
    exit();
}

//verifica nombre unico
$check_nombre=con();
//query: inserta la consulta directo a la bd
$check_nombre=$check_nombre->query("SELECT servicio_nombre FROM servicio 
WHERE servicio_nombre = '$nombre'");//checks if nombre exists
if($check_nombre->rowCount()>0){//nombre found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El nombre del Servicio ya está registrado en la base de datos, por favor elija otro nombre.
    </div>';
    exit();
}
$check_nombre=null;//close db connection

//guardando datos
$guardar_servicio = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_servicio = $guardar_servicio->prepare("INSERT INTO
    servicio(servicio_nombre, servicio_descripcion, servicio_duracion, servicio_precio, servicio_disponible)
    VALUES(:nombre, :descripcion, :duracion, :precio, :hab)");

//evitando inyecciones sql xss
$marcadores=[":nombre"=>$nombre, ":descripcion"=>$descripcion, ":duracion"=>$duracion, ":precio"=>$precio, ":hab"=>$hab];
$guardar_servicio->execute($marcadores);

if($guardar_servicio->rowCount()==1){// 1 prov nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Servicio registrado!</strong><br>
        El Servicio se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar el Servicio, inténtelo nuevamente.
    </div>';
}
$guardar_servicio=null; //cerrar conexion;