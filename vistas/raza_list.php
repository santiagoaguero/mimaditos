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
	<h1 class="title">Razas de Mimaditos</h1>
	<h2 class="subtitle">Lista de Razas</h2>
</div>

<div class="forms">

	<div class="form-rest mb-6 mt-6"></div>
    <?php 
        require_once("./php/main.php");
        
        if(!isset($_GET["page"])){
            $pagina = 1;
        } else {
            $pagina = (int)$_GET["page"];
            if($pagina<=1){
                $pagina = 1;//controlar que siempre sea 1
            }
        }

        $pagina = limpiar_cadena($pagina);
        $url= "index.php?vista=raza_list&page=";
        $registros=5;//cantidad de registros por pagina
        $busqueda="";//de horario
        require_once("./php/raza_lista.php");

    ?>

</div>