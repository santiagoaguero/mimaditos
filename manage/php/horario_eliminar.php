<?php
require("main.php");
$horario_id_del = limpiar_cadena($_POST["eliminar"]);

//verifica cliente
$check_horario = con();
$check_horario=$check_horario->query("SELECT * FROM horario WHERE horario_id = '$horario_id_del'");

if($check_horario->rowCount()==1){
    $datos = $check_horario->fetch();

    $eliminar_horario = con();
    $eliminar_horario=$eliminar_horario->prepare("DELETE FROM horario WHERE horario_id=:id");
    //filtro prepare para evitar inyecciones sql xss

    $eliminar_horario->execute([":id"=> $horario_id_del]);
    if($eliminar_horario->rowCount()==1){

        echo '
        <div class="alert alert-success" role="alert">
            <strong>Horario eliminado!</strong><br>
            El Horario ha sido eliminado exitosamente.
        </div>';
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo eliminar el Horario, inténtelo nuevamente.
        </div>';
    }
    $eliminar_horario=null;
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Horario que intenta eliminar no existe.
    </div>';
}

$check_horario=null;