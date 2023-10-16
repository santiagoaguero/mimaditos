<?php
require("main.php");
$user_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_empleado = con();
$check_empleado=$check_empleado->query("SELECT * FROM empleado WHERE empleado_id = '$user_id_del'");

if($check_empleado->rowCount()==1){
    $datos = $check_empleado->fetch();

    $inactivo_empleado = con();
    $inactivo_empleado=$inactivo_empleado->prepare("UPDATE empleado SET empleado_estado = :estado WHERE empleado_id =:id");
    //filtro prepare para evitar inyecciones sql xss

    $inactivo_empleado->execute([":estado"=> 0, ":id"=> $user_id_del]);
    if($inactivo_empleado->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Usuario inactivo!</strong><br>
            El Usuario pasó a estar inactivo exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se puso inactivo al Usuario, inténtelo nuevamente.
        </div>';
    }
    $inactivo_empleado=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Usuario que intenta inactivar no existe.
    </div>';
}

$check_empleado=null;