<?php
require_once("main.php");

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

//verifica inicio unico
$check_inicio=con();
//query: inserta la consulta directo a la bd
$check_inicio=$check_inicio->query("SELECT horario_inicio FROM horario 
WHERE horario_inicio = '$inicio'");//checks if inicio exists
if($check_inicio->rowCount()>0){//inicio found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El horario de inicio ya está registrado en la base de datos, por favor elija otro horario.
    </div>';
    exit();
}
$check_inicio=null;//close db connection

//verifica fin unico
$check_fin=con();
//query: inserta la consulta directo a la bd
$check_fin=$check_fin->query("SELECT horario_fin FROM horario 
WHERE horario_fin = '$fin'");//checks if fin exists
if($check_fin->rowCount()>0){//fin found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El horario final ya está registrado en la base de datos, por favor elija otro horario.
    </div>';
    exit();
}
$check_fin=null;//close db connection

//verifica pos unico
$check_pos=con();
//query: inserta la consulta directo a la bd
$check_pos=$check_pos->query("SELECT horario_posicion FROM horario 
WHERE horario_posicion = '$pos'");//checks if pos exists
if($check_pos->rowCount()>0){//pos found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La posición de este horario ya está registrada en la base de datos, por favor elija otra posición.
    </div>';
    exit();
}
$check_pos=null;//close db connection

//guardando datos
$guardar_horario = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_horario = $guardar_horario->prepare("INSERT INTO
    horario(horario_inicio, horario_fin, horario_posicion)
    VALUES(:inicio, :fin, :pos)");

//evitando inyecciones sql xss
$marcadores=[":inicio"=>$inicio, ":fin"=>$fin, ":pos"=>$pos];
$guardar_horario->execute($marcadores);

if($guardar_horario->rowCount()==1){// 1 horario nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Horario registrado!</strong><br>
        El Horario se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar el Horario, inténtelo nuevamente.
    </div>';
}
$guardar_horario=null; //cerrar conexion;