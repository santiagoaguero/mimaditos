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

        $id=(isset($_GET["det_id"])) ? $_GET["det_id"] : 0;
        $id=limpiar_cadena($id);

        $check_reserva = con();
        $check_reserva = $check_reserva->query("SELECT reserva.*, cliente.*, mascota.mascota_nombre, horario.* FROM reserva INNER JOIN cliente ON reserva.cliente_id = cliente.cliente_id INNER JOIN mascota ON reserva.mascota_id = mascota.mascota_id INNER JOIN horario ON reserva.horario_id = horario.horario_id WHERE reserva.reserva_id = '$id'");

        if($check_reserva->rowCount()>0){
            $datos=$check_reserva->fetch();
            
    ?>

    <div class="container">
        <form class="row g-3 shadow confirmarReserva" method="POST" action="./php/reserva_con_cancelar.php" autocomplete="off"><div class="forms">
        <?php 
            $badge = $datos["reserva_estado"] == 1 ?
            '<span class="badge text-bg-success">Confirmado</span>' :
            '<span class="badge text-bg-warning">Pendiente</span>';
        ?>
            <h2 class="subtitle text-center">Información de Reserva <?php echo $badge?></h2>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <?php        
                    //cambiar formato fecha
                    $timestamp = strtotime($datos["reserva_fecha"]);
                    
                    //formatea la fecha en el formato DD-MM-YYYY
                    $fecha = date("d-m-Y", $timestamp);
                    ?>
                    <h4 class="text-secondary"><?php echo $fecha;?></h4>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="mimadito" class="form-label text-secondary">Mimadito</label>
                    <input type="text" readonly class="form-control" id="mimadito" value="<?php echo $datos["mascota_nombre"];?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cliente" class="form-label text-secondary">Dueño</label>
                    <input type="text" readonly class="form-control" id="cliente" value="<?php echo $datos["cliente_nombre"].' '. $datos["cliente_apellido"];?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="horario" class="form-label text-secondary">Turno N° <?php echo $datos["horario_posicion"];?></label>
                    <input type="text" readonly class="form-control" id="horario" value="<?php echo $datos["horario_inicio"].' - '.$datos["horario_fin"];?>" required>
                </div>

            </div>
            <div class="row">
                <h5 class="text-center text-secondary">Servicios Solicitados</h5>
                <ol class="list-group list-group-numbered list-group-flush">
                    <?php
                        require_once("./php/main.php");
                        $check_detalle = con();
                        $check_detalle = $check_detalle->query("SELECT reserva_detalle.*, servicio.servicio_nombre FROM reserva_detalle INNER JOIN servicio ON reserva_detalle.servicio_id = servicio.servicio_id WHERE reserva_detalle.reserva_id = '$id'");
                
                        if($check_detalle->rowCount()>0){
                            $servicios=$check_detalle->fetchAll();
                            foreach($servicios as $row){
                                echo '
                                <li class="list-group-item">'.$row["servicio_nombre"].'</li>
                                ';
                            }
                        }
                        $check_detalle= null;
                    ?>
                </ol>
            </div>
            <div class="form-rest mb-6 mt-6"></div>
            <div class="col-12 d-flex justify-content-center gap-3 mb-3">
                <form action="./php/reserva_con_cancelar.php" method="POST" class="cancelarReserva">
                    <input type="hidden" name="cancelar" value="<?php echo $id?>">
                    <button type="submit" class="btn btn-warning">Cancelar</button>
                </form>
                <form action="./php/reserva_eliminar.php" method="POST" class="confirmarDelete">
                    <input type="hidden" name="eliminar" value="<?php echo $id?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </form>
    </div>
    <?php 
        } else {
            include("./inc/error_alert.php");
        }
        $check_reserva=null;
    ?>

</div>