<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM empleado INNER JOIN rol ON empleado.rol_id = rol.rol_id WHERE empleado_nombre LIKE '%$busqueda%' OR empleado_apellido LIKE '%$busqueda%' ORDER BY empleado_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(empleado_id) FROM empleado INNER JOIN rol ON empleado.rol_id = rol.rol_id WHERE empleado_nombre LIKE '%$busqueda%' OR empleado_apellido LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT * FROM empleado INNER JOIN rol ON empleado.rol_id = rol.rol_id ORDER BY empleado_nombre ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(empleado_id) FROM empleado";
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
                <th>Usuario</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Rol</th>
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
                <td>'.$row["empleado_nombre"].'</td>
                <td>'.$row["empleado_apellido"].'</td>
                <td>'.$row["empleado_usuario"].'</td>
                <td>'.$row["empleado_email"].'</td>
                <td>'.$row["empleado_telefono"].'</td>
                <td>'.$row["rol_nombre"].'</td>
                '; if( $row["empleado_estado"] == 1){
                        $tabla.='
                    <td>
                        <button type="button" class="btn btn-outline-success" disabled>Activo</button>
                    </td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_upd='.$row["empleado_id"].'" class="btn btn-primary">Actualizar</a>
                    </td>
                    <td>
                        <form action="./php/usuario_eliminar.php" method="POST" class="confirmarDelete">
                            <input type="hidden" name="eliminar" value="'.$row["empleado_id"].'">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                        ';
                }   else {
                        $tabla.='
                    <td>
                        <button type="button" class="btn btn-outline-secondary" disabled>Inactivo</button>
                    </td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_upd='.$row["empleado_id"].'" class="btn btn-primary">Actualizar</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger" disabled>Inactivo</button>
                    </td>
                        
                        ';
                }
                 $tabla.='
            </tr>
        ';
        $contador++;
    }
    $pag_final=$contador-1;//ej: mostrando usuario 1 al 7
} else {
    if($total>=1){//si introduce una pagina no existente te muestra boton para llevarte a la pag 1
        $tabla.='
            <tr class="text-center" >
            <td colspan="7">
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
        <p class="text-end">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 2);

}