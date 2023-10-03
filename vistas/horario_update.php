<div class="container-fluid mb-6">
	<h1 class="title">Horario</h1>
	<h2 class="subtitle">Actualizar Horario</h2>
</div>

<div class="forms">
<?php 
    include("./inc/btn_back.php");

	require_once("./php/main.php");

    $id=(isset($_GET["horario_id_upd"])) ? $_GET["horario_id_upd"] : 0;
    $id=limpiar_cadena($id);

    $check_horario = con();
    $check_horario = $check_horario->query("SELECT * FROM horario WHERE horario_id = '$id'");

    if($check_horario->rowCount()>0){
        $datos=$check_horario->fetch();
?>

    <form action="./php/horario_actualizar.php" method="POST" class="row g-3 formularioAjax" autocomplete="off" >
    
        <div class="form-rest mb-6 mt-6"></div>

        <input type="hidden" name="horario_id" value="<?php echo $datos["horario_id"];?>" required >
        <div class="col-md-4 form-floating">
            <input type="number" min="1" class="form-control" id="floatingPos" name="horario_posicion" placeholder="servicio" title="Posición del Horario" pattern="[0-9]{1,11}" required value="<?php echo $datos["horario_posicion"]?>">
            <label for="floatingPos">Posición</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="time" class="form-control" id="floatingNombre" name="horario_inicio" placeholder="servicio" title="Inicio de horario" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required value="<?php echo $datos["horario_inicio"]?>">
            <label for="floatingNombre">Inicio</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="time" class="form-control" id="floatingDuracion" name="horario_fin" placeholder="servicio" title="Fin de Horario" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required value="<?php echo $datos["horario_fin"]?>">
            <label for="floatingDuracion">Fin</label>
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