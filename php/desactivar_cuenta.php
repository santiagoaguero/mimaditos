<?php
require_once("main.php");
require_once("../inc/session_start.php");

$pdo = con();

//almacenando datos
$id=limpiar_cadena($_POST["user"]);
$contraseña=limpiar_cadena($_POST["contraseña"]);
$contraseña2=limpiar_cadena($_POST["contraseña2"]);

/*verificar que el input hidden no se haya manipulado
if($cliente != $_SESSION["id"]){
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No podemos eliminar esta cuenta.
    </div>';
    exit();
}
*/

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

//coincide pass bd
if (password_verify($contraseña, $datos["cliente_clave"])) {

    //verifica mascotas
    $verifica_mascota = $pdo->query("SELECT * from mascota WHERE 
        cliente_id = '".$datos["cliente_id"]."'");

    if($verifica_mascota->rowCount() >= 1){
        $mascotas = $verifica_mascota->fetchAll();

        print_r($mascotas);

        //copiar primero el cliente para generar el id que se asociará a las mascotas

        //guardando datos incluido id viejo
        $copiar_cliente = $pdo->prepare("INSERT INTO
        cliente_eliminado(cliente_nombre, cliente_apellido, cliente_id, cliente_email, cliente_telefono, cliente_direccion, cliente_ciudad, rol_id, cliente_estado)
        VALUES(:nombre, :apellido, :id, :email, :telefono, :direccion, :ciudad, :rol, :estado)");

        //evitando inyecciones sql xss
        $marcadores=[
        ":nombre"=>$datos["cliente_nombre"], ":apellido"=>$datos["cliente_apellido"], ":id"=>$datos["cliente_id"], ":email"=>$datos["cliente_email"], ":telefono"=>$datos["cliente_telefono"], ":direccion"=>$datos["cliente_direccion"], ":ciudad"=>$datos["cliente_ciudad"], ":rol"=>$datos["rol_id"], ":estado"=> 0];

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
                            window.location.href="../index.php?vista=logout"
                        </script>
                        ';
                    } else {
                        header("Location: ../index.php?vista=logout");
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
                    window.location.href="../index.php?vista=logout"
                </script>
                ';
            } else {
                header("Location: ../index.php?vista=logout");
            }
        }
        $eliminar_cliente = null;
    }
    $verifica_mascota = null;

} else {
    echo '
    <div class="alert alert-danger" role="alert">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La contraseña no coincide con esta cuenta.
    </div>';
    exit();
}