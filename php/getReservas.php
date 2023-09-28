<?php
 header('Content-Type: application/json');
 
 require_once("main.php");

    //get reservas
$reservas=con();
//query: inserta la consulta directo a la bd
$reservas=$reservas->query("SELECT * FROM reserva");//select all reservas
$reservas = $reservas->fetchAll();
$reservas=null;//close db connection