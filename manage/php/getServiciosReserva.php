<?php
require_once("main.php");

$data = json_decode(file_get_contents('php://input'), true);

// Obtén la fecha seleccionada del objeto JSON enviado desde JavaScript
$reserva_id = $data['reserva'];
 



    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT servicio.servicio_nombre FROM servicio INNER JOIN `reserva_detalle` ON reserva_detalle.servicio_id = servicio.servicio_id WHERE reserva_detalle.reserva_id = '$reserva_id';");//select all servicios from this reserva -
if ($reservas->rowCount() > 0) {
    $servicio = array();

    foreach ($reservas as $row) {
        $servicio[] = array(
            'servicio' => $row['servicio_nombre'],
        );
    }

    // Genera una respuesta JSON válida
    echo json_encode($servicio);
} else {
    // Si no hay horarios disponibles devuelve un mensaje o un objeto JSON vacío
    echo json_encode(array());
}
$reservas=null;