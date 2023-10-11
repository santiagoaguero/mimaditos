<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM servicio WHERE servicio_nombre LIKE '%$busqueda%' ORDER BY servicio_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(servicio_id) FROM servicio WHERE servicio_nombre LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT reserva.*, cliente.cliente_nombre, cliente.cliente_apellido, mascota.mascota_nombre, servicio.servicio_nombre, horario.*, estado_reserva.* FROM reserva INNER JOIN cliente ON reserva.cliente_id = cliente.cliente_id INNER JOIN mascota ON reserva.mascota_id = mascota.mascota_id INNER JOIN servicio ON reserva.servicio_id = servicio.servicio_id INNER JOIN horario ON reserva.horario_id = horario.horario_id INNER JOIN estado_reserva ON reserva.estado_reserva_id = estado_reserva.estado_reserva_id WHERE reserva.estado_reserva_id = 1 ORDER BY reserva_fecha DESC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(reserva_id) FROM reserva  WHERE estado_reserva_id = 1";
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
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Estado</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>

';

if($total>=1 && $pagina <= $Npaginas){
    
    $contador = $inicio+1;//contador de usuarios
    $pag_inicio=$inicio+1;//ej: mostrando usuario 1 al 7

    foreach($datos as $row){
        
        $tabla.='
            <tr class="text-center" >
                <td>'.$contador.'</td>
                <td>'.$row["mascota_nombre"].'</td>
                <td>'.$row["cliente_nombre"].' '.$row["cliente_apellido"].'</td>
                <td>'.$row["servicio_nombre"].'</td>
                <td>'.$row["reserva_fecha"].'</td>
                <td>'.$row["horario_inicio"].' - '.$row["horario_fin"].'</td>
                <td><button type="button" class="btn btn-outline-warning" disabled>Pendiente</button></td>
                <td>
                    <form action="./php/reserva_pen_confirmar.php" method="POST" class="confirmarReserva">
                        <input type="hidden" name="confirmar" value="'.$row["reserva_id"].'">
                        <button type="submit" class="btn btn-success">Confirmar</button>
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