<?php
 header('Content-Type: application/json');
 
 require_once("main.php");

    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT reserva.*, servicio.servicio_nombre, horario.*, mascota.mascota_nombre FROM reserva INNER JOIN servicio ON reserva.servicio_id = servicio.servicio_id INNER JOIN horario ON reserva.horario_id = horario.horario_id INNER JOIN mascota ON reserva.mascota_id = mascota.mascota_id WHERE reserva.estado_reserva_id != 0 GROUP BY mascota.mascota_nombre, reserva.reserva_fecha, horario.horario_inicio");//select all reservas -
$reservas = $reservas->fetchAll();

$eventos = [];

foreach($reservas as $row){

    $color = $row['estado_reserva_id'] == 1 ? 'orange' : '';//pendiente

    $eventos[] = [
        'color' => $color,
        'id' => $row['reserva_id'],
        'title' => $row['mascota_nombre'],
        'start' => $row['reserva_fecha'] . 'T' . $row['horario_inicio'],
        'end' => $row['reserva_fecha'] . 'T' . $row['horario_fin'],
        'mascota' => $row['mascota_id'],
        'estado' => $row['estado_reserva_id']
    ];

}
echo json_encode($eventos);
$reservas=null;//close db connection