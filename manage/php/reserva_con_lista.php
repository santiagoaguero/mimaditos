<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM servicio WHERE servicio_nombre LIKE '%$busqueda%' ORDER BY servicio_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(servicio_id) FROM servicio WHERE servicio_nombre LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT turno.*, reserva.*, horario.*, mascota.mascota_nombre, cliente.cliente_nombre, cliente.cliente_apellido FROM turno INNER JOIN reserva ON turno.turno_id = reserva.turno_id INNER JOIN mascota ON reserva.mascota_id = mascota.mascota_id INNER JOIN horario ON turno.horario_id = horario.horario_id INNER JOIN cliente ON reserva.cliente_id = cliente.cliente_id WHERE turno.turno_estado = 2 ORDER BY turno.turno_fecha DESC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(turno_id) FROM turno  WHERE turno_estado = 2";
}

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();//fetch una unica columna
//cantidad paginas para mostrar
$Npaginas = ceil($total/$registros);//redonde hacia arriba

$tabla.='
    <div class="table-responsive">
    <table class="table table-bordered table-light table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Mimado</th>
                <th>Dueño</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Transporte</th>
                <th>Estado</th>
                <th colspan="3">Opciones</th>
            </tr>
        </thead>
        <tbody>

';

if($total>=1 && $pagina <= $Npaginas){
    
    $contador = $inicio+1;//contador de usuarios
    $pag_inicio=$inicio+1;//ej: mostrando usuario 1 al 7

    foreach($datos as $row){
                        //cambiar formato fecha
                        $timestamp = strtotime($row["turno_fecha"]);
                
                        //formatea la fecha en el formato DD-MM-YYYY
                        $fecha = date("d-m-Y", $timestamp);
        
        $tabla.='
            <tr class="text-center align-middle" >
                <td>'.$contador.'</td>
                <td>'.$row["mascota_nombre"].'</td>
                <td><a href="index.php?vista=cliente_update&cliente_id_upd='.$row["cliente_id"].'" class="btn">'.$row["cliente_nombre"].' '.$row["cliente_apellido"].'</a></td>
                <td>'.$fecha.'</td>
                <td>'.$row["horario_inicio"].' - '.$row["horario_fin"].'</td>';

                if($row["reserva_transporte"] == 1){
                    $tabla.='
                    <td><button type="button" class="btn btn-outline-info" disabled>SI</button></td>';
                } else {
                    $tabla.='
                    <td><button type="button" class="btn btn-outline-secondary" disabled>no</button></td>';
                }
                $tabla.='
                <td><button type="button" class="btn btn-outline-success" disabled>Confirmado</button></td>
                <td><a href="index.php?vista=reserva_con_det&det_id='.$row["reserva_id"].'" class="btn btn-outline-primary">Ver Detalle</a></td>
                <td>
                    <form action="./php/reserva_con_cancelar.php" method="POST" class="cancelarReserva">
                        <input type="hidden" name="cancelar" value="'.$row["turno_id"].'">
                        <button type="submit" class="btn btn-warning">Cancelar</button>
                    </form>
                </td>
                <td>
                <form action="./php/reserva_eliminar.php" method="POST" class="confirmarDelete">
                    <input type="hidden" name="eliminar" value="'.$row["reserva_id"].'">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                </td>
            </tr>
        ';
        $contador++;
    }
    $pag_final=$contador-1;//ej: mostrando usuario 1 al 7
} else {
    if($total>=1){//si introduce una pagina no existente te muestra boton para llevarte a la pag 1
        $tabla.='
            <tr class="text-center" >
            <td colspan="9">
                <a href="'.$url.'1" class="btn btn-primary"">
                    Haga clic para recargar el listado
                </a>
            </td>
        </tr> 
        ';
    } else {
        $tabla.='
            <tr class="text-center" >
            <td colspan="9">
                No hay registros en el sistema
            </td>
        </tr>
    ';
    }
}



$tabla.='
            </tbody>
        </table>
    </div>';


if($total>=1 && $pagina <= $Npaginas){
    $tabla.='
        <p class="text-end">Mostrando reservas <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}