<div class="forms">
<?php 
    include("./inc/btn_back.php");

	require_once("./php/main.php");

    $id=(isset($_GET["cliente_id_upd"])) ? $_GET["cliente_id_upd"] : 0;
    $id=limpiar_cadena($id);

    $check_client = con();
    $check_client = $check_client->query("SELECT * FROM cliente WHERE cliente_id = '$id'");

    if($check_client->rowCount()>0){
        $datos=$check_client->fetch();
?>

<div class="container">
    <form class="formularioAjax row g-3 shadow" method="POST" action="./php/cliente_actualizar.php" autocomplete="off" >
        <input type="hidden" name="cliente_id" value="<?php echo $datos["cliente_id"];?>" required >
        <h2 class="subtitle text-center">Información Personal</h2>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required value=" <?php echo $datos["cliente_nombre"];?> ">
            <label for="inputName">Nombre</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required value=" <?php echo $datos["cliente_apellido"];?> ">
            <label for="inputApellido">Apellido</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" required value=" <?php echo $datos["cliente_telefono"];?> ">
            <label for="inputTelefono">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputCiudad" name="ciudad" placeholder="Ciudad" value=" <?php echo $datos["cliente_ciudad"];?> ">
            <label for="inputCiudad">Ciudad</label>
        </div>
        <div class="col-12 form-floating">
            <input type="text" class="form-control" id="inputAddress" name="direccion" placeholder="Direccion" value=" <?php echo $datos["cliente_direccion"];?> ">
            <label for="inputAddress" class="form-label">Dirección</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required value=" <?php echo $datos["cliente_email"];?> ">
            <label for="inputEmail4">Email</label>
        </div>
        <div class="form-rest mb-6 mt-6"></div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary mb-3">Actualizar</button>
        </div>
    </form>
        
    <h2 class="subtitle text-center mt-5 mb-2">Información de su Mimadito</h2>

	<?php 
    $check_mascota = con();
    $check_mascota = $check_mascota->query("SELECT mascota_id, mascota_nombre FROM mascota WHERE cliente_id = '$id' ORDER BY mascota_nombre");

    if($check_mascota->rowCount()>0){
        $datos=$check_mascota->fetchAll();

        echo '<div class="list-group w-75 text-center">';

        foreach($datos as $mascota){
            echo '
                <a href="index.php?vista=mascota_update&mascota_upd_id='.$mascota["mascota_id"].'" class="list-group-item list-group-item-action">'.$mascota["mascota_nombre"].'</a>
                ';
        }
        echo '</div>';
    ?>




	<?php 
    } else {
           echo' <p>No tiene mimaditos registrados</p>';
        }
        $check_mascota=null;
    ?>

</div>


	<?php 
    } else {
        include("./inc/error_alert.php");
    }
    $check_client=null;
?>
</div>