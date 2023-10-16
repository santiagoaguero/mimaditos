<?php
require_once("main.php");
require_once("../inc/session_start.php");

$pdo = con();

//almacenando datos
$cliente=limpiar_cadena($_POST["cliente"]);
$mascota=limpiar_cadena($_POST["mimadito"]);
$horario=limpiar_cadena($_POST["horario"]);
$fecha=limpiar_cadena($_POST["fecha"]);
$notas=limpiar_cadena($_POST["notas"]);

if(isset($_POST["servicios"])){
    $servicios = $_POST["servicios"];
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has seleccionado ningún Servicio.
    </div>';
    exit();
}

if($horario == '0'){
    echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No hay horarios disponibles para esta fecha
        </div>' ;
    exit();
}

//verificar que el input hidden no se haya manipulado
if($cliente != $_SESSION["id"]){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No podemos añadir su mimadito a otro dueño que no sea usted.
    </div>';
    exit();
}

//verifica cliente exista
$check_cliente=con();
//query: inserta la consulta directo a la bd
$check_cliente=$check_cliente->query("SELECT cliente_id FROM cliente 
WHERE cliente_id = '$cliente'");//checks if cliente exists
if($check_cliente->rowCount()==0){//cliente found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No encontramos al dueño de este mimadito.
    </div>';
    exit();
}
$check_cliente=null;//close db connection

//verifica campos obligatorios
if($mascota == "" || $horario == "" || $fecha == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica mascota corresponda a cliente
$check_mascota=con();
//query: inserta la consulta directo a la bd
$check_mascota=$check_mascota->query("SELECT mascota_id FROM mascota 
WHERE mascota_id = '$mascota' AND cliente_id = '$cliente'");//checks if cliente exists
if($check_mascota->rowCount()==0){//cliente found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No encontramos el mimadito.
    </div>';
    exit();
}
$check_mascota=null;//close db connection

//checkbox no marcados no se envian en el form
//se verifica para darle un valor y poder guardar
$transporte = (isset($_POST["transporte"]) && $_POST["transporte"] == 'on') ? 
    1 : 
    0;


if($notas != ""){//al no ser obligatorio puede venir vacio
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}",$notas)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La descripción no coincide con el formato esperado.
        </div>';
        exit();
    }
}


//guardando datos
$guarda = false;
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_reserva = $pdo->prepare("INSERT INTO
    reserva(cliente_id, mascota_id, horario_id, reserva_fecha, reserva_transporte, reserva_notas, reserva_estado)
    VALUES(:cliente, :mascota, :horario, :fecha, :transporte, :notas, :estado)");

$marcadores=[":cliente"=>$cliente, ":mascota"=> $mascota, ":horario"=>$horario,
 ":fecha"=> $fecha, ":transporte"=> $transporte, ":notas"=>$notas, ":estado"=> 0];

$guardar_reserva->execute($marcadores);

if($guardar_reserva->rowCount() ==1 ){// 1 reserva nueva insertado
    $last_id = $pdo->lastInsertId();
    $guarda = true;

    // inserta la mascota asociada al cliente
    $guardar_reserva_det = $pdo->prepare("INSERT INTO reserva_detalle (reserva_id, servicio_id) VALUES (:reserva, :servicio)");
                        
    foreach($servicios as $s){
        //evitando inyecciones sql xss
        $marcadores=[":reserva"=>$last_id, ":servicio"=> $s];

        if(!$guardar_reserva_det->execute($marcadores)){
            $guarda = false;
            break;
        }
    }
    $guardar_reserva_det = null;

}
$guardar_reserva=null; //cerrar conexion;

if($guarda){
    //esto recibe ajax y verifica el texto para redireccionar
    //esto para seguir mostrando las demas alertas en el modal
    echo'<strong>Reserva Solicitada!</strong>';

    $_SESSION["reserva"] = '
    <div class="alert alert-success" role="alert">
        <strong>Reserva Solicitada!</strong><br>
        Hemos recibido tu solicitud y lo confirmaremos en unos instantes :)<br>
        Gracias por confiar en nosotros!
    </div>';
} else {
   echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar la reserva, por favor inténtalo de nuevo
    </div>';
}