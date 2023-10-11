<?php
require("main.php");
$reserva_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_reserva = con();
$check_reserva=$check_reserva->query("SELECT * FROM reserva WHERE reserva_id = '$reserva_id_del'");

if($check_reserva->rowCount()==1){
    $datos = $check_reserva->fetch();

    $eliminar_reserva = con();
    $eliminar_reserva=$eliminar_reserva->prepare("DELETE FROM reserva WHERE reserva_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_reserva->execute([":id"=> $reserva_id_del]);
    if($eliminar_reserva->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Reserva eliminada!</strong><br>
            La Reserva ha sido eliminada exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar la Reserva, inténtelo nuevamente.
        </div>';
    }
    $eliminar_reserva=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La Reserva que intenta eliminar no existe.
    </div>';
}

$check_reserva=null;