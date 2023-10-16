<?php
include_once("main.php");

//ya que se utilizan varias llamadas a con() esto puede generar una nueva instancia de pdo
//por lo que aseguramos que se use siempre la misma y no genere errores en las inserciones
$pdo = con();

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$usuario=limpiar_cadena($_POST["usuario"]);
$rol=limpiar_cadena($_POST["rol"]);
$email=limpiar_cadena($_POST["email"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);


//verifica campos obligatorios
if($nombre == "" || $apellido == "" || $usuario == "" || $telefono == "" || 
    $contraseña == "" || $contraseña2 == "" || $email == ""){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}",$nombre)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Nombre del Empleado no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}",$apellido)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Apellido del Empleado no coincide con el formato esperado.
    </div>';
    exit();
}

//verifica integridad de los datos
if(verificar_datos("[0-9- ]{6,100}",$telefono)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El Teléfono no coincide con el formato esperado.<br>
        Solo se reciben números, espacios y guión medio (-)
    </div>';
    exit();
}

//verifica user

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

//verifica email
if($email != ""){
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

if(verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña) || verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña2) ){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La contraseña no coincide con el formato esperado.
    </div>';
    exit();
}

//claves coinciden
if($contraseña != $contraseña2){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Las contraseñas no coinciden.
    </div>';
    exit();
} else {
    $contraseña = password_hash($contraseña, PASSWORD_BCRYPT, ["cost"=>10]);
    $contraseña2 = password_hash($contraseña2, PASSWORD_BCRYPT, ["cost"=>10]);
}

if($rol==0 || $rol > 4){
    $rol = 3;//asegurar siempre que sea 'Empleado' 
}


//guardando datos
$guardar_user = $pdo->prepare("INSERT INTO
    empleado(empleado_nombre, empleado_apellido, empleado_usuario, empleado_clave, empleado_email, empleado_telefono, rol_id, empleado_estado)
    VALUES(:nombre, :apellido, :usuario, :clave, :email, :telefono, :rol, :estado)");

//evitando inyecciones sql xss
$marcadores=[
    ":nombre"=>$nombre, ":apellido"=>$apellido, ":usuario"=>$usuario, ":clave"=>$contraseña, ":email"=>$email, ":telefono"=>$telefono, ":rol"=> $rol, ":estado"=> 1];

$guardar_user->execute($marcadores);

if($guardar_user->rowCount()==1){// 1 usuario nuevo insertado
    echo '
    <div class="alert alert-success" role="alert">
        <strong>Usuario registrado!</strong><br>
        El Usuario se registró exitosamente.
    </div>';
    exit();
} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No se pudo crear el Usuario.
    </div>';
    exit();
}
$guardar_user = null;