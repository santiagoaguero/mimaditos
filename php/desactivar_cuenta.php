<?php
require_once("main.php");
require_once("./inc/session_start.php");

$pdo = con();

$id=limpiar_cadena($_POST["user"]);
$gid=limpiar_cadena($_POST["gid"]);

//almacenando datos
if($_SESSION["cuenta"] == 'local'){
    $contraseña=limpiar_cadena($_POST["contraseña"]);
    $contraseña2=limpiar_cadena($_POST["contraseña2"]);
    //confirmar que el usuario google es de google por su google id
    if($gid == 'off'){

        //verificar que el input hidden no se haya manipulado
        if($id != $_SESSION["id"]){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No podemos eliminar esta cuenta.
            </div>';
            exit();
        }

        //verifica campos obligatorios
        if($contraseña == "" || $contraseña2 == ""){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>';
            exit();
        }

        //claves coincidan
        if($contraseña != "" || $contraseña2 != ""){
            if(verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña) || verificar_datos("[a-zA-Z0-9$@.-]{6,100}",$contraseña2) ){
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
                }
            }
        }

        //verificar en bd
        $check_cliente = $pdo->query("SELECT * FROM cliente WHERE cliente_id = '$id'");

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


        //coincide pass bd
        if (!password_verify($contraseña, $datos["cliente_clave"])) {
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La contraseña no coincide con esta cuenta.
            </div>';
            exit();
        }

        
    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No pudimos validar la cuenta.
        </div>';
        exit();
    }
}
else if($_SESSION["cuenta"] == 'google'){
    $email=limpiar_cadena($_POST["email"]);
    $email2=limpiar_cadena($_POST["email2"]);
    //confirmar que el usuario google es de google por su google id
    if($gid == 'on'){

        //verificar que el input hidden no se haya manipulado
        if($id != $_SESSION["id"]){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No podemos eliminar esta cuenta.
            </div>';
            exit();
        }

        if($email == "" || $email2 == ""){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>';
            exit();
        }

        if($email != $email2){
            echo '
            <div class="alert alert-danger" role="alert">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Los correos no coinciden.
            </div>';
            exit();
        }

        $g = $_SESSION["gid"];
        //verifica email
        if($email != ""){
            if(filter_var($email, FILTER_VALIDATE_EMAIL) || filter_var($email2, FILTER_VALIDATE_EMAIL) ){
                $check_email=con();
                $check_email=$check_email->query("SELECT cliente_email FROM cliente 
                WHERE cliente_email = '$email' AND google_id = '$g'");//checks if email exists
                if($check_email->rowCount()==0){//email not found
                    echo '
                    <div class="alert alert-danger" role="alert">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        No pudimos validar tu correo.
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

        //verificar en bd
        $check_cliente = $pdo->query("SELECT * FROM cliente WHERE cliente_id = '$id'");

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
    } else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No pudimos validar la cuenta.
    </div>';
    exit();
    }
}

//verifica reservas
$verifica_reservas = $pdo->query("SELECT turno_id, reserva_id from reserva WHERE 
    cliente_id = '".$datos["cliente_id"]."'");

if($verifica_reservas->rowCount() >= 1){
    $reservas = $verifica_reservas->fetchAll();

    foreach($reservas as $res){

        //elimina detalle reserva
        $eliminar_detalle = $pdo->prepare("DELETE FROM reserva_detalle WHERE reserva_id = :id");
        $marcadores = [
            ":id" => $res["reserva_id"]
        ];

        $eliminar_detalle->execute($marcadores);

        //elimina cabecera detalle
        if ($eliminar_detalle->rowCount() == 1){
            $eliminar_reserva = $pdo->prepare("DELETE FROM reserva WHERE reserva_id = :id");            
            $marcadores = [
                ":id" => $res["reserva_id"]
            ];

            $eliminar_reserva->execute($marcadores);

            $eliminar_reserva = null;
        }

        //vuelve a habilitar turno
        $habilita_turno = $pdo->prepare("UPDATE turno SET turno_estado = 0 WHERE turno_id = :id");
        $marcadores = [
            ":id" => $res["turno_id"]
        ];

        $habilita_turno->execute($marcadores);

        $habilita_turno = null;
    }
$eliminar_detalle = null;
}
$verifica_reservas=null;


//verifica mascotas
$verifica_mascota = $pdo->query("SELECT * from mascota WHERE 
    cliente_id = '".$datos["cliente_id"]."'");

if($verifica_mascota->rowCount() >= 1){
    $mascotas = $verifica_mascota->fetchAll();

    //copiar primero el cliente para generar el id que se asociará a las mascotas

    //guardando datos incluido id viejo
    $copiar_cliente = $pdo->prepare("INSERT INTO
    cliente_eliminado(cliente_nombre, cliente_apellido, cliente_id, google_id, cliente_email, cliente_telefono, cliente_direccion, cliente_ciudad, rol_id, cliente_estado)
    VALUES(:nombre, :apellido, :id, :gid, :email, :telefono, :direccion, :ciudad, :rol, :estado)");

    //evitando inyecciones sql xss
    $marcadores=[
    ":nombre"=>$datos["cliente_nombre"], ":apellido"=>$datos["cliente_apellido"], ":id"=>$datos["cliente_id"], ":gid"=>$datos["google_id"], ":email"=>$datos["cliente_email"], ":telefono"=>$datos["cliente_telefono"], ":direccion"=>$datos["cliente_direccion"], ":ciudad"=>$datos["cliente_ciudad"], ":rol"=>$datos["rol_id"], ":estado"=> 0];

    $copiar_cliente->execute($marcadores);

    if($copiar_cliente->rowCount()==1){// 1 usuario nuevo insertado

        // Obtener el último ID insertado
        $copiar_cliente_id = $pdo->lastInsertId();

        //si tiene 1 o mas mascotas se copia todo
        foreach($mascotas as $mascota){
            // inserta la mascota asociada al cliente
            $copiar_mascota = $pdo->prepare("INSERT INTO mascota_eliminado (mascota_nombre, cliente_eliminado_id, mascota_tipo_id, mascota_sexo, mascota_raza_id, mascota_edad, cliente_id_old, mascota_id_old, mascota_tamano_id, mascota_notas, mascota_estado) VALUES (:mascota, :c_id_new, :tipo, :sexo, :raza, :edad, :c_id_old, :m_id_old, :tamano, :notas, :estado)");
                                
            $marcadores_mascota = [
                ":mascota" => $mascota["mascota_nombre"],
                ":c_id_new" => $copiar_cliente_id,
                ":tipo" => $mascota["mascota_tipo_id"],
                ":sexo" => $mascota["mascota_sexo"],
                ":raza" => $mascota["mascota_raza_id"],
                ":edad" => $mascota["mascota_edad"],
                ":c_id_old" => $mascota["cliente_id"],
                ":m_id_old" => $mascota["mascota_id"],
                ":tamano" => $mascota["mascota_tamano_id"],
                ":notas" => $mascota["mascota_notas"],
                ":estado" => "off"
            ];

            $copiar_mascota->execute($marcadores_mascota);

        }
        //eliminar mascotas y cliente
        $eliminar_mascota = $pdo->prepare("DELETE FROM mascota WHERE cliente_id = :id");
        $marcadores = [
            ":id" => $datos["cliente_id"],
        ];

        $eliminar_mascota->execute($marcadores);
        if ($eliminar_mascota->rowCount() >= 1){
            $eliminar_cliente = $pdo->prepare("DELETE FROM cliente WHERE cliente_id = :id");            
            $marcadores = [
                ":id" => $datos["cliente_id"],
            ];

            $eliminar_cliente->execute($marcadores);

            if ($eliminar_cliente->rowCount() == 1){
                if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
                    echo '
                    <script>
                        window.location.href="index.php?vista=logout"
                    </script>
                    ';
                } else {
                    header("Location: index.php?vista=logout");
                }
            }
            $eliminar_cliente = null;

        }
        $eliminar_mascota = null;
    } else {
        echo 'no se pudo insertar el cliente eliminado';
    }

} else {//elimina directo si no tiene mascotas
    $eliminar_cliente = $pdo->prepare("DELETE FROM cliente WHERE cliente_id = :id");
                    
    $marcadores = [
        ":id" => $datos["cliente_id"],
    ];

    $eliminar_cliente->execute($marcadores);

    if ($eliminar_cliente->rowCount() == 1){

        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=logout"
            </script>
            ';
        } else {
            header("Location:index.php?vista=logout");
        }
        
    }
    $eliminar_cliente = null;
}
$verifica_mascota = null;

