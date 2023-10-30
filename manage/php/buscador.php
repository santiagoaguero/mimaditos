<?php
    $modulo_buscador = limpiar_cadena($_POST["modulo_buscador"]);

    $modulos=["servicio", "perfil", "cliente", "mascota"];

    if(in_array($modulo_buscador, $modulos)){

        $modulos_url=[
            "servicio"=>"servicio_search",
            "perfil"=>"perfil",
            "cliente"=>"cliente_search",
            "mascota"=>"mascota_search"
        ];

        $modulos_url=$modulos_url[$modulo_buscador];

        $modulo_buscador="busqueda_".$modulo_buscador;


        //iniciar busqueda
        if(isset($_POST["txt_buscador"])){

            $txt=limpiar_cadena($_POST["txt_buscador"]);
            
            if($txt == ""){
                echo '
                <div class="alert alert-danger" role="alert">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Introduzca un termino de búsqueda.
                </div>
                ';
            } else {
                if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}", $txt)){//true encontró errores
                    echo '
                    <div class="alert alert-danger" role="alert">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        Término de búsqueda no coincide con el formato esperado.
                    </div>
                    ';
                } else {
                    $_SESSION[$modulo_buscador]=$txt;
                    
                    echo'
                    <script>
                        window.location="index.php?vista='.$modulos_url.'"
                    </script>
                    ';
                    exit();
                }
            }
        }

        //eliminar busqueda
        if(isset($_POST["eliminar_buscador"])){
            unset($_SESSION[$modulo_buscador]);
            echo'
            <script>
                window.location="index.php?vista='.$modulos_url.'"
            </script>
            ';
            exit();
        }

    } else {
        echo '
        <div class="alert alert-danger" role="alert">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo procesar la operación.
        </div>';
    }