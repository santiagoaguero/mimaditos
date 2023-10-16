<?php
require_once("main.php");

$id = limpiar_cadena($_POST["user"]);//input hidden

//verificar en bd
$check_empleado = con();
$check_empleado = $check_empleado->query("SELECT * FROM empleado WHERE empleado_id = '$id'");

if($check_empleado->rowCount()<=0){//no existe id
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se encontró el Usuario.
    </div>';
    exit();
} else {
    $datos = $check_empleado->fetch();
}
$check_empleado=null;

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$usuario=limpiar_cadena($_POST["usuario"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$rol=limpiar_cadena($_POST["rol"]);
$email=limpiar_cadena($_POST["email"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);

//checkbox no marcados no se envian en el form
//se verifica para darle un valor y poder guardar
$estado = isset($_POST["estado"]) ? 
    (limpiar_cadena($_POST["estado"])) : 0;

//verifica campos obligatorios
if($nombre == "" || $apellido == "" || $usuario == "" || $telefono == "" || $email == "" || $rol == ""){
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
        El Nombre no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[0-9- ]{6,100}",$telefono)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Teléfono no coincide con el formato esperado.<br>
        Se aceptan mínimo 6 dígitos, espacios y guión medio (-)
    </div>';
    exit();
}

//claves coincidan
if($contraseña != "" || $contraseña2 != ""){
    if(verificar_datos("^[a-zA-Z0-9$@.\-]{6,100}$",$contraseña) || verificar_datos("^[a-zA-Z0-9$@.\-]{6,100}$",$contraseña2) ){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Las contraseñas no coinciden con el formato esperado.
        </div>';
        exit();
    } else {
        if($contraseña != $contraseña2){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Las contraseñas no coinciden.
            </div>';
            exit();
        } else {
            $contraseña = password_hash($contraseña, PASSWORD_BCRYPT, ["cost"=>10]);
        }
    }
} else {
    $contraseña = $datos["empleado_clave"];//si no actualiza mantiene su misma clave
}

if($rol==0 || $rol > 4){
    $rol = 3;//asegurar siempre que sea 'Empleado' 
}

if($estado == "" && $estado != "on"){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo establecer el estado del Servicio.
    </div>';
    exit();
}

if($estado == 'on'){
    $estado = 1;
}

//verifica user unique
if($usuario != "" && $usuario != $datos["empleado_usuario"]){
    if(verificar_datos("^[a-zA-Z0-9$@._]{4,40}$",$usuario)){
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El Usuario no coincide con el formato esperado.
        </div>';
        exit();
    } else {
        $check_user=con();
        $check_user=$check_user->query("SELECT empleado_usuario FROM empleado 
        WHERE empleado_usuario = '$usuario'");//checks if email exists
        if($check_user->rowCount()>0){//email found and emails gotta be unique
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El Usuario ya está registrado en la base de datos, por favor elija otro usuario.
            </div>';
            exit();
        }
        $check_user=null;//close db connection
    }
}

//verifica email
if($email != "" && $email != $datos["empleado_email"]){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=con();
        $check_email=$check_email->query("SELECT empleado_email FROM empleado 
        WHERE empleado_email = '$email'");//checks if email exists
        if($check_email->rowCount()>0){//email found and emails gotta be unique
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El email ya está registrado en la base de datos, por favor elija otro email.
            </div>';
            exit();
        }
        $check_email=null;//close db connection
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El email no coincide con el formato esperado.
        </div>';
        exit();
    }
}

//Actualizando datos
$actualizar_empleado = con();
$actualizar_empleado = $actualizar_empleado->prepare("UPDATE empleado SET 
empleado_nombre = :nombre, empleado_apellido = :apellido, empleado_usuario = :usuario, empleado_clave = :clave, empleado_email = :email, empleado_telefono = :telefono, rol_id = :rol, empleado_estado = :estado WHERE empleado_id = :id");

//evitando inyecciones sql xss
$marcadores=[
    ":nombre"=>$nombre, ":apellido"=>$apellido, ":usuario"=>$usuario, ":clave"=>$contraseña, 
    ":email"=>$email, ":telefono"=>$telefono, ":rol"=> $rol, ":estado"=> $estado, "id" => $id];

if($actualizar_empleado->execute($marcadores)){
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Usuario actualizado!</strong><br>
        El Usuario se actualizó exitosamente.
    </div>';
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo actualizar el Usuario, inténtelo nuevamente.
    </div>';   
}

$actualizar_empleado=null;