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
	<h2 class="subtitle">Actualizar Usuario</h2>
</div>

<div class="forms">
    <?php 
        include("./inc/btn_back.php");

        require_once("./php/main.php");

        $id=(isset($_GET["user_id_upd"])) ? $_GET["user_id_upd"] : 0;
        $id=limpiar_cadena($id);

        $check_client = con();
        $check_client = $check_client->query("SELECT * FROM empleado WHERE empleado_id = '$id'");

        if($check_client->rowCount()>0){
            $datos=$check_client->fetch();
            
    ?>

    <form class="formularioAjax row g-3 shadow" method="POST" action="./php/usuario_actualizar.php" autocomplete="off">
        <h2 class="subtitle text-center">Información Personal</h2>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" value="<?php echo $datos["empleado_nombre"];?>" required>
            <label for="inputName" class="is-required">Nombre</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" value="<?php echo $datos["empleado_apellido"];?>" required >
            <label for="inputApellido" class="is-required">Apellido</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="text" class="form-control " id="inputUser" name="usuario" placeholder="Nombre" pattern="^[a-zA-Z0-9$@._]{4,40}$" required value="<?php echo $datos["empleado_apellido"];?>">
            <label for="inputUser" class="is-required">@ Usuario</label>
            <div id="username-validation-message"></div>
            <div class="col-auto">
                <span id="userHelpInline" class="form-text">
                El @ de usuario debe tener mínimo 4 caracteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ . _ Ej: lionel
                </span>
            </div>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" patter="[0-9- ]{6,100}" value="<?php echo $datos["empleado_telefono"];?>" required >
            <label for="inputTelefono" class="is-required">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
                <select class="form-control" id="inputRol" name="rol" placeholder="rol" required>
                <?php
                    $rol = con();
                    $rol = $rol->query("SELECT * FROM rol");
                    if($rol->rowCount()>0){
                        $rol = $rol->fetchAll();
                        foreach($rol as $row){
                            if($datos["rol_id"] == $row['rol_id']){
                                echo '
                                <option value="'.$row['rol_id'].'" selected="" >'.$row['rol_nombre'].' (Actual)</option>
                                ';
                            } else {
                                echo '<option value="'.$row['rol_id'].'" >'.$row['rol_nombre'].'</option>';
                            }
                        }
                    }
                    $rol=null;
                    ?>
                </select>
            <label for="inputRol">Rol</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" value="<?php echo $datos["empleado_email"];?>" required >
            <label for="inputEmail4" class="is-required">Email</label>
        </div>
        <p class="text-body-secondary text-center fst-italic mt-4 mb-0">si no desea cambiar su contraseña, deje los campos vacíos
        </p>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" >
            <label for="inputPassword" class="form-label is-required">Contraseña</label>
            <div class="col-auto">
                <span id="passwordHelpInline" class="form-text">
                La contraseña debe tener mínimo 6 carácteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ - .
                </span>
            </div>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" >
            <label for="inputPassword2" class="form-label is-required">Confirme su contraseña</label>
        </div>
        <div class="form-check form-switch">
            <?php 
                if($datos["empleado_estado"] == 1){
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="estado" title="Si este empleado ya no está activo, desmarque para deshabilitar" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si este empleado ya no está activo, desmarque para deshabilitar">Activo</label>
                    ';
                } else {
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="estado" title="Si desea activar este empleado, marque para habilitar">
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si desea activar este empleado, marque para habilitar">inactivo</label>
                    ';
                }
            ?>
        </div>
        <input type="hidden" name="user" value="<?php echo $datos["empleado_id"];?>" required>
        <div class="form-rest mb-6 mt-6"></div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary mb-3">Actualizar</button>
        </div>
    </form>

    
    <?php 
        } else {
            include("./inc/error_alert.php");
        }
    ?>


</div>