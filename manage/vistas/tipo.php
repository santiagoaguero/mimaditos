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
	<h1 class="title">Tipos de Mimaditos</h1>
	<h2 class="subtitle">Nuevo Tipo</h2>
</div>

<div class="forms">
    <form action="./php/tipo_guardar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >

	<div class="form-rest mb-6 mt-6"></div>

        <div class="form-floating">
            <input type="text" class="form-control" id="floatingNombre" name="tipo" placeholder="servicio" title="Tipo de Mimadito" pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$" required>
            <label for="floatingNombre">Tipo</label>
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>