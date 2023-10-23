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

    include_once("./inc/btn_back.php");
    require_once("./php/main.php");

    $usuario=(isset($_GET["user"])) ? $_GET["user"] : 0;
    $usuario=limpiar_cadena($usuario);

    //getting user id
    $check_client = con();
    $check_client = $check_client->query("SELECT cliente_id FROM cliente 
        WHERE cliente_usuario = '$usuario'");
    
        if($check_client->rowCount()>0){
            $datos_cliente=$check_client->fetch();
            $id = $datos_cliente["cliente_id"];

            if($id == $_SESSION["id"]){

?>
<div class="forms">   
   <div class="card shadow " id="collapseDelete">
        <form class="" method="POST" action="" autocomplete="off">
            <div class="card-header">
                Lamentamos que decidas desactivar tu cuenta :(
            </div>
            <?php 
                    if($_SESSION["cuenta"] == 'local'){
            ?>
            <div class="card-body">
                <h5 class="card-title">Esperamos que vuelvas pronto para brindarle la mejor atención a tu mimadito 🥰</h5>
                <p class="card-text">Toda tu información, la de tus mimaditos y reservas se eliminarán.</p>
                <p class="card-text">Si realmente quieres desactivar tu cuenta, por favor introduce tu contraseña para confirmarlo.</p>
                <div class="col-12 form-floating">
                    <input type="password" class="form-control" id="deletePassword" name="contraseña" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{6,100}" required>
                    <label for="deletePassword" class="form-label is-required">Contraseña</label>
                </div>
                <div class="col-12 form-floating">
                    <input type="password" class="form-control" id="deletePassword2" name="contraseña2" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{6,100}" required>
                    <label for="deletePassword2" class="form-label is-required">Confirme su contraseña</label>
                </div>
                <input type="hidden" name="user" value="<?php echo $id;?>" required >
                <input type="hidden" name="gid" value="off" required >
                <div class="form-rest mb-6 mt-6"></div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-outline-secondary">Desactivar</button>
                </div>
                <?php 
                    if(isset($_POST["contraseña"]) && isset($_POST["contraseña"]) &&
                    isset($_POST["contraseña2"]) && isset($_POST["contraseña2"])){
                        require_once("./php/desactivar_cuenta.php");
                    }
                ?>
            </div>
                <?php 
                    } else if($_SESSION["cuenta"] == 'google'){ ?>
                        <div class="card-body">
                        <h5 class="card-title">Esperamos que vuelvas pronto para brindarle la mejor atención a tu mimadito 🥰</h5>
                        <p class="card-text">Ya que has ingresado con tu cuenta Google, solamente deberás confirmar tu correo para que podamos desvincular toda tu información y la de tus mimaditos.</p>
                        <p class="card-text">Si realmente quieres desactivar tu cuenta, por favor introduce tu correo electrónico para confirmarlo.</p>
                        <div class="col-12 form-floating">
                        <input type="email" class="form-control" id="deleteEmail"  placeholder="name@example.com" name="email" required>
                            <label for="deleteEmail" class="is-required">Email</label>
                        </div>
                        <div class="col-12 form-floating">
                        <input type="email" class="form-control" id="deleteEmail2"  placeholder="name@example.com" name="email2" required>
                            <label for="deleteEmail2" class="is-required">Confirmar Email</label>
                        </div>
                        <input type="hidden" name="user" value="<?php echo $id;?>" required >
                        <input type="hidden" name="gid" value="on" required >
                        <div class="form-rest mb-6 mt-6"></div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-outline-secondary">Desactivar</button>
                        </div>
                        <?php 
                            if(isset($_POST["email"]) && isset($_POST["email"]) &&
                            isset($_POST["email2"]) && isset($_POST["email2"])){
                                require_once("./php/desactivar_cuenta.php");
                            }
                        ?>
                    </div>
                <?php
                    }
                ?>
        </form>
    </div>
    <?php 
            } else {
                include("./inc/error_alert.php");
            }
        } else {
            include("./inc/error_alert.php");
        }
        $check_client=null;
    ?>
</div>