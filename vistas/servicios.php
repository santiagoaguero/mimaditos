<?php
//vista solo para clientes
require_once("./php/main.php");

$consulta_datos = "SELECT * FROM servicio WHERE servicio_disponible = 'on' ORDER BY servicio_nombre ASC";

$tabla = "";
$contador = 1;

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();


$tabla.='
<div class="forms">
    <h3 class="text-center my-3">Nuestros Servicios Disponibles</h3>

    <div class="table-responsive-md">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Duración aprox. (hs.)</th>
                    <th scope="col">Pecio Gs.</th>
                </tr>
            </thead>
            <tbody>
';
            foreach($datos as $row){
                $precio_entero = number_format($row["servicio_precio"], 0, ',', '.');
                $tabla.='
                    <tr>
                        <td>'.$contador.'</th>
                        <td>'.$row["servicio_nombre"].'</td>
                        <td>'.$row["servicio_duracion"].'</td>
                        <td>'.$precio_entero.'</td>
                    </tr>
                ';
                $contador++;
            }

            $tabla.='
            </tbody>
        </table>
    </div>
</div>';
$conexion=null;
echo $tabla;

//<a href="'.$url.$pagina.'&horario_id_del='.$row["horario_id"].'" class="btn btn-danger">Eliminar</a>