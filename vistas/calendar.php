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


<div id="calendar" class="mt-3 mx-5"></div>



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
          <p class="text-secondary">Dueño: <?php echo $_SESSION["nombre"] ." ". $_SESSION["apellido"]?></p>
          <select id="servicio" name="servicio" class="form-select" aria-label="Default select example" required>
            <option selected>Seleccione un servicio</option>
            <?php 
              require_once("./php/main.php");
              $horario = con();
              $horario = $horario->query("SELECT * FROM servicio WHERE servicio_disponible = 'on' ORDER BY servicio_nombre ASC");
              if( $horario->rowCount() > 0){
                $horario = $horario->fetchAll();
                foreach($horario as $row){
                  echo '
                    <option value="'.$row["servicio_id"].'">'.$row["servicio_nombre"].'</option>
                  ';
                }
              }
            ?>
          </select>
          <select id="horario_disponible" name="horario" class="form-select" aria-label="Default select example" required>
            

          </select>
          <select id="mimadito" name="mimadito" class="form-select" aria-label="Default select example" required>
            <option selected>Seleccione un mimadito</option>
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
          <div id="reservaDescripcion">
            <p id="reservaEstado"></p>
          </div>
          Notas:<textarea name="notas" class="input w-100"></textarea>
          <input type="hidden" name="cliente" value="<?php echo $_SESSION["id"];?>" required >
          <input type="hidden" id="reservaFecha" name="fecha" value="" required >

          <div class="form-rest"></div>
          <div class="col-12 text-center">
            <button id="solicitaReserva" type="submit" class="btn btn-primary">Solicitar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
    function solicitaTurno(){
      let servicio = document.getElementById('servicio').value;
      let horario = document.getElementById('horario').value;
      let mascota = document.getElementById('mimadito').value;

      let turno = {
        servicio: servicio,
        horario: horario,
        mascota: mascota
      }
            
      console.log("solicita servicio", servicio);
      console.log("solicita horario", horario);
      console.log("solicita mascota", mascota);

      function enviarForm (evt){
        evt.preventDefault();

        if(enviar){
          let data = new FormData(this);

          let method = this.getAttribute("method");
          let action = this.getAttribute("action");

          let encabezado= new Headers();

          let config = {
              method: method,
              headers: encabezado,
              mode: "cors",
              cache: "no-cache",
              body: data
          }

          fetch(action, config)
          .then(response => response.text())
          .then(response => {
              let contenedor = this.querySelector(".form-rest");
              contenedor.innerHTML = response;
          } );
        }

      }
  }


</script>