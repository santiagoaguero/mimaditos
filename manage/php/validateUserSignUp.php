<?php
require_once("main.php");

$buscar = con();

//verifica de que formulario se busca, si presupuesto o factura
if(isset($_POST["inputUser"])){
    $usuario = limpiar_cadena($_POST["inputUser"]);

}

/* busca en clientes */
$cliente = $buscar->query("SELECT cliente_usuario FROM cliente WHERE cliente_usuario = '$usuario'");


/* busca en empleados */
$empleado = $buscar->query("SELECT empleado_usuario FROM empleado WHERE empleado_usuario = '$usuario'");



if($cliente->rowCount() > 0 || $empleado->rowCount() > 0){
    $usuario = true;
} else {
    $usuario = false;
}

echo $usuario;