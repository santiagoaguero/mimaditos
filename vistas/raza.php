<div class="container-fluid mb-6">
	<h1 class="title">Razas de Mimaditos</h1>
	<h2 class="subtitle">Nueva Raza</h2>
</div>

<div class="forms">

    <form action="./php/raza_guardar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >

	    <div class="form-rest mb-6 mt-6"></div>

        <div class="form-floating">
            <input type="text" class="form-control" id="floatingNombre" name="raza" placeholder="servicio" title="Raza de Mimadito" pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$" required>
            <label for="floatingNombre">Raza</label>
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>