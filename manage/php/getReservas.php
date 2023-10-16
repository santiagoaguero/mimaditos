<?php
 header('Content-Type: application/json');
 
 require_once("main.php");

    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT reserva.* , mascota.mascota_nombre, horario.* FROM reserva INNER JOIN mascota ON reserva.mascota_id = mascota.mascota_id INNER JOIN horario ON reserva.horario_id = horario.horario_id");//select all reservas -
$reservas = $reservas->fetchAll();

$eventos = [];

foreach($reservas as $row){

    $color = $row['reserva_estado'] == 0 ? 'orange' : '';//pendiente

    $eventos[] = [
        'color' => $color,
        'id' => $row['reserva_id'],
        'title' => $row['mascota_nombre'],
        'start' => $row['reserva_fecha'] . 'T' . $row['horario_inicio'],
        'end' => $row['reserva_fecha'] . 'T' . $row['horario_fin'],
        'mascota' => $row['mascota_id'],
        'estado' => $row['reserva_estado']
    ];

}
echo json_encode($eventos);
$reservas=null;//close db connection