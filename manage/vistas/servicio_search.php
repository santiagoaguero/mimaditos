<?php // Verificar los permisos del usuario para esta página
	include("./inc/check_rol.php");
	if (isset($_SESSION['rol']) && isset($_GET['vista'])) {
		$vistaSolicitada = $_GET['vista'];
		$rolUsuario = $_SESSION['rol'];
	
		check_rol($vistaSolicitada, $rolUsuario);
		
	} else {
        header("Location: login.php");
        exit();
    }
?>
<div class="container-fluid mb-6">
	<h1 class="title">Servicios</h1>
	<h2 class="subtitle">Buscar Servicio</h2>
</div>

<div class="forms">
<?php 
    require_once("./php/main.php");

    if(isset($_POST["modulo_buscador"])){
        require_once("./php/buscador.php");

    }

    if(!isset($_SESSION["busqueda_servicio"]) && empty($_SESSION["busqueda_servicio"]) ){


?>

    <div class="text-center">
        <form action="" method="POST" autocomplete="off" data-form-id="servicioSearch" >
            <input type="hidden" name="modulo_buscador" value="servicio">
                <div class="">
                    <p class="control">
                        <input class="form-control" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" autofocus >
                    </p>
                    <p class="control">
                        <button class="btn btn-primary col-md-2" type="submit" >Buscar</button>
                    </p>
                </div>
            
        </form>
    </div>
    <?php   
        } else { 
    ?>
    <div class="text-center">
        <form action="" method="POST" autocomplete="off" >
            <input type="hidden" name="modulo_buscador" value="servicio"> 
            <input type="hidden" name="eliminar_buscador" value="sevicio">
            <p>Estas buscando <strong><?php echo $_SESSION["busqueda_servicio"]; ?></strong></p>
            <button type="submit" class="btn btn-danger mb-3">Eliminar búsqueda</button>
        </form>
    </div>
    <?php
    
        if(isset($_GET["servicio_id_del"])){
            require_once("./php/servicio_eliminar.php");
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
        $url= "index.php?vista=servicio_search&page=";
        $registros=10;//cantidad de registros por pagina
        $busqueda=$_SESSION['busqueda_servicio'];//de usuarios

        require_once("./php/servicio_lista.php");

        }//line 33
    ?>

</div>