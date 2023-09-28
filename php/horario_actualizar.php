<?php
require_once("main.php");

$id = limpiar_cadena($_POST["horario_id"]);//input hidden

//verificar en bd
$check_horario = con();
$check_horario = $check_horario->query("SELECT * FROM horario WHERE horario_id = '$id'");

if($check_horario->rowCount()<=0){//no existe id
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se encontró el horario.
    </div>';
    exit();
} else {
    $datos = $check_horario->fetch();
}
$check_horario=null;

//almacenando datos
$inicio=limpiar_cadena($_POST["horario_inicio"]);
$fin=limpiar_cadena($_POST["horario_fin"]);
$pos=limpiar_cadena($_POST["horario_posicion"]);


//verifica campos obligatorios
if($inicio == "" || $fin == "" || $pos == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$",$inicio)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El horario de inicio no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$",$fin)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El horario final no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[0-9]{1,11}",$pos)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La Posición del horario no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica nuevo horario inicio exista
if($inicio != $datos["horario_inicio"]){
    $check_inicio=con();
    $check_inicio = $check_inicio->query("SELECT horario_inicio FROM horario 
    WHERE horario_inicio = '$inicio'");//checks if inicio exists
    if($check_inicio->rowCount()>0){//inicio found
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Este Horario de inicio ya se encuentra registrado en la base de datos, por favor elija otro Horario de inicio.
        </div>';
        exit();
    }
    $check_inicio=null;//close db connection
}

//verifica nuevo horario inicio exista
if($fin != $datos["horario_fin"]){
    $check_fin=con();
    $check_fin = $check_fin->query("SELECT horario_fin FROM horario 
    WHERE horario_fin = '$fin'");//checks if fin exists
    if($check_fin->rowCount()>0){//fin found
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Este Horario final ya se encuentra registrado en la base de datos, por favor elija otro Horario final.
        </div>';
        exit();
    }
    $check_fin=null;//close db connection
}

//verifica nueva posicion exista
if($pos != $datos["horario_posicion"]){
    $check_pos=con();
    $check_pos = $check_pos->query("SELECT horario_posicion FROM horario 
    WHERE horario_posicion = '$pos'");//checks if pos exists
    if($check_pos->rowCount()>0){//pos found
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Esta Posición de horario ya se encuentra ocupada por otro horario, por favor elija otra Posicion.
        </div>';
        exit();
    }
    $check_pos=null;//close db connection
}


//Actualizando datos
$actualizar_horario = con();
$actualizar_horario = $actualizar_horario->prepare("UPDATE horario SET 
horario_inicio = :inicio, horario_fin = :fin, horario_posicion = :pos WHERE horario_id = :id");

$marcadores = [
"inicio" => $inicio,
"fin" => $fin,
"pos" => $pos,
"id" => $id];

if($actualizar_horario->execute($marcadores)){
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Horario actualizado!</strong><br>
        El horario se actualizó exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo actualizar el horario, inténtelo nuevamente.
    </div>';   
}

$actualizar_horario=null;