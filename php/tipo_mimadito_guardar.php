<?php
require_once("main.php");

//almacenando datos
$nombre=limpiar_cadena($_POST["tipo"]);


//verifica campos obligatorios
if($nombre == ""){
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

//verifica nombre unico
$check_nombre=con();
//query: inserta la consulta directo a la bd
$check_nombre=$check_nombre->query("SELECT mascota_tipo_nombre FROM mascota_tipo 
WHERE mascota_tipo_nombre = '$nombre'");//checks if nombre exists
if($check_nombre->rowCount()>0){//nombre found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Tipo de Mimadito ya está registrado en la base de datos, por favor elija otro tipo.
    </div>';
    exit();
}
$check_nombre=null;//close db connection

//guardando datos
$guardar_tipo = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_tipo = $guardar_tipo->prepare("INSERT INTO
    mascota_tipo(mascota_tipo_nombre)
    VALUES(:nombre)");

//evitando inyecciones sql xss
$marcadores=[":nombre"=>$nombre];
$guardar_tipo->execute($marcadores);

if($guardar_tipo->rowCount()==1){// 1 prov nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Tipo de Mimadito registrado!</strong><br>
        El Tipo de Mimadito se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar el Tipo de Mimadito, inténtelo nuevamente.
    </div>';
}
$guardar_tipo=null; //cerrar conexion;