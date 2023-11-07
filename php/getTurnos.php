<?php
 header('Content-Type: application/json');
 
 require_once("main.php");

    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT turno.* , horario.* FROM turno INNER JOIN horario ON turno.horario_id = horario.horario_id");//select all reservas -
$reservas = $reservas->fetchAll();

$eventos = [];

foreach($reservas as $row){

    $color = $row['turno_estado'] == 0 ? 'green' : 'red';//
    $title = $row['turno_estado'] == 0 ? 'Turno Disponible' : 'no disponible';//
    //cambiar formato fecha
    $fechaModalTitle = strtotime($row["turno_fecha"]);
    //formatea la fecha en el formato DD-MM-YYYY
    $fecha = date("d-m-Y", $fechaModalTitle);


    $eventos[] = [
        'color' => $color,
        'id' => $row['turno_id'],
        'title' => $row['horario_inicio']. ' - ' .$row['horario_fin'],
        'start' => $row['turno_fecha'] . 'T' . $row['horario_inicio'],
        'end' => $row['turno_fecha'] . 'T' . $row['horario_fin'],
        'estado' => $row['turno_estado'],
        'fecha' => $fecha,
        'horario' => $row['horario_id']
    ];

}
echo json_encode($eventos);
$reservas=null;//close db connection