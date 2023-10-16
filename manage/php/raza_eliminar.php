<?php
require("main.php");
$raza_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_raza = con();
$check_raza=$check_raza->query("SELECT * FROM mascota_raza WHERE mascota_raza_id = '$raza_id_del'");

if($check_raza->rowCount()==1){
    $datos = $check_raza->fetch();

    $eliminar_raza = con();
    $eliminar_raza=$eliminar_raza->prepare("DELETE FROM mascota_raza WHERE mascota_raza_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_raza->execute([":id"=> $raza_id_del]);
    if($eliminar_raza->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Raza eliminada!</strong><br>
            La Raza ha sido eliminada exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar la Raza, inténtelo nuevamente.
        </div>';
    }
    $eliminar_raza=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La raza que intenta eliminar no existe.
    </div>';
}

$check_raza=null;