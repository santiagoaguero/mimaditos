<?php
require_once("main.php");

//almacenando datos
$tipo=limpiar_cadena($_POST["tipo"]);

//verifica campos obligatorios
if($tipo == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$",$tipo)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Tipo de mimadito no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica inicio unico
$check_tipo=con();
//query: inserta la consulta directo a la bd
$check_tipo=$check_tipo->query("SELECT mascota_tipo_nombre FROM mascota_tipo 
WHERE mascota_tipo_nombre = '$tipo'");//checks if tipo exists
if($check_tipo->rowCount()>0){//tipo found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Tipo de mimadito ya está registrado en la base de datos, por favor elija otro tipo.
    </div>';
    exit();
}
$check_tipo=null;//close db connection

//guardando datos
$guardar_tipo = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_tipo = $guardar_tipo->prepare("INSERT INTO
    mascota_tipo(mascota_tipo_nombre) VALUES(:nombre)");

//evitando inyecciones sql xss
$marcadores=[":nombre"=>$tipo];
$guardar_tipo->execute($marcadores);

if($guardar_tipo->rowCount()==1){// 1 horario nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Tipo de mimadito registrado!</strong><br>
        El Tipo de mimadito se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar el Tipo de mimadito, inténtelo nuevamente.
    </div>';
}
$guardar_tipo=null; //cerrar conexion;