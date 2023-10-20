<?php
require_once("main.php");
$puntaje=(int)limpiar_cadena($_POST["puntaje"]);
$sugerencia=limpiar_cadena($_POST["sugerencias"]);
$cliente_id=limpiar_cadena($_POST["user"]);

if($sugerencia != ""){//al no ser obligatorio puede venir vacio
        if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ,.!¡?¿ ]{0,255}",$sugerencia)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La nota no coincide con el formato esperado.
        </div>';
        exit();
    }
}

if(!is_numeric($puntaje)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El puntaje no coincide con el formato esperado.
    </div>';
    exit();
}

if($puntaje < 1 && $puntaje > 5){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Rango de puntaje no permitido.
    </div>';
    exit();
}


//guardando datos
$guardar_sugerencia = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_sugerencia = $guardar_sugerencia->prepare("INSERT INTO
    testimonio(testimonio_desc, testimonio_puntaje, cliente_id)
    VALUES(:sugerencia, :puntaje, :cliente)");

//evitando inyecciones sql xss
$marcadores=[":sugerencia"=>$sugerencia, ":puntaje"=> $puntaje, ":cliente"=> $cliente_id];
$guardar_sugerencia->execute($marcadores);

if($guardar_sugerencia->rowCount()==1){// 1 prov nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Sugerencia registrada!</strong><br>
        Gracias por tus sugerencias, lo tendremos en cuenta :)
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar tu sugerencia, inténtelo nuevamente.
    </div>';
}
$guardar_sugerencia=null; //cerrar conexion;