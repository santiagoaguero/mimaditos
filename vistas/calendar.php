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

<?php // Verificar los permisos del usuario para esta página
  if(isset($_SESSION["reserva"])){
		echo $_SESSION["reserva"];
    unset($_SESSION["reserva"]);
	}
?>

<div class="d-flex gap-5 justify-content-center">
  <span class="" style="color:orange; font-size: 15px;">Reservas Pendientes</span>
  <span class="" style="color:blue; font-size: 15px;">Reservas Confirmadas</span>
</div>
<div id="calendar" class="mt-3 mx-5"></div>

<script>
  var roleus = <?php echo $_SESSION['rol']; ?>;
</script>

<!-- Modal -->
<div class="modal fade" id="calendarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="reservaTitulo">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="reserva" method="POST" action="./php/setReserva.php">
          <p class="mb-1 text-secondary">Dueño: <?php echo $_SESSION["nombre"] ." ". $_SESSION["apellido"]?></p>
          <div class="container mb-2">
            <p class="mb-1 text-secondary">Servicios Disponibles</p>
            <div class="row row-cols-2 row-cols-sm-3">
              
                <?php 
                  require_once("./php/main.php");
                  $horario = con();
                  $horario = $horario->query("SELECT * FROM servicio WHERE servicio_disponible = 'on' ORDER BY servicio_nombre ASC");
                  if( $horario->rowCount() > 0){
                    $horario = $horario->fetchAll();
                    foreach($horario as $row){
                      echo '
                      <div class="form-check col-auto">
                        <input class="form-check-input" type="checkbox" name="servicios[]" id="'.$row["servicio_id"].'" value="'.$row["servicio_id"].'">
                        <label class="form-check-label" for="'.$row["servicio_id"].'">
                        '.$row["servicio_nombre"].'
                        </label>
                      </div>
                      ';
                    }
                  }
                ?>
            </div>
          </div>
          <select id="horario_disponible" name="horario" class="form-select mb-1" aria-label="Default select example" required>
            

          </select>
          <select id="mimadito" name="mimadito" class="form-select mb-1" aria-label="Default select example" required>
            <option value="">Seleccione un mimadito</option>
            <?php 
              require_once("./php/main.php");
              $id = $_SESSION["id"];
              $horario = con();
              $horario = $horario->query("SELECT * FROM mascota WHERE cliente_id = $id ORDER BY mascota_nombre ASC");
              if( $horario->rowCount() > 0){
                $horario = $horario->fetchAll();
                foreach($horario as $row){
                  echo '
                    <option value="'.$row["mascota_id"].'">'.$row["mascota_nombre"].'</option>
                  ';
                }
              }
            ?>
          </select>
          <div class="d-flex align-items-center gap-3">
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="checkbox" id="reverseCheck1" name="transporte">
              <label class="form-check-label" for="reverseCheck1">
                Quiero transporte para mi mimadito 
              </label>
            </div>
              <i tabindex="0" class="fa-regular fa-circle-question" type="button" data-bs-toggle="popover" data-bs-title="Solicitar Transporte"  data-bs-trigger="focus" data-bs-content="Dependiendo de nuestra disponibilidad, podemos transportar de manera segura a tu mimadito"></i>
          </div>

          <div id="reservaDescripcion">
            <p id="reservaEstado"></p>
          </div>
          Notas:<textarea name="notas" class="input w-100"></textarea>
          <input type="hidden" name="cliente" value="<?php echo $_SESSION["id"];?>" required >
          <input type="hidden" id="reservaFecha" name="fecha" value="" required >

          <div class="form-rest mb-6 mt-6"></div>
          <div class="col-12 text-center">
            <button id="solicitaReserva" type="submit" class="btn btn-primary">Solicitar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ad-->
<div class="modal fade" id="calendarModalAd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="reservaTitulo">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="reserva" method="POST" action="./php/setReserva.php">
          <p class="mb-1 text-secondary">Dueño: <?php echo $_SESSION["nombre"] ." ". $_SESSION["apellido"]?></p>
          <div class="container mb-2">
            <p class="mb-1 text-secondary">Servicios Asadito</p>
            <div class="row row-cols-2 row-cols-sm-3">
              
                <?php 
                  require_once("./php/main.php");
                  $horario = con();
                  $horario = $horario->query("SELECT * FROM servicio WHERE servicio_disponible = 'on' ORDER BY servicio_nombre ASC");
                  if( $horario->rowCount() > 0){
                    $horario = $horario->fetchAll();
                    foreach($horario as $row){
                      echo '
                      <div class="form-check col-auto">
                        <input class="form-check-input" type="checkbox" name="servicios[]" id="'.$row["servicio_id"].'" value="'.$row["servicio_id"].'">
                        <label class="form-check-label" for="'.$row["servicio_id"].'">
                        '.$row["servicio_nombre"].'
                        </label>
                      </div>
                      ';
                    }
                  }
                ?>
            </div>
          </div>
          <select id="horario_disponible" name="horario" class="form-select mb-1" aria-label="Default select example" required>
            

          </select>
          <select id="mimadito" name="mimadito" class="form-select mb-1" aria-label="Default select example" required>
            <option value="">Seleccione un mimadito</option>
            <?php 
              require_once("./php/main.php");
              $id = $_SESSION["id"];
              $horario = con();
              $horario = $horario->query("SELECT * FROM mascota WHERE cliente_id = $id ORDER BY mascota_nombre ASC");
              if( $horario->rowCount() > 0){
                $horario = $horario->fetchAll();
                foreach($horario as $row){
                  echo '
                    <option value="'.$row["mascota_id"].'">'.$row["mascota_nombre"].'</option>
                  ';
                }
              }
            ?>
          </select>
          <div class="d-flex align-items-center gap-3">
            <div class="form-check form-check-reverse">
              <input class="form-check-input" type="checkbox" id="reverseCheck1" name="transporte">
              <label class="form-check-label" for="reverseCheck1">
                Quiero transporte para mi mimadito 
              </label>
            </div>
              <i tabindex="0" class="fa-regular fa-circle-question" type="button" data-bs-toggle="popover" data-bs-title="Solicitar Transporte"  data-bs-trigger="focus" data-bs-content="Dependiendo de nuestra disponibilidad, podemos transportar de manera segura a tu mimadito"></i>
          </div>

          <div id="reservaDescripcion">
            <p id="reservaEstado"></p>
          </div>
          Notas:<textarea name="notas" class="input w-100"></textarea>
          <input type="hidden" name="cliente" value="<?php echo $_SESSION["id"];?>" required >
          <input type="hidden" id="reservaFecha" name="fecha" value="" required >

          <div class="form-rest mb-6 mt-6"></div>
          <div class="col-12 text-center">
            <button id="solicitaReserva" type="submit" class="btn btn-primary">Solicitar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
  <?php
      require_once('./js/calendarConfig.js');
      require_once('./js/solicitaReserva.js');
      ?>
</script>