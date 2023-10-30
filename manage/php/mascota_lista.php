<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;

$tabla = "";

$campos = "mascota.mascota_id, mascota.mascota_nombre, cliente.cliente_id, cliente.cliente_nombre, cliente.cliente_apellido";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre cliente mascota
    $consulta_datos = "SELECT $campos FROM mascota LEFT JOIN cliente ON mascota.cliente_id = cliente.cliente_id WHERE mascota.mascota_nombre LIKE '%$busqueda%' OR cliente.cliente_nombre LIKE '%$busqueda%' OR cliente.cliente_apellido LIKE '%$busqueda%' ORDER BY mascota.mascota_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(mascota_id) FROM mascota WHERE mascota_nombre LIKE '%$busqueda%'";
}

else {//busqueda total productos
    $consulta_datos = "SELECT $campos FROM mascota LEFT JOIN cliente ON mascota.cliente_id = cliente.cliente_id ORDER BY mascota.mascota_nombre ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(mascota_id) FROM mascota";
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
                <th>Mimadito</th>
                <th>Dueño</th>
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
                <td>'.$row["cliente_nombre"].' '.' '.$row["cliente_apellido"].'</td>
                <td>
                    <a href="index.php?vista=mascota_update&mascota_id='.$row["mascota_id"].'&user_id='.$row["cliente_id"].'" class="btn btn-outline-primary">Ver Mimadito</a>
                </td>
                <td>
                    <a href="index.php?vista=cliente_update&cliente_id_upd='.$row["cliente_id"].'" class="btn btn-outline-primary">Ver Cliente</a>
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
        <p class="text-end">Mostrando mimaditos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong> mimaditos</p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}