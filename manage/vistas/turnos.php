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


<div class="forms turnos">
    <h1 class="text-center text-secondary my-3">Agregar Turnos</h1>
    <p>Para mostrar nuevos turnos en el calendario debe seleccionar un rango de fechas. <br>
    La Página tomará estas fechas y creará los turnos por cada día seleccionado.<br>
    Se aceptan los rangos:
    <ul>
        <li>Por Día</li>
        <li>Por Semanas</li>
        <li>Por Meses</li>
        <li>Por Año</li>
    </ul>
    </p>
    <p class="text-warning-emphasis text-center">
    <i class="fa-solid fa-triangle-exclamation fa-beat mx-3"></i>No se crearán nuevos turnos si ya existen turnos o reservas en el rango de fechas seleccionado.
    </p>
    <form action="./php/agregar_turnos.php" method="post" class="confirmarReserva row">

    <div class="col-md-6">
        <label for="fechaInicio">Inicio:</label>
        <input id="fechaInicio" type="date" class="form-control" name="inicio" required>
    </div>

    <div class="col-md-6">
        <label for="fechaFin">Fin:</label>
        <input id="fechaFin" type="date" class="form-control" name="fin" required>
    </div>
    <div class="form-rest mb-6 mt-6"></div>
        <button class="btn btn-primary mt-3" type="submit">Crear Turnos</button>
    </form>
</div>



<h1 class="text-center text-secondary">Eliminar Turnos</h1>

<div class="forms turnos">
    <p>Para eliminar turnos en el calendario debe seleccionar un rango de fechas. <br>
    La Página tomará estas fechas y eliminará los turnos por cada día seleccionado.<br>
    Se aceptan los rangos:
    <ul>
        <li>Por Día</li>
        <li>Por Semanas</li>
        <li>Por Meses</li>
        <li>Por Año</li>
    </ul>
    </p>
    <p class="text-danger text-center">
    <i class="fa-regular fa-calendar-xmark fa-beat fa-xs mx-3"></i>No se eliminarán turnos si ya existen reservas pendientes o confirmadas en el rango de fechas seleccionado.
    </p>
    <p class="text-danger-emphasis text-center">
        Para eliminar turnos, primeramente debe cancelar y eliminar cada reserva registrada en el rango de fechas seleccionado.</p>
    <form action="./php/eliminar_turnos.php" method="post" class="confirmarDelete row">

    <div class="col-md-6">
        <label for="fechaInicio">Inicio:</label>
        <input id="fechaInicio" type="date" class="form-control" name="inicio" required>
    </div>

    <div class="col-md-6">
        <label for="fechaFin">Fin:</label>
        <input id="fechaFin" type="date" class="form-control" name="fin" required>
    </div>
    <div class="form-rest mb-6 mt-6"></div>
        <button class="btn btn-outline-danger mt-3" type="submit">Eliminar Turnos</button>

    </form>
</div>