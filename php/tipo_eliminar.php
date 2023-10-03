<?php
require("main.php");
$tipo_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_tipo = con();
$check_tipo=$check_tipo->query("SELECT * FROM mascota_tipo WHERE mascota_tipo_id = '$tipo_id_del'");

if($check_tipo->rowCount()==1){
    $datos = $check_tipo->fetch();

    $eliminar_tipo = con();
    $eliminar_tipo=$eliminar_tipo->prepare("DELETE FROM mascota_tipo WHERE mascota_tipo_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_tipo->execute([":id"=> $tipo_id_del]);
    if($eliminar_tipo->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Tipo de Mimadito eliminado!</strong><br>
            El Tipo ha sido eliminado exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar el Tipo, inténtelo nuevamente.
        </div>';
    }
    $eliminar_tipo=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Tipo que intenta eliminar no existe.
    </div>';
}

$check_tipo=null;