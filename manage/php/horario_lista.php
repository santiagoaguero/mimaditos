<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por horario
    $consulta_datos = "SELECT * FROM horario WHERE horario_fin LIKE '%$busqueda%' ORDER BY horario_fin ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(horario_id) FROM horario WHERE horario_fin LIKE '%$busqueda%'";

} else {//busqueda total servicios
    $consulta_datos = "SELECT * FROM horario ORDER BY horario_posicion ASC";

     $consulta_total = "SELECT COUNT(horario_id) FROM horario";
}

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();


$tabla.='
        <div class="table-responsive-md">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Fin</th>
                    <th scope="col" colspan="2">Opciones</th>
                </tr>
                </thead>
            <tbody>
';
            foreach($datos as $row){
                $tabla.='
                    <tr>
                        <th scope="row">'.$row["horario_posicion"].'</th>
                        <td>'.$row["horario_inicio"].'</td>
                        <td>'.$row["horario_fin"].'</td>
                        <td>
                            <a href="index.php?vista=horario_update&horario_id_upd='.$row["horario_id"].'" class="btn btn-primary">Actualizar</a>
                        </td>
                        <td>
                            <form action="./php/horario_eliminar.php" method="POST" class="confirmarDelete">
                                <input type="hidden" name="eliminar" value="'.$row["horario_id"].'">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ';
            }

            $tabla.='
            </tbody>
        </table>
        </div>';
$conexion=null;
echo $tabla;

//<a href="'.$url.$pagina.'&horario_id_del='.$row["horario_id"].'" class="btn btn-danger">Eliminar</a>