<?php
require("main.php");
$reserva_id_del = limpiar_cadena($_POST["eliminar"]);

$detalles = true;

$check_detalle = con();
$check_detalle=$check_detalle->query("SELECT * FROM reserva_detalle WHERE reserva_id = '$reserva_id_del'");
    
if($check_detalle->rowCount()>=1){
    $detalles = $check_detalle->fetchAll();

    $eliminar_detalle = con();
    $eliminar_detalle=$eliminar_detalle->prepare("DELETE FROM reserva_detalle WHERE reserva_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_detalle->execute([":id"=> $reserva_id_del]);
    if($eliminar_detalle->rowCount()>=1){

        $detalles = true;

    } else {

        $detalles = false;
    }
    $eliminar_detalle=null;
}

if($detalles){
    //verifica reserva
    $check_reserva = con();
    $check_reserva=$check_reserva->query("SELECT * FROM reserva WHERE reserva_id = '$reserva_id_del'");

    if($check_reserva->rowCount()==1){
        $datos = $check_reserva->fetch();

        //get turno id for updating
        $turno_id = $datos['turno_id'];

        $eliminar_reserva = con();
        $eliminar_reserva=$eliminar_reserva->prepare("DELETE FROM reserva WHERE reserva_id=:id");
        //filtro prepare para evitar inyecciones sql xss

        $eliminar_reserva->execute([":id"=> $reserva_id_del]);
        if($eliminar_reserva->rowCount()==1){

            //volver a habilitar el turno
            $habilitar_turno = con();
            $habilitar_turno=$habilitar_turno->query("UPDATE turno SET turno_estado = 0 WHERE turno_id=$turno_id");
            $habilitar_turno = null;

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
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo eliminar la Reserva, inténtelo nuevamente.
    </div>';
}