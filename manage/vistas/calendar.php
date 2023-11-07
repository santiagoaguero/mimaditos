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
  <span class="" style="color:red; font-size: 15px;">Turno no disponible</span>
  <span class="" style="color:green; font-size: 15px;">Turno Disponible</span>
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
        <h1 class="modal-title fs-5" id="reservaTitulo">Modal title</h1><br>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="">
          <p class="mb-1 text-secondary" id="mimadito"></p>
          <p id="dueno" class="mb-1 text-secondary"></p>
          <div class="mb-2">
            <p class="mb-1 text-secondary text-center">Servicios Solicitados</p>          
            <ol id="servicios" class="list-group list-group-numbered list-group-flush">

            </ol>
          </div>

          <div id="transporte">
          
          </div>

          Notas:<textarea id="notas" class="input w-100" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ,.¿?¡!: ]{0,255}" readonly></textarea>
          <input type="hidden" name="cliente" value="<?php echo $_SESSION["id"];?>" required >
          <input type="hidden" id="reservaFecha" name="fecha" value="" required >

          <div class="form-rest mb-6 mt-6"></div>
          <div class="d-flex justify-content-center gap-3">
            <form action="./php/reserva_pen_confirmar.php" method="POST" class="confirmarReserva">
                <input id="iptConfirmar" type="hidden" name="confirmar" value="">
                <button type="submit" class="btn btn-success">Confirmar</button>
            </form>
            <form action="./php/reserva_con_cancelar.php" method="POST" class="cancelarReserva">
                <input id="iptCancelar" type="hidden" name="cancelar" value="">
                <button type="submit" class="btn btn-warning">Cancelar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
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