<?php
include_once("main.php");

//ya que se utilizan varias llamadas a con() esto puede generar una nueva instancia de pdo
//por lo que aseguramos que se use siempre la misma y no genere errores en las inserciones
$pdo = con();

//almacenando datos
$nombre=limpiar_cadena($_POST["nombre"]);
$apellido=limpiar_cadena($_POST["apellido"]);
$telefono=limpiar_cadena($_POST["telefono"]);
$ciudad=limpiar_cadena($_POST["ciudad"]);
$direccion=limpiar_cadena($_POST["direccion"]);
$mascota=limpiar_cadena($_POST["mascota"]);
$tipo=(int)limpiar_cadena($_POST["tipo"]);
$sexo=limpiar_cadena($_POST["sexo"]);
$edad=(int)limpiar_cadena($_POST["edad"]);
$tamaño=(int)limpiar_cadena($_POST["tamaño"]);
$email=limpiar_cadena($_POST["email"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);

$crea_cliente = false;
$crea_mascota = false;

//verifica campos obligatorios
if($nombre == "" || $apellido == "" || $telefono == "" || $contraseña == "" || $contraseña2 == ""){
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
        El NOMBRE no coincide con el formato esperado.
    </div>';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}",$apellido)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El APELLIDO no coincide con el formato esperado.
    </div>';
    exit();
}
if(verificar_datos("[0-9]{1,11}",$edad)){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La edad de tu mimadito no coincide con el formato esperado.
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

//verifica email
if($email != ""){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email=con();
        $check_email=$check_email->query("SELECT cliente_email FROM cliente 
        WHERE cliente_email = '$email'");//checks if email exists
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

if($tipo=="0" || $tipo > 4){
    $tipo = "4";//asegurar siempre que sea 'Otro/Sin Especificar'
}

if($sexo != "Macho" && $sexo  != "Hembra"){
    $sexo = "Sin especificar";
}

if($tamaño=="0" || $tamaño > 4){
    $tamaño = "2";//asegurar siempre que sea 'Mediano'
}

//guardando datos
$guardar_cliente_query = $pdo->prepare("INSERT INTO
    cliente(cliente_nombre, cliente_apellido, cliente_clave, cliente_email, cliente_telefono, cliente_direccion, cliente_ciudad, rol_id, cliente_estado)
    VALUES(:nombre, :apellido, :clave, :email, :telefono, :direccion, :ciudad, :rol, :estado)");

//evitando inyecciones sql xss
$marcadores=[
    ":nombre"=>$nombre, ":apellido"=>$apellido, ":clave"=>$contraseña, ":email"=>$email, ":telefono"=>$telefono, ":direccion"=>$direccion, ":ciudad"=>$ciudad, ":rol"=> 4, ":estado"=> 1];

$guardar_cliente_query->execute($marcadores);

if($guardar_cliente_query->rowCount()==1){// 1 usuario nuevo insertado

        // Obtener el último ID insertado
        $cliente_id = $pdo->lastInsertId();

        //variables de sesion
        $_SESSION["id"]=$cliente_id;
        $_SESSION["rol"]=4;
        $_SESSION["nombre"]=$nombre;
        $_SESSION["apellido"]=$apellido;
        $_SESSION["email"]=$email;
        $_SESSION["cuenta"]="local";
        $_SESSION["signup"]= true;// para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url

        $crea_cliente = true;

    // inserta la mascota asociada al cliente
    $guardar_mascota_query = $pdo->prepare("INSERT INTO mascota (mascota_nombre, mascota_tipo_id, mascota_sexo, mascota_raza_id, mascota_edad, cliente_id, mascota_tamano_id, mascota_notas, mascota_estado) VALUES (:mascota, :tipo, :sexo, :raza, :edad, :cliente, :tamano, :notas, :estado)");
						
    $marcadores_mascota = [
        ":mascota" => $mascota,
        ":tipo" => $tipo,
        ":sexo" => $sexo,
        ":raza" => 9,//9->sin especificar
        ":edad" => $edad,
        ":cliente" => $cliente_id,
        ":tamano" => $tamaño,
        ":notas" => "",
        ":estado" => "on"
    ];

    $guardar_mascota_query->execute($marcadores_mascota);

    // Verifica si se ha insertado la mascota
    if ($guardar_mascota_query->rowCount() == 1) {

        $_SESSION["crea_mascota"]= true;//

        $crea_mascota = true;

        //header("Location: index.php?vista=signup_exito");

    } else {

        $_SESSION["crea_mascota"]= false;// se creó el cliente pero no su mascota

        $crea_mascota = false;
        //header("Location: index.php?vista=signup_error2");
    }

} else {

    $_SESSION["signup"]= false;//para validar que solo los que crean una cuenta nueva puedan ver el mensaje de exito o error y no cualquiera que ingrese la url

}

$guardar_cliente_query = null;
/*
Para obtener el último ID insertado después de una inserción en PDO se hace sobre el objeto PDO original, no sobre la variable $guardar_cliente sobreescrita con una instancia de PDOStatement*/


if($crea_cliente){//crea cliente
    if($crea_mascota){//crea mascota
        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=signup_exito"
            </script>
            ';
        } else {
            header("Location: index.php?vista=signup_exito");
        }
    } else {// no crea mascota
        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=signup_error2"
            </script>
            ';
        } else {
            header("Location: index.php?vista=signup_error2");
        }
    }
} else {// no crea cliente
    if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
        echo '
        <script>
            window.location.href="index.php?vista=signup_error"
        </script>
        ';
    } else {
        header("Location: index.php?vista=signup_error");
    }
};