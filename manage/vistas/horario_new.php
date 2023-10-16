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
	<h1 class="title">Horarios</h1>
	<h2 class="subtitle">Nuevo Horario</h2>
</div>

<div class="forms">

    <form action="./php/horario_guardar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" data-form-id="horarioNew" >

        <div class="form-rest mb-6 mt-6"></div>

        <div class="col-md-4 form-floating">
            <input type="number" class="form-control" id="floatingPos" name="horario_posicion" placeholder="servicio" title="Posición del Horario" pattern="[0-9]{1,11}" required >
            <label for="floatingPos">Posición</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="time" class="form-control" id="floatingNombre" name="horario_inicio" placeholder="servicio" title="Inicio de horario" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required>
            <label for="floatingNombre">Inicio</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="time" class="form-control" id="floatingDuracion" name="horario_fin" placeholder="servicio" title="Fin de Horario" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required>
            <label for="floatingDuracion">Fin</label>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>