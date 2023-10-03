<div class="container-fluid mb-6">
	<h1 class="title">Servicios</h1>
	<h2 class="subtitle">Actualizar Servicio</h2>
</div>

<div class="forms">
<?php 
    include("./inc/btn_back.php");

	require_once("./php/main.php");

    $id=(isset($_GET["servicio_id_upd"])) ? $_GET["servicio_id_upd"] : 0;
    $id=limpiar_cadena($id);

    $check_servicio = con();
    $check_servicio = $check_servicio->query("SELECT * FROM servicio WHERE servicio_id = '$id'");

    if($check_servicio->rowCount()>0){
        $datos=$check_servicio->fetch();
?>

    <form action="./php/servicio_actualizar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >

	    <div class="form-rest mb-6 mt-6"></div>

        <input type="hidden" name="servicio_id" value="<?php echo $datos["servicio_id"];?>" required >
        <div class="col-md-4 form-floating">
            <input type="text" class="form-control" id="floatingNombre" name="servicio_nombre" placeholder="servicio" title="Nombre del Servicio a ofrecer" pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{3,40}$" required value="<?php echo $datos["servicio_nombre"]?>">
            <label for="floatingNombre">Nombre</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="number" min="1" class="form-control" id="floatingDuracion" name="servicio_duracion" placeholder="servicio" title="Duración en horas del Servicio a ofrecer, mínimo 1 hora por defecto" value="1" pattern="[0-9]{1,11}" required value="<?php echo $datos["servicio_duracion"]?>">
            <label for="floatingDuracion">Duración (hs.)</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="number" min="1" class="form-control" id="floatingPrecio" name="servicio_precio" placeholder="servicio" title="Precio del Servicio a ofrecer en Guaraníes" pattern="[0-9]{1,11}" required value="<?php echo $datos["servicio_precio"]?>">
            <label for="floatingPrecio">Precio Gs.</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="text" class="form-control" id="floatingDescripcion" name="servicio_descripcion" placeholder="servicio" title="Descripción detalla del Servicio a ofrecer" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{0,255}" value="<?php echo $datos["servicio_descripcion"]?>">
            <label for="floatingDescripcion">Descripción</label>
        </div>
        <div class="form-check form-switch">
            <?php 
                if($datos["servicio_disponible"] == "on"){
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="servicio_disponible" title="Si no desea ofrecer este servicio, desmarque para deshabilitar" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si no desea ofrecer este servicio, desmarque para deshabilitar">Disponible</label>
                    ';
                } else {
                    echo '
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="servicio_disponible" title="Si desea ofrecer este servicio, marque para habilitar">
                    <label class="form-check-label" for="flexSwitchCheckDefault" title="Si desea ofrecer este servicio, marque para habilitar">No Disponible</label>
                    ';
                }
            ?>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
	<?php 
    } else {
        include("./inc/error_alert.php");
    }
    $check_categoria=null;
?>
</div>