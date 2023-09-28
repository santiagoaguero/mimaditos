<?php
require_once("main.php");

$id = limpiar_cadena($_POST["servicio_id"]);//input hidden

//verificar en bd
$check_servicio = con();
$check_servicio = $check_servicio->query("SELECT * FROM servicio WHERE servicio_id = '$id'");

if($check_servicio->rowCount()<=0){//no existe id
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se encontró el Servicio.
    </div>';
    exit();
} else {
    $datos = $check_servicio->fetch();
}
$check_servicio=null;

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
        El nombre no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[0-9]{1,11}",$duracion)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La duración del servicio no coincide con el formato esperado.
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

if($nombre != $datos["servicio_nombre"]){
    //verifica nombre nuevo sea unico
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
}


//Actualizando datos
$actualizar_servicio = con();
$actualizar_servicio = $actualizar_servicio->prepare("UPDATE servicio SET 
servicio_nombre = :nombre, servicio_duracion = :duracion, servicio_precio = :precio, servicio_descripcion = :descripcion, servicio_disponible = :hab WHERE servicio_id = :id");

$marcadores=[
    "nombre"=>$nombre,
    "duracion"=>$duracion,
    "precio"=>$precio,
    "descripcion"=>$descripcion,
    "hab"=>$hab,
    "id"=>$id
];

if($actualizar_servicio->execute($marcadores)){
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Servicio actualizado!</strong><br>
        El Servicio se actualizó exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo actualizar el Servicio, inténtelo nuevamente.
    </div>';   
}

$actualizar_servicio=null;