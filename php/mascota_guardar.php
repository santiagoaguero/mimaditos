<?php
require_once("main.php");
require_once("../inc/session_start.php");

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$tipo=limpiar_cadena($_POST["tipo"]);
$sexo=limpiar_cadena($_POST["sexo"]);
$raza=limpiar_cadena($_POST["raza"]);
$edad=limpiar_cadena($_POST["edad"]);
$tamaño=limpiar_cadena($_POST["tamaño"]);
$notas=limpiar_cadena($_POST["notas"]);
$cliente=limpiar_cadena($_POST["user"]);

//verificar que el input hidden no se haya manipulado
if($cliente != $_SESSION["id"]){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No podemos añadir su mimadito a otro dueño que no sea usted.
    </div>';
    exit();
}

//verifica cliente exista
$check_cliente=con();
//query: inserta la consulta directo a la bd
$check_cliente=$check_cliente->query("SELECT cliente_id FROM cliente 
WHERE cliente_id = '$cliente'");//checks if cliente exists
if($check_cliente->rowCount()==0){//cliente found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No encontramos al dueño de este mimadito.
    </div>';
    exit();
}
$check_cliente=null;//close db connection

//verifica campos obligatorios
if($nombre == "" || $edad == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$",$nombre)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El nombre de mimadito no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica nombre nuevo sea unico
$check_nombre=con();
//query: inserta la consulta directo a la bd
$check_nombre=$check_nombre->query("SELECT mascota_nombre FROM mascota 
WHERE mascota_nombre = '$nombre' AND cliente_id = '$cliente'");//checks if nombre exists
if($check_nombre->rowCount()>0){//nombre found
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Ya tienes un mimadito registrado con este nombre, por favor elija otro nombre.
    </div>';
    exit();
}
$check_nombre=null;//close db connection


if($sexo != "Macho" && $sexo  != "Hembra"){
    $sexo = "Sin especificar";
}

if($tipo == "" || $tipo== 0){
    $tipo = 4;//sin especificar/otro
}

if($tamaño == "" || $tamaño == 0){
    $tamaño = 5;//sin especificar/otro
}

if($raza == "" || $raza == 0){
    $raza = 9;//sin especificar/otro
}


//verifica integridad de los datos
if(verificar_datos("[0-9]{1,11}",$edad)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La edad no coincide con el formato esperado.<br>
        Solo se aceptan números.
    </div>';
    exit();
}

if($notas != ""){//al no ser obligatorio puede venir vacio
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}",$notas)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La descripción no coincide con el formato esperado.
        </div>';
        exit();
    }
}




//guardando datos
$guardar_mascota = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_mascota = $guardar_mascota->prepare("INSERT INTO
    mascota(mascota_nombre, mascota_tipo_id, mascota_sexo, mascota_raza_id, mascota_edad, cliente_id, mascota_tamano_id, mascota_notas, mascota_estado)
    VALUES(:nombre, :tipo, :sexo, :raza, :edad, :cliente, :tamano, :notas, :estado)");

//evitando inyecciones sql xss
$marcadores=[":nombre"=>$nombre, ":tipo"=> $tipo, ":sexo"=> $sexo, ":raza"=>$raza, ":edad"=> $edad, ":cliente"=>$cliente, ":tamano"=> $tamaño, ":notas"=>$notas, ":estado"=> 'on'];
$guardar_mascota->execute($marcadores);

if($guardar_mascota->rowCount()==1){// 1 prov nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Mimadito registrado!</strong><br>
        El nuevo mimadito se registró exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo registrar el mimadito, inténtelo nuevamente.
    </div>';
}
$guardar_mascota=null; //cerrar conexion;