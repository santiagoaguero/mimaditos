<?php
 header('Content-Type: application/json');
 
 require_once("main.php");

    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT turno.*, reserva.*, horario.*, cliente.cliente_nombre, cliente.cliente_apellido, mascota.mascota_nombre FROM turno LEFT JOIN reserva ON turno.turno_id = reserva.turno_id LEFT JOIN horario ON turno.horario_id = horario.horario_id LEFT JOIN cliente ON reserva.cliente_id = cliente.cliente_id LEFT JOIN mascota ON reserva.mascota_id = mascota.mascota_id");//select all reservas -
$reservas = $reservas->fetchAll();

$eventos = [];

foreach($reservas as $row){

    $color = $row['turno_estado'] == 0 ? 'green' : 'red';//
    //$title = $row['turno_estado'] == 0 ? 'Turno Disponible' : 'no disponible';
    //cambiar formato fecha
    $fechaModalTitle = strtotime($row["turno_fecha"]);
    //formatea la fecha en el formato DD-MM-YYYY
    $fecha = date("d-m-Y", $fechaModalTitle);


    $eventos[] = [
        'color' => $color,
        'reserva' => $row['reserva_id'],
        'turno' => $row['turno_id'],
        'title' => $row['horario_inicio']. ' - ' .$row['horario_fin'],
        'start' => $row['turno_fecha'] . 'T' . $row['horario_inicio'],
        'end' => $row['turno_fecha'] . 'T' . $row['horario_fin'],
        'estado' => $row['turno_estado'],
        'cliente' => $row['cliente_id'],
        'cliente_nombre' => $row['cliente_nombre']. ' ' .$row['cliente_apellido'],
        'mascota' => $row['mascota_id'],
        'mascota_nombre' => $row['mascota_nombre'],
        'notas' => $row['reserva_notas'],
        'transporte' => $row['reserva_transporte']
    ];

}
echo json_encode($eventos);
$reservas=null;//close db connection