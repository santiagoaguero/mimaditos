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
	<h1 class="title">Clientes</h1>
	<h2 class="subtitle">Nuevo Cliente</h2>
</div>

<div class="forms">

    <form class="formularioAjax row g-3 shadow" method="POST" action="./php/cliente_guardar.php" autocomplete="off">
        <h2 class="text-secondary text-center">Información Personal</h2>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required >
            <label for="inputName" class="is-required">Nombre</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required >
            <label for="inputApellido" class="is-required">Apellido</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="text" class="form-control " id="inputUser" name="usuario" placeholder="Nombre" pattern="^[a-zA-Z0-9$@._]{4,40}$" required >
            <label for="inputUser" class="is-required">@ Usuario</label>
            <div id="username-validation-message"></div>
            <div class="col-auto">
                <span id="userHelpInline" class="form-text">
                El @ de usuario debe tener mínimo 4 caracteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ . _ Ej: lionel
                </span>
            </div>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" required >
            <label for="inputTelefono" class="is-required">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputCiudad" name="ciudad" placeholder="Ciudad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{0,40}">
            <label for="inputCiudad">Ciudad</label>
        </div>
        <div class="col-12 form-floating">
            <input type="text" class="form-control" id="inputAddress" name="direccion" placeholder="Direccion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,70}">
            <label for="inputAddress" class="form-label">Dirección</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required >
            <label for="inputEmail4" class="is-required">Email</label>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="^[a-zA-ZñÑ0-9$@.\-]{6,100}$" required>
            <label for="inputPassword" class="form-label is-required">Contraseña</label>
            <div class="col-auto">
                <span id="passwordHelpInline" class="form-text">
                La contraseña debe tener mínimo 6 carácteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ - .
                </span>
            </div>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="^[a-zA-ZñÑ0-9$@.\-]{6,100}$" required>
            <label for="inputPassword2" class="form-label is-required">Confirme su contraseña</label>
        </div>

        <h2 class="text-secondary text-center mt-5">Información de Mimadito</h2>
        <div class="col-md-3 form-floating">
            <input type="text" class="form-control" id="inputMascota" name="mascota" placeholder="Mimadito" required>
            <label for="inputMascota" class="is-required">Nombre de mimadito</label>
        </div>
        <div class="col-md-3 form-floating">
            <select class="form-control" id="inputTipo" name="tipo" placeholder="Mimadito" required>
            <option value="0" selected>Seleccione una opción</option>
            <?php
                require_once("./php/main.php");
                $tipos = con();
                $tipos = $tipos->query("SELECT * FROM mascota_tipo");
                if($tipos->rowCount()>0){
                    $tipos = $tipos->fetchAll();
                    foreach($tipos as $row){
                        echo '<option value="'.$row['mascota_tipo_id'].'" >'.$row['mascota_tipo_nombre'].'</option>';
                    }
                } else {
                    echo '<option value="0" >Sin especificar</option>';
                }
                $tipos=null;
                ?>
            </select>
            <label for="inputTipo">Es un ?</label>
        </div>
        <div class="col-md-3 form-floating">
            <select class="form-control" id="inputTamaño" name="tamaño" placeholder="Mimadito" required>
            <option value="0" selected>Seleccione una opción</option>
            <?php
                $tam = con();
                $tam = $tam->query("SELECT * FROM mascota_tamano");
                if($tam->rowCount()>0){
                    $tam = $tam->fetchAll();
                    foreach($tam as $row){
                        echo '<option value="'.$row['mascota_tamano_id'].'" >'.$row['mascota_tamano_nombre'].'</option>';
                    }
                } else {
                    echo '<option value="0" >Sin especificar</option>';
                }
                $tam=null;
                ?>
            </select>
            <label for="inputTamaño">Tamaño</label>
        </div>
        <div class="col-md-3 form-floating">
            <select class="form-control" id="inputSexo" name="sexo" placeholder="Mimadito">
                <option value="0" selected>Seleccione una opción</option>
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
            <label for="inputSexo">Es</label>
        </div>
        <div class="col-md-4 form-floating">
            <select class="form-control" id="inputRaza" name="raza" placeholder="Mimadito">
            <option value="0" selected>Seleccione una opción</option>
            <?php
                $razas = con();
                $razas = $razas->query("SELECT * FROM mascota_raza");
                if($razas->rowCount()>0){
                    $razas = $razas->fetchAll();
                    foreach($razas as $row){
                        echo '<option value="'.$row['mascota_raza_id'].'" >'.$row['mascota_raza_nombre'].'</option>';
                    }
                } else {
                    echo '<option value="0" >Sin especificar</option>';
                }
                $razas=null;
                ?>
            </select>
            <label for="inputRaza">Raza</label>
            </div>
            <div class="col-md-4 form-floating">
                <input type="number" class="form-control" id="floatingEdad" name="edad" placeholder="Edad" min="0" title="Edad de tu mimadito" pattern="[0-9]{1,11}">
                <label for="floatingEdad">Edad</label>
            </div>
            <div class="col-md-4 form-floating">
                <textarea type="text" class="form-control" id="inputNotas" name="notas" placeholder="Notas" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}"></textarea>
                <label for="inputNotas">Notas de mimadito</label>
            </div>
        <div class="form-rest mb-6 mt-6"></div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary mb-3">Guardar</button>
        </div>
    </form>
</div>