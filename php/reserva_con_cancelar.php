<?php
require("main.php");
$reserva_id_con = limpiar_cadena($_POST["cancelar"]);

//verifica cliente
$check_reserva = con();
$check_reserva=$check_reserva->query("SELECT * FROM reserva WHERE reserva_id = '$reserva_id_con' AND estado_reserva_id = 2");

if($check_reserva->rowCount()==1){
    $datos = $check_reserva->fetch();

    $cancelar_reserva = con();
    $cancelar_reserva=$cancelar_reserva->prepare("UPDATE reserva SET estado_reserva_id = 1 WHERE reserva_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $cancelar_reserva->execute([":id"=> $reserva_id_con]);
    if($cancelar_reserva->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Reserva cancelada!</strong><br>
            La Reserva ha sido cancelada y pasó a estar Pendiente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo cancelar la Reserva, inténtelo nuevamente.
        </div>';
    }
    $cancelar_reserva=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La Reserva que intenta cancelar no existe.
    </div>';
}

$check_reserva=null;