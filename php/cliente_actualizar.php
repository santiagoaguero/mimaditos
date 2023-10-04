<?php
require_once("main.php");

$id = limpiar_cadena($_POST["cliente_id"]);//input hidden

//verificar en bd
$check_cliente = con();
$check_cliente = $check_cliente->query("SELECT * FROM cliente WHERE cliente_id = '$id'");

if($check_cliente->rowCount()<=0){//no existe id
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se encontró el cliente.
    </div>';
    exit();
} else {
    $datos = $check_cliente->fetch();
}
$check_cliente=null;

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$ciudad=limpiar_cadena($_POST["ciudad"]);
$direccion=limpiar_cadena($_POST["direccion"]);
$email=limpiar_cadena($_POST["email"]);

$contraseña = $datos["cliente_clave"];//si no actualiza mantiene su misma clave

//verifica campos obligatorios
if($nombre == "" || $apellido == "" || $telefono == "" || $email == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ. ]{3,40}",$nombre)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Nombre del Cliente no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[0-9- ]{6,100}",$telefono)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Teléfono del Cliente no coincide con el formato esperado.<br>
        Se aceptan mínimo 6 dígitos, espacios y guión medio (-)
    </div>';
    exit();
}


//verifica email
if($email != "" && $email != $datos["cliente_email"]){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=con();
        $check_email=$check_email->query("SELECT cliente_email FROM cliente 
        WHERE cliente_email = '$email'");//checks if email exists
        if($check_email->rowCount()>0){//email found and emails gotta be unique
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El email del Cliente ya está registrado en la base de datos, por favor elija otro email.
            </div>';
            exit();
        }
        $check_email=null;//close db connection
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El email del Cliente no coincide con el formato esperado.
        </div>';
        exit();
    }
}

//Actualizando datos
$actualizar_cliente = con();
$actualizar_cliente = $actualizar_cliente->prepare("UPDATE cliente SET 
cliente_nombre = :nombre, cliente_apellido = :apellido, cliente_clave = :clave, cliente_email = :email, cliente_telefono = :telefono, cliente_direccion = :direccion, cliente_ciudad = :ciudad, rol_id = :rol, cliente_estado = :estado WHERE cliente_id = :id");

//evitando inyecciones sql xss
$marcadores=[
    ":nombre"=>$nombre, ":apellido"=>$apellido, ":clave"=>$contraseña, 
    ":email"=>$email, ":telefono"=>$telefono, ":direccion"=>$direccion, 
    ":ciudad"=>$ciudad, ":rol"=> 4, ":estado"=> 1, "id" => $id];

if($actualizar_cliente->execute($marcadores)){
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Cliente actualizado!</strong><br>
        El Cliente se actualizó exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo actualizar el Cliente, inténtelo nuevamente.
    </div>';   
}

$actualizar_cliente=null;