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

        $mascota_id=(isset($_GET["mascota_id"])) ? $_GET["mascota_id"] : 0;

        $cliente_id=(isset($_GET["user_id"])) ? $_GET["user_id"] : 0;

        $check_mascota = con();
        $check_mascota = $check_mascota->query("SELECT mascota.*, cliente.cliente_nombre, cliente.cliente_apellido FROM mascota INNER JOIN cliente ON mascota.cliente_id = cliente.cliente_id WHERE mascota.cliente_id = '$cliente_id' AND mascota.mascota_id = '$mascota_id'");
    
        if($check_mascota->rowCount()>0){
            $datos=$check_mascota->fetch();

    ?>

    <div class="container">
        <form class="formularioAjax row g-3 shadow" method="POST" action="./php/mascota_actualizar.php" autocomplete="off" >

            <h2 class="subtitle text-center">Información de Mimadito</h2>

            <div class="mb-3 row">
                <label for="dueñoMascota" class="col-sm-2 col-form-label">Dueño:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="dueñoMascota" value="<?php echo $datos["cliente_nombre"] . " ". $datos["cliente_apellido"];?>">
                </div>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" class="form-control" id="inputMascota" name="nombre" placeholder="Mimadito" value="<?php echo $datos["mascota_nombre"];?>" required>
                <label for="inputMascota">Nombre de mimadito</label>
            </div>
            <div class="col-md-3 form-floating">
                <select class="form-control" id="inputTipo" name="tipo" placeholder="Mimadito" required>
                <?php
                    $tipos = con();
                    $tipos = $tipos->query("SELECT * FROM mascota_tipo");
                    if($tipos->rowCount()>0){
                        $tipos = $tipos->fetchAll();
                        foreach($tipos as $row){
                            if($datos["mascota_tipo_id"] == $row['mascota_tipo_id']){
                                echo '
                                <option value="'.$row['mascota_tipo_id'].'" selected="" >'.$row['mascota_tipo_nombre'].' (Actual)</option>
                                ';
                            } else {
                                echo '<option value="'.$row['mascota_tipo_id'].'" >'.$row['mascota_tipo_nombre'].'</option>';
                            }
                        }
                    }
                    $tipos=null;
                    ?>
                </select>
                <label for="inputTipo">Es un ?</label>
            </div>
            <div class="col-md-3 form-floating">
                <select class="form-control" id="inputTamaño" name="tamaño" placeholder="Mimadito" required>
                <?php
                    $tam = con();
                    $tam = $tam->query("SELECT * FROM mascota_tamano");
                    if($tam->rowCount()>0){
                        $tam = $tam->fetchAll();
                        foreach($tam as $row){
                            if($datos["mascota_tamano_id"] == $row['mascota_tamano_id']){
                                echo '
                                <option value="'.$row['mascota_tamano_id'].'" selected="" >'.$row['mascota_tamano_nombre'].' (Actual)</option>
                                ';
                            } else {
                                echo '<option value="'.$row['mascota_tamano_id'].'" >'.$row['mascota_tamano_nombre'].'</option>';
                            }
                        }
                    }
                    $tam=null;
                    ?>
                </select>
                <label for="inputTamaño">Tamaño</label>
            </div>
            <div class="col-md-3 form-floating">
            <select class="form-control" id="inputSexo" name="sexo" placeholder="Mimadito">
                <option value="<?php echo $datos["mascota_sexo"];?>" ><?php echo $datos["mascota_sexo"];?> (Actual)</option>
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
            <label for="inputSexo">Es</label>
        </div>
            <div class="col-md-4 form-floating">
                <select class="form-control" id="inputRaza" name="raza" placeholder="Mimadito">
                <?php
                    $razas = con();
                    $razas = $razas->query("SELECT * FROM mascota_raza");
                    if($razas->rowCount()>0){
                        $razas = $razas->fetchAll();
                        foreach($razas as $row){
                            if($datos["mascota_raza_id"] == $row['mascota_raza_id']){
                                echo '
                                <option value="'.$row['mascota_raza_id'].'" selected="" >'.$row['mascota_raza_nombre'].' (Actual)</option>
                                ';
                            } else {
                                echo '<option value="'.$row['mascota_raza_id'].'" >'.$row['mascota_raza_nombre'].'</option>';
                            }
                        }
                    }
                    $razas=null;
                    ?>
                </select>
                <label for="inputRaza">Raza</label>
            </div>
            <div class="col-md-4 form-floating">
                <input type="number" class="form-control" id="floatingEdad" name="edad" placeholder="Edad" min="0" title="Edad de tu mimadito" pattern="[0-9]{1,11}" value="<?php echo $datos["mascota_edad"];?>">
                <label for="floatingEdad">Edad</label>
            </div>
            <div class="col-md-4 form-floating">
                <textarea type="text" class="form-control" id="inputNotas" name="notas" placeholder="Notas" value="<?php echo $datos["mascota_notas"];?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}"></textarea>
                <label for="inputNotas">Notas de mimadito</label>
            </div>
            <div class="form-check form-switch">
            <?php 
                if($datos["mascota_estado"] == "on"){
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="estado" title="Si este mimadito ya no está activo, desmarque para deshabilitar" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si este mimadito ya no está activo, desmarque para deshabilitar">Activo</label>
                    ';
                } else {
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="estado" title="Si este mimadito está activo, marque para habilitar">
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si este mimadito está activo, marque para habilitar">inactivo</label>
                    ';
                }
            ?>
        </div>
            <input type="hidden" name="mascota_id" value="<?php echo $datos["mascota_id"];?>" required >
            <input type="hidden" name="cliente_id" value="<?php echo $datos["cliente_id"];?>" required >
            <div class="form-rest mb-6 mt-6"></div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
    <?php 
        } 
        else {
            include("./inc/error_alert.php");
        }
        $check_client=null;
        ?>
</div>

