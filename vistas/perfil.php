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

<div class="forms">
    <?php 
        include("./inc/btn_back.php");

        require_once("./php/main.php");

        $id=(isset($_GET["user"])) ? $_GET["user"] : 0;
        $id=limpiar_cadena($id);

        if($id == $_SESSION["usuario"]){

            $check_client = con();
            $check_client = $check_client->query("SELECT * FROM cliente WHERE cliente_usuario = '$id'");

            if($check_client->rowCount()>0){
                $datos_cliente=$check_client->fetch();
            }
    ?>

    <div class="container">
        <form class="formularioAjax row g-3 shadow" method="POST" action="./php/perfil_actualizar.php" autocomplete="off">
            <h2 class="subtitle text-center">Información Personal</h2>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control" id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required value="<?php echo $datos_cliente["cliente_nombre"];?>">
                <label for="inputName" class="is-required">Nombre</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required value="<?php echo $datos_cliente["cliente_apellido"];?>">
                <label for="inputApellido" class="is-required">Apellido</label>
            </div>
            <div class="col-md-12 form-floating">
                <input type="text" class="form-control " id="inputUser" name="usuario" placeholder="Nombre" pattern="^[a-zA-Z0-9$@._]{4,40}$" required value="<?php echo $datos_cliente["cliente_usuario"];?>">
                <label for="inputUser" class="is-required">@ Usuario</label>
                <div id="username-validation-message"></div>
                <div class="col-auto">
                    <span id="userHelpInline" class="form-text">
                    El @ de usuario debe tener mínimo 4 caracteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ . _ Ej: lionel
                    </span>
                </div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" required value="<?php echo $datos_cliente["cliente_telefono"];?>">
                <label for="inputTelefono" class="is-required">Teléfono</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control" id="inputCiudad" name="ciudad" placeholder="Ciudad" value="<?php echo $datos_cliente["cliente_ciudad"];?>">
                <label for="inputCiudad">Ciudad</label>
            </div>
            <div class="col-12 form-floating">
                <input type="text" class="form-control" id="inputAddress" name="direccion" placeholder="Direccion" value="<?php echo $datos_cliente["cliente_direccion"];?>">
                <label for="inputAddress" class="form-label">Dirección</label>
            </div>
            <div class="col-md-12 form-floating">
                <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required value="<?php echo $datos_cliente["cliente_email"];?>">
                <label for="inputEmail4" class="is-required">Email</label>
            </div>
            <p class="text-body-secondary text-center fst-italic mt-4 mb-0">si no desea cambiar su contraseña, deje los campos vacíos
            </p>
            <div class="col-12 form-floating">
                <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" title="si no desea cambiar su contraseña, deje los campos vacíos">
                <label for="inputPassword" class="form-label is-required">Contraseña</label>
                <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text">
                    La contraseña debe tener mínimo 6 carácteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ - .
                    </span>
                </div>
            </div>
            <div class="col-12 form-floating">
                <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="^[a-zA-Z0-9$@.\-]{6,100}$" title="si no desea cambiar su contraseña, deje los campos vacíos">
                <label for="inputPassword2" class="form-label is-required">Confirme su contraseña</label>
            </div>
            <input type="hidden" name="cliente_id" value="<?php echo $datos_cliente["cliente_id"];?>" required >
            <div class="form-rest mb-6 mt-6"></div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary mb-3">Actualizar</button>
            </div>
        </form>
            
        <h2 class="subtitle text-center mt-5 mb-2">Información de su Mimadito</h2>


        <?php 
        $check_mascota = con();
        $check_mascota = $check_mascota->query("SELECT mascota_id, mascota_nombre, mascota_estado FROM mascota WHERE cliente_id = '".$datos_cliente["cliente_id"]."' ORDER BY mascota_nombre");

        if($check_mascota->rowCount()>0){
            $mascotas=$check_mascota->fetchAll();

            echo '
            <p class="text-body-secondary fst-italic">
                <span class="text-primary fw-bold">mimaditos</span> de color azul son tus mimaditos presentes, <span class="text-secondary fw-bold">mimaditos</span> de color gris son tus mimaditos que ya no estan presentes 💕
            </p>

            <div class="list-group w-75 text-center mb-5">
            ';

            foreach($mascotas as $mascota){
                if($mascota["mascota_estado"] == 'on'){
                    $activo = 'list-group-item-primary';
                } else {
                    $activo = 'list-group-item-secondary';
                }
                echo '
                    <a href="index.php?vista=mascota_update&mascota='.$mascota["mascota_nombre"].'&user='.$datos_cliente["cliente_usuario"].'" class="list-group-item list-group-item-action '.$activo.'">'.$mascota["mascota_nombre"].'</a>
                    ';
            }
            echo '</div>';

        } else {
            echo' <p>No tiene mimaditos registrados</p>';
            }
            $check_mascota=null;
        ?>
    </div>


    <div class="d-grid gap-2 justify-content-center mb-5">
        <h2 class="subtitle mt-5">Tenés un nuevo mimadito?</h2>
        <button class="btn btn-primary " type="button" data-bs-toggle="collapse" data-bs-target="#collapseNew" aria-expanded="false" aria-controls="collapseNew">
                <span><i class="bi bi-plus-circle mx-2"></i>Queremos conocerle !!</span>
        </button>
    </div>
    <div class="container collapse mt-5" id="collapseNew">
        <form class="formularioAjax row g-3 shadow" method="POST" action="./php/mascota_guardar.php" autocomplete="off">
            <h2 class="subtitle text-center">Nuevo Mimadito</h2>
            <div class="col-md-3 form-floating">
                <input type="text" class="form-control" id="inputMascota" name="nombre" placeholder="Mimadito" required>
                <label for="inputMascota" class="is-required">Nombre de tu mimadito</label>
            </div>
            <div class="col-md-3 form-floating">
                <select class="form-control" id="inputTipo" name="tipo" placeholder="Mimadito" required>
                    <option value="0" selected="">Seleccione una opción</option>

                <?php 
                        $tipos = con();
                        $tipos = $tipos->query("SELECT * FROM mascota_tipo ORDER BY mascota_tipo_nombre");
                
                        if($tipos->rowCount()>0){
                            $datos=$tipos->fetchAll();
                            foreach($datos as $row){
                                echo '
                                <option value="'.$row["mascota_tipo_id"].'">'.$row["mascota_tipo_nombre"].'</option>
                                ';
                            }
                        
                        } else {
                                echo '
                                <option value="0" selected="">Seleccione una opción</option>
                                <option value="1">Perro</option>
                                <option value="2">Gato</option>
                                <option value="3">Ave</option>
                                <option value="4">Otro</option>
                                ';
                        }
                        $tipos = null;
                ?>
                </select>
                <label for="inputTipo" class="is-required">Es un ?</label>
            </div>
            <div class="col-md-3 form-floating">
                <select class="form-control" id="inputSexo" name="sexo" placeholder="Mimadito" required>
                    <option value="0" selected="">Seleccione una opción</option>
                    <option value="Macho">Macho</option>
                    <option value="Hembra">Hembra</option>
                </select>
                <label for="inputSexo">Es</label>
            </div>
            <div class="col-md-3 form-floating">
                <select class="form-control" id="inputTamaño" name="tamaño" placeholder="Mimadito" required>
                    <option value="0" selected="">Seleccione una opción</option>
                    <option value="1">Pequeño</option>
                    <option value="2">Mediano</option>
                    <option value="3">Grande</option>
                    <option value="4">Enorme</option>
                </select>
                <label for="inputTamaño" class="is-required">Tamaño</label>
            </div>
            <div class="col-md-4 form-floating">
                <select class="form-control" id="inputRaza" name="raza" placeholder="Mimadito">
                    <option value="0" selected="">Seleccione una opción</option>

                <?php 
                        $razas = con();
                        $razas = $razas->query("SELECT * FROM mascota_raza ORDER BY mascota_raza_nombre");
                
                        if($razas->rowCount()>0){
                            $datos=$razas->fetchAll();
                            foreach($datos as $row){
                                echo '
                                <option value="'.$row["mascota_raza_id"].'">'.$row["mascota_raza_nombre"].'</option>
                                ';
                            }
                        
                        } else {
                                echo '
                                <option value="0" selected="">Seleccione una opción</option>
                                <option value="1">Canice</option>
                                <option value="2">Bulldog</option>
                                <option value="3">Pug</option>
                                <option value="4">Otro</option>
                                ';
                        }
                        $razas = null;
                ?>
                </select>
                <label for="inputRaza">Raza</label>
            </div>
            <div class="col-md-4 form-floating">
                <input type="number" class="form-control" id="floatingEdad" name="edad" placeholder="Edad" min="0" title="Edad de tu mimadito" pattern="[0-9]{1,11}" required >
                <label for="floatingEdad">Edad</label>
            </div>
            <div class="col-md-4 form-floating">
                <textarea type="text" class="form-control" id="inputNotas" name="notas" placeholder="Notas" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}"></textarea>
                <label for="inputNotas">Notas de mimadito</label>
            </div>
            <input type="hidden" name="user" value="<?php echo $datos_cliente["cliente_id"];?>" required >
            <div class="form-rest mb-6 mt-6"></div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary mb-3">Agregar</button>
            </div>
        </form>
    </div>

    <div class="d-grid gap-2 justify-content-center mt-5">
        <h2 class="fs-4 mt-5 text-secondary">Querés desactivar tu cuenta?</h2>
        <a type="button" class="btn btn-outline-danger " href="index.php?vista=desactivar&user=<?php echo $id; ?>">
            <span><i class="bi bi-x-circle mx-2"></i>desactivar cuenta</span>
        </a>
    </div>
    
    <?php 
        } else {
            include("./inc/error_alert.php");
        }
        $check_client=null;
    ?>

</div>