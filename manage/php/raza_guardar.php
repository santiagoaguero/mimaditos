<?php
require_once("main.php");

//almacenando datos
$raza=limpiar_cadena($_POST["raza"]);

//verifica campos obligatorios
if($raza == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$",$raza)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El nombre de Raza no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica inicio unico
$check_raza=con();
//query: inserta la consulta directo a la bd
$check_raza=$check_raza->query("SELECT mascota_raza_nombre FROM mascota_raza 
WHERE mascota_raza_nombre = '$raza'");//checks if raza exists
if($check_raza->rowCount()>0){//inicio found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El nombre de Raza ya está registrado en la base de datos, por favor elija otro nombre.
    </div>';
    exit();
}
$check_raza=null;//close db connection

//guardando datos
$guardar_raza = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_raza = $guardar_raza->prepare("INSERT INTO
    mascota_raza(mascota_raza_nombre) VALUES(:nombre)");

//evitando inyecciones sql xss
$marcadores=[":nombre"=>$raza];
$guardar_raza->execute($marcadores);

if($guardar_raza->rowCount()==1){// 1 horario nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Raza registrada!</strong><br>
        La Raza se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar la Raza, inténtelo nuevamente.
    </div>';
}
$guardar_raza=null; //cerrar conexion;