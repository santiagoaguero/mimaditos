<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;

$tabla = "";

$campos = "cliente.cliente_id, cliente.cliente_nombre, cliente.cliente_apellido, cliente.cliente_telefono, cliente.cliente_ciudad, mascota.mascota_id, mascota.mascota_nombre";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre cliente telefono
    $consulta_datos = "SELECT $campos FROM cliente INNER JOIN mascota ON cliente.cliente_id = mascota.mascota_id WHERE cliente.cliente_nombre LIKE '%$busqueda%' OR cliente.cliente_telefono LIKE '%$busqueda%' ORDER BY cliente.cliente_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(cliente_id) FROM cliente WHERE cliente_nombre LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%'";
}

else {//busqueda total productos
    $consulta_datos = "SELECT $campos FROM cliente INNER JOIN mascota ON cliente.cliente_id = mascota.mascota_id ORDER BY cliente.cliente_nombre ASC LIMIT $inicio, $registros";

     $consulta_total = "SELECT COUNT(cliente_id) FROM cliente";
}

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();//fetch una unica columna
//cantidad paginas para mostrar
$Npaginas = ceil($total/$registros);//redonde hacia arriba


if($total>=1 && $pagina <= $Npaginas){
    
    $contador = $inicio+1;//contador de usuarios
    $pag_inicio=$inicio+1;//ej: mostrando usuario 1 al 7

    foreach($datos as $product){
        $precio_entero = number_format($product["producto_precio"], 0, ',', '.');
        $tabla.='
                <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">';
                    if(is_file("./img/productos/".$product["producto_foto"])){
                        $tabla.='
                        <img src="./img/productos/'.$product["producto_foto"].'">
                        ';
                    }else {
                        $tabla.='
                        <img src="./img/productos.png">
                        ';
                    }
            $tabla.='
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>'.$contador.' - '.$product["producto_nombre"].'</strong><br>
                            <strong>COD. BARRA:</strong> '.$product["producto_codigo"].' - 
                            <strong>PRECIO:</strong> ₲s '.$precio_entero.' - ';
                            //stock mayor al doble del minimo 
                            if($product["producto_stock"] < $product["producto_stock_min"]){
                                $tabla.='
                                <div class="notification is-danger is-light">
                                    <button class="delete"></button>
                                    Stock menor al mínimo, se recomienda reabastecer producto.
                                </div>
                                <strong style="color: red">STOCK:</strong> '.$product["producto_stock"].' -
                                <strong>STOCK MIN:</strong> '.$product["producto_stock_min"].' - ';
                            }
                            //stock mayor al minimo + la mitad del minimo
                            elseif(
                                ($product["producto_stock"] >= $product["producto_stock_min"]) &&
                                ($product["producto_stock"] <= ($product["producto_stock_min"] + $product["producto_stock_min"]/2)) ){
                                $tabla.='
                                <strong style="color: orange">STOCK:</strong> '.$product["producto_stock"].' -
                                <strong>STOCK MIN:</strong> '.$product["producto_stock_min"].' -';
                            }
                            //stock <= al minimo
                            else {
                                $tabla.='
                                <strong style="color: limegreen">STOCK:</strong> '.$product["producto_stock"].' -
                                <strong>STOCK MIN:</strong> '.$product["producto_stock_min"].' - ';
                            }

                            $tabla.='
                            <strong>CATEGORIA:</strong> '.$product["categoria_nombre"].' -
                            <strong>FAMILIA:</strong> '.$product["familia_nombre"].' - 
                            <strong>REGISTRADO POR:</strong> '.$product["usuario_nombre"].' '.$product["usuario_apellido"].'
                        </p>
                    </div>
                    <div class="has-text-right">
                        <a href="index.php?vista=product_img&product_id_upd='.$product["producto_id"].'" class="button is-link is-rounded is-small">Imagen</a>
                        <a href="index.php?vista=product_update&product_id_upd='.$product["producto_id"].'" class="button is-success is-rounded is-small">Actualizar</a>
                        <a href="'.$url.$pagina.'&product_id_del='.$product["producto_id"].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </div>
                </div>
            </article>


            <hr>
        ';
        $contador++;
    }
    $pag_final=$contador-1;//ej: mostrando usuario 1 al 7
} else {
    if($total>=1){//si introduce una pagina no existente te muestra boton para llevarte a la pag 1
        $tabla.='
        <p class="has-text-centered">
                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic para recargar el listado
                </a>
</p>
        ';
    } else {
        $tabla.='<p class="has-text-centered">No hay registros en el sistema</p>';
    }
}

if($total>=1 && $pagina <= $Npaginas){
    $tabla.='
        <p class="has-text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }

$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 7);

}