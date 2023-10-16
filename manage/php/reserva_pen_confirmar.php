<?php
require("main.php");
$reserva_id_con = limpiar_cadena($_POST["confirmar"]);

//verifica cliente
$check_reserva = con();
$check_reserva=$check_reserva->query("SELECT * FROM reserva WHERE reserva_id = '$reserva_id_con' AND reserva_estado = 0");

if($check_reserva->rowCount()==1){
    $datos = $check_reserva->fetch();

    $confirmar_reserva = con();
    $confirmar_reserva=$confirmar_reserva->prepare("UPDATE reserva SET reserva_estado = 1 WHERE reserva_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $confirmar_reserva->execute([":id"=> $reserva_id_con]);
    if($confirmar_reserva->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Reserva confirmada!</strong><br>
            La Reserva ha sido confirmada exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo confirmar la Reserva, inténtelo nuevamente.
        </div>';
    }
    $confirmar_reserva=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La Reserva que intenta confirmar no existe.
    </div>';
}

$check_reserva=null;