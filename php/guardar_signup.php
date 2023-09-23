<?php
include_once("main.php");

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$ciudad=limpiar_cadena($_POST["ciudad"]);
$direccion=limpiar_cadena($_POST["direccion"]);
$mascota=limpiar_cadena($_POST["mascota"]);
$tamaño=limpiar_cadena($_POST["tamaño"]);
$email=limpiar_cadena($_POST["email"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);

//verifica campos obligatorios
if($nombre == "" || $apellido == "" || $telefono == "" || $contraseña == "" || $contraseña2 == ""){
    echo '
    <div class="text-bg-danger bg-gradient">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}",$nombre)){
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El NOMBRE no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}",$apellido)){
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El APELLIDO no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica email
if($email != ""){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=con();
        $check_email=$check_email->query("SELECT cliente_email FROM cliente 
        WHERE cliente_email = '$email'");//checks if email exists
        if($check_email->rowCount()>0){//email found and emails gotta be unique
            echo '
            <div class="text-bg-danger bg-gradient">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El email ya está registrado en la base de datos, por favor elija otro email.
            </div>';
            exit();
        }
        $check_email=null;//close db connection
    } else {
        echo '
        <div class="text-bg-danger bg-gradient">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El email no coincide con el formato esperado.
        </div>';
        exit();
    }
}

if(verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña) || verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña2) ){
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        LAS CLAVES no coincide con el formato esperado.
    </div>';
    exit();
}

//claves coinciden
if($contraseña != $contraseña2){
    echo '
    <div class="text-bg-danger bg-gradient">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Las contraseñas no coinciden.
    </div>';
    exit();
} else {
    $contraseña = password_hash($contraseña, PASSWORD_BCRYPT, ["cost"=>10]);
}

//guardando datos
$guardar_cliente = con();
//prepare: prepara la consulta antes de insertar directo a la bd. variables sin comillas ni $
$guardar_cliente = $guardar_cliente->prepare("INSERT INTO
    cliente(cliente_nombre, cliente_apellido, cliente_clave, cliente_email, cliente_telefono, cliente_direccion, cliente_ciudad)
    VALUES(:nombre, :apellido, :clave, :email, :telefono, :direccion, :ciudad)");

//evitando inyecciones sql xss
$marcadores=[
    ":nombre"=>$nombre, ":apellido"=>$apellido, ":clave"=>$contraseña, ":email"=>$email, ":telefono"=>$telefono, ":direccion"=>$direccion, ":ciudad"=>$ciudad];

$guardar_cliente->execute($marcadores);

if($guardar_cliente->rowCount()==1){// 1 usuario nuevo insertado
        echo '
        <div class="notification is-success is-light">
            <strong>Cuenta registrada!</strong><br>
            Su cuenta se creó exitosamente.
        </div>';
    }
 else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo crear su cuenta, intentelo nuevamente.
    </div>';
}
$guardar_cliente=null; //cerrar conexion;