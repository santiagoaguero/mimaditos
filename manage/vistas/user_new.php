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
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle">Nuevo Usuario</h2>
</div>

<div class="forms">

    <form class="formularioAjax row g-3 shadow" method="POST" action="./php/usuario_guardar.php" autocomplete="off">
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
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" patter="[0-9- ]{6,100}" required >
            <label for="inputTelefono" class="is-required">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
            <select class="form-control" id="inputRol" name="rol" placeholder="rol" required>
            <option value="0" selected>Seleccione una opción</option>
            <?php
                require_once("./php/main.php");
                $tipos = con();
                $tipos = $tipos->query("SELECT * FROM rol");
                if($tipos->rowCount()>0){
                    $tipos = $tipos->fetchAll();
                    foreach($tipos as $row){
                        echo '<option value="'.$row['rol_id'].'" >'.$row['rol_nombre'].'</option>';
                    }
                } else {
                    echo '<option value="3" >Empleado</option>';
                }
                $tipos=null;
                ?>
            </select>
            <label for="inputRol" class="is-required">Rol</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required >
            <label for="inputEmail4" class="is-required">Email</label>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" required>
            <label for="inputPassword" class="form-label is-required">Contraseña</label>
            <div class="col-auto">
                <span id="passwordHelpInline" class="form-text">
                La contraseña debe tener mínimo 6 carácteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ - .
                </span>
            </div>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" required>
            <label for="inputPassword2" class="form-label is-required">Confirme su contraseña</label>
        </div>
        <div class="form-rest mb-6 mt-6"></div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary mb-3">Guardar</button>
        </div>
    </form>
</div>