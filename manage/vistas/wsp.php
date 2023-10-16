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


<?php 
$tel = '595985697266';

echo '
<a href="https://wa.me/'.$tel.'?text=hola ya podes retirar a tu perrro ok" target="_blank" class="btn btn-success">Retirar Jagua</a>
';