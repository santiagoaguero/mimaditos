<?php
//vista solo para clientes
require_once("./php/main.php");
$consulta_datos = "SELECT * FROM horario ORDER BY horario_posicion ASC";

$consulta_total = "SELECT COUNT(horario_id) FROM horario";

$tabla = "";

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();


$tabla.='

        <h3 class="text-center my-3">Lista de nuestros horarios</h3>

        <div class="table-responsive-md">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Fin</th>
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