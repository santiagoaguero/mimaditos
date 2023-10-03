<?php
require_once("main.php");

$cliente_id = limpiar_cadena($_POST["cliente_id"]);//input hidden
$mascota_id = limpiar_cadena($_POST["mascota_id"]);//input hidden

//verificar en bd
$check_mascota = con();
$check_mascota = $check_mascota->query("SELECT * FROM mascota WHERE mascota_id = '$mascota_id' AND cliente_id = '$cliente_id'");

if($check_mascota->rowCount()<=0){//no existe id
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se encontró la mascota.
    </div>';
    exit();
} else {
    $datos = $check_mascota->fetch();
}
$check_mascota=null;

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$tipo=limpiar_cadena($_POST["tipo"]);
$raza=limpiar_cadena($_POST["raza"]);
$edad=limpiar_cadena($_POST["edad"]);
$tamaño=limpiar_cadena($_POST["tamaño"]);
$notas=limpiar_cadena($_POST["notas"]);


//checkbox no marcados no se envian en el form
//se verifica para darle un valor y poder guardar
$estado= isset($_POST["estado"]) ? 
    (limpiar_cadena($_POST["estado"])) : 
    "off";

//verifica campos obligatorios
if($nombre == "" || $tipo == ""){
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

if(verificar_datos("[0-9]{1,11}",$tipo)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La duración del servicio no coincide con el formato esperado.
    </div>';
    exit();
}

if($tipo < 1 && $tipo > 4){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Tipo de mimadito no adminitdo.
    </div>';
    exit();
}

if($notas != ""){//al no ser obligatorio puede venir vacio
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}",$notas)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La nota no coincide con el formato esperado.
        </div>';
        exit();
    }
}

if($estado != "off" && $estado != "on"){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo establecer el estado del Servicio.
    </div>';
    exit();
}

if($nombre != $datos["mascota_nombre"]){
    //verifica nombre nuevo sea unico
    $check_nombre=con();
    //query: inserta la consulta directo a la bd
    $check_nombre=$check_nombre->query("SELECT mascota_nombre FROM mascota 
    WHERE mascota_nombre = '$nombre' AND cliente_id = '$cliente_id'");//checks if nombre exists
    if($check_nombre->rowCount()>0){//nombre found
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Ya tienes un mimadito registrado con este nombre, por favor elija otro nombre.
        </div>';
        exit();
    }
    $check_nombre=null;//close db connection
}

//Actualizando datos
$actualizar_mascota = con();
$actualizar_mascota = $actualizar_mascota->prepare("UPDATE mascota SET mascota_nombre = :nombre, mascota_tipo_id = :tipo, mascota_raza_id = :raza, mascota_edad = :edad, cliente_id = :c_id, mascota_tamano_id = :tamano, mascota_notas = :notas, mascota_estado = :estado WHERE mascota_id = :m_id AND cliente_id = :c_id");

$marcadores=[
    "nombre"=>$nombre,
    "tipo"=>$tipo,
    "raza"=>$raza,
    "edad"=>$edad,
    "c_id"=>$cliente_id,
    "tamano"=>$tamaño,
    "notas"=>$notas,
    "estado"=>$estado,
    "m_id"=>$mascota_id
];

if($actualizar_mascota->execute($marcadores)){
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Mimadito actualizado!</strong><br>
        Su mimadito se actualizó exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo actualizar su mimadito, inténtelo nuevamente.
    </div>';   
}

$actualizar_mascota=null;