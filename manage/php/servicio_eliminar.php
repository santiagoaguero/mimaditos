<?php
require("main.php");
$servicio_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_servicio = con();
$check_servicio=$check_servicio->query("SELECT * FROM servicio WHERE servicio_id = '$servicio_id_del'");

if($check_servicio->rowCount()==1){
    $datos = $check_servicio->fetch();

    $eliminar_servicio = con();
    $eliminar_servicio=$eliminar_servicio->prepare("DELETE FROM servicio WHERE servicio_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_servicio->execute([":id"=> $servicio_id_del]);
    if($eliminar_servicio->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Servicio eliminado!</strong><br>
            El Servicio ha sido eliminado exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar el Servicio, inténtelo nuevamente.
        </div>';
    }
    $eliminar_servicio=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Servicio que intenta eliminar no existe.
    </div>';
}

$check_servicio=null;