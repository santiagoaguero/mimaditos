<div class="container-fluid mb-6">
	<h1 class="title">Tipo de Mimaditos</h1>
	<h2 class="subtitle">Nuevo Tipo</h2>
</div>

<div class="forms">

	<div class="form-rest mb-6 mt-6"></div>

    <form action="./php/tipo_mimadito_guardar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingNombre" name="tipo" placeholder="servicio" title="Tipo de Mimadito" pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$" required>
            <label for="floatingNombre">Tipo</label>
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>