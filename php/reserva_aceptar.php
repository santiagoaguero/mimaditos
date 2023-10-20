<?php
require_once("main.php");

$cliente_id = limpiar_cadena($_POST["id"]);//input hidden
$reserva_id = limpiar_cadena($_POST["aceptar"]);//input hidden

//Actualizando datos
$check_reserva = con();
$check_reserva = $check_reserva->prepare("UPDATE reserva SET reserva_aceptado = :aceptado WHERE reserva_id = :r_id AND cliente_id = :c_id");

$marcadores=[
    "r_id"=>$reserva_id,
    "c_id"=>$cliente_id,
    "aceptado"=>1
];

$check_reserva->execute($marcadores);