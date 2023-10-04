<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;

$tabla = "";

$campos = "cliente.cliente_id, cliente.cliente_nombre, cliente.cliente_apellido, cliente.cliente_telefono, cliente.cliente_ciudad, mascota.mascota_id, mascota.mascota_nombre";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre cliente telefono
    $consulta_datos = "SELECT $campos FROM cliente INNER JOIN mascota ON cliente.cliente_id = mascota.mascota_id WHERE cliente.cliente_nombre LIKE '%$busqueda%' OR cliente.cliente_telefono LIKE '%$busqueda%' ORDER BY cliente.cliente_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(cliente_id) FROM cliente WHERE cliente_nombre LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%'";
}

else {//busqueda total productos
    $consulta_datos = "SELECT $campos FROM cliente INNER JOIN mascota ON cliente.cliente_id = mascota.mascota_id ORDER BY cliente.cliente_nombre ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(cliente_id) FROM cliente";
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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Mimadito</th>
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
                <td>'.$row["cliente_nombre"].'</td>
                <td>'.$row["cliente_apellido"].'</td>
                <td>'.$row["cliente_telefono"].'</td>
                <td>'.$row["cliente_ciudad"].'</td>
                <td>'.$row["mascota_nombre"].'</td>
                <td>
                    <a href="index.php?vista=cliente_update&cliente_id_upd='.$row["cliente_id"].'" class="btn btn-outline-primary">Ver Cliente</a>
                </td>
                <td>
                    <a href="index.php?vista=mascota_update&mascota_id='.$row["mascota_id"].'&user_id='.$row["cliente_id"].'" class="btn btn-outline-primary">Ver Mimadito</a>
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
            <td colspan="7">
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
        <p class="text-end">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}