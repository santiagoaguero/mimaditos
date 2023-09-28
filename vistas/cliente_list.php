<div class="container-fluid mb-6">
	<h1 class="title">Clientes</h1>
	<h2 class="subtitle">Lista de Clientes</h2>
</div>

<div class="forms">

	<div class="form-rest mb-6 mt-6"></div>
    <?php 
        require_once("./php/main.php");

        //ELIMINAR Servicios
        if(isset($_GET["cliente_id_del"])){
            require_once("./php/cliente_eliminar.php");
        }
        
        if(!isset($_GET["page"])){
            $pagina = 1;
        } else {
            $pagina = (int)$_GET["page"];
            if($pagina<=1){
                $pagina = 1;//controlar que siempre sea 1
            }
        }

        $pagina = limpiar_cadena($pagina);
        $url= "index.php?vista=cliente_list&page=";
        $registros=5;//cantidad de registros por pagina
        $busqueda="";//de cliente
        require_once("./php/cliente_lista.php");

    ?>

</div>