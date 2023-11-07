<?php
require("main.php");
$turno_id = limpiar_cadena($_POST["cancelar"]);

//verifica cliente
$check_reserva = con();
$check_reserva=$check_reserva->query("SELECT * FROM turno WHERE turno_id = '$turno_id' AND turno_estado = 2");

if($check_reserva->rowCount()==1){
    $datos = $check_reserva->fetch();

    $cancelar_reserva = con();
    $cancelar_reserva=$cancelar_reserva->prepare("UPDATE turno SET turno_estado = 1 WHERE turno_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $cancelar_reserva->execute([":id"=> $turno_id]);
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