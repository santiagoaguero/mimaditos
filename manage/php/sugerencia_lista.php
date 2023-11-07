<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM servicio WHERE servicio_nombre LIKE '%$busqueda%' ORDER BY servicio_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(servicio_id) FROM servicio WHERE servicio_nombre LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT testimonio.*, cliente.cliente_nombre, cliente.cliente_apellido FROM testimonio INNER JOIN cliente ON testimonio.cliente_id = cliente.cliente_id ORDER BY testimonio_puntaje ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(testimonio_id) FROM testimonio";
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
                <th>Cliente</th>
                <th>Testimonio</th>
                <th>Puntaje</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

';

if($total>=1 && $pagina <= $Npaginas){
    
    $contador = $inicio+1;//contador de usuarios
    $pag_inicio=$inicio+1;//ej: mostrando usuario 1 al 7

    foreach($datos as $row){
        
        $tabla.='
            <tr class="text-center align-middle">
                <td>'.$contador.'</td>
                <td>'.$row["cliente_nombre"].' '. $row["cliente_apellido"].'</td>
                <td><textarea class="w-100" readonly>'.$row["testimonio_desc"].'</textarea></td>
                <td>'.$row["testimonio_puntaje"].'</td>
                <td>
                <form action="./php/sugerencia_eliminar.php" method="POST" class="confirmarDelete">
                    <input type="hidden" name="eliminar" value="'.$row["testimonio_id"].'">
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
            <td colspan="5">
                <a href="'.$url.'1" class="btn btn-primary"">
                    Haga clic para recargar el listado
                </a>
            </td>
        </tr> 
        ';
    } else {
        $tabla.='
            <tr class="text-center" >
            <td colspan="5">
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
        <p class="text-end">Mostrando testimonios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}