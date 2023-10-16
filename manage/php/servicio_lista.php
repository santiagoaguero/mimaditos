<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM servicio WHERE servicio_nombre LIKE '%$busqueda%' ORDER BY servicio_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(servicio_id) FROM servicio WHERE servicio_nombre LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT * FROM servicio ORDER BY servicio_nombre ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(servicio_id) FROM servicio";
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
                <th>Descripción</th>
                <th>Duración (hs.)</th>
                <th>Precio Gs.</th>
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
        $precio_entero = number_format($row["servicio_precio"], 0, ',', '.');
        
        $tabla.='
            <tr class="text-center" >
                <td>'.$contador.'</td>
                <td>'.$row["servicio_nombre"].'</td>
                <td>'.$row["servicio_descripcion"].'</td>
                <td>'.$row["servicio_duracion"].'</td>
                <td>'.$precio_entero.'</td>
                <td>
                '; if( $row["servicio_disponible"] == "on"){
                        $tabla.='<button type="button" class="btn btn-outline-success" disabled>Disponible</button>';
                }   else {
                        $tabla.='<button type="button" class="btn btn-outline-secondary" disabled>No Disponible</button>';
                }
                 $tabla.='
                </td>
                <td>
                    <a href="index.php?vista=servicio_update&servicio_id_upd='.$row["servicio_id"].'" class="btn btn-primary">Actualizar</a>
                </td>
                <td>
                <form action="./php/servicio_eliminar.php" method="POST" class="confirmarDelete">
                    <input type="hidden" name="eliminar" value="'.$row["servicio_id"].'">
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
        <p class="text-end">Mostrando servicios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}