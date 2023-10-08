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
	<h2 class="subtitle">Nuevo Servicio</h2>
</div>

<div class="forms">


    <form action="./php/servicio_guardar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >

	    <div class="form-rest mb-6 mt-6"></div>

        <div class="col-md-4 form-floating">
            <input type="text" class="form-control" id="floatingNombre" name="servicio_nombre" placeholder="servicio" title="Nombre del Servicio a ofrecer" pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$" required>
            <label for="floatingNombre">Nombre</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="number" min="1" class="form-control" id="floatingDuracion" name="servicio_duracion" placeholder="servicio" title="Duración en horas del Servicio a ofrecer, mínimo 1 hora por defecto" value="1" pattern="[0-9]{1,11}" required>
            <label for="floatingDuracion">Duración (hs.)</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="number" min="1" class="form-control" id="floatingPrecio" name="servicio_precio" placeholder="servicio" title="Precio del Servicio a ofrecer en Guaraníes" pattern="[0-9]{1,11}" required>
            <label for="floatingPrecio">Precio Gs.</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="text" class="form-control" id="floatingDescripcion" name="servicio_descripcion" placeholder="servicio" title="Descripción detalla del Servicio a ofrecer" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}">
            <label for="floatingDescripcion">Descripción</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="servicio_disponible" title="Si aún no desea ofrecer este servicio, desmarque para deshabilitar" checked>
            <label class="form-check-label" for="flexSwitchCheckDefault" title="Si aún no desea ofrecer este servicio, desmarque para deshabilitar">Disponible</label>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>