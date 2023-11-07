<?php
require("main.php");
$sugerencia_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_sugerencia = con();
$check_sugerencia=$check_sugerencia->query("SELECT * FROM testimonio WHERE testimonio_id = '$sugerencia_id_del'");

if($check_sugerencia->rowCount()==1){
    $datos = $check_sugerencia->fetch();

    $eliminar_sugerencia = con();
    $eliminar_sugerencia=$eliminar_sugerencia->prepare("DELETE FROM testimonio WHERE testimonio_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_sugerencia->execute([":id"=> $sugerencia_id_del]);
    if($eliminar_sugerencia->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Testimonio eliminado!</strong><br>
            El Testimonio ha sido eliminado exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar el Testimonio, inténtelo nuevamente.
        </div>';
    }
    $eliminar_sugerencia=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Testimonio que intenta eliminar no existe.
    </div>';
}

$check_sugerencia=null;