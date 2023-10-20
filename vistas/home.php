<?php
 /*   require_once("./php/main.php");
    $check_reserva = con();
    $check_reserva = $check_reserva->query("SELECT reserva_id, reserva_fecha FROM reserva 
    WHERE cliente_id = '{$_SESSION['id']}' AND reserva_estado = 1 AND reserva_aceptado = 0");
    $rowCount = $check_reserva->rowCount();
// Recorre las filas y muestra un toast por cada fila

if ($rowCount > 0) {
    $datos = $check_reserva->fetchAll();
    foreach($datos as $row){
        //cambiar formato fecha
        $timestamp = strtotime($row["reserva_fecha"]);

        //formatea la fecha en el formato DD-MM-YYYY
        $fecha = date("d-m-Y", $timestamp);
        echo '
        
            <div id="notificaciones" class="alert alert-info alert-dismissible fade show" role="alert">
                <div>
                    <i class="fa-regular fa-bell fa-shake"></i><strong> Reserva Confirmada!</strong> Su reserva en fecha '.$fecha.' ha sido confirmada :)
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center">
                    <form action="./php/reserva_aceptar.php" method="POST" class="aceptarReserva">
                        <input type="hidden" name="aceptar" value="'.$row["reserva_id"].'">
                        <input type="hidden" name="id" value="'.$_SESSION["id"].'">
                        <button type="submit" class="btn btn-sm btn-info w-25" class="btn-close" data-bs-dismiss="alert">Aceptar</button>
                    </form>
                </div>
            </div>
        
    ';
    }
    $check_reserva = null;

}
*/
?>

<div class="welcome">
    <div id="carouselAuto" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner fw-bold mb-5 ">
            <div class="carousel-item active text-center" style="background-image: url('./img/dog-look.jpg');">

                <div class="carousel-caption first" >
                    <h5>Nosotros nos encargamos de brindar la mejor experiencia para tu mimado</h5>
                </div>
                
            </div>
            <div class="carousel-item text-center" style="background-image: url('./img/atencion.jpg');">

                <div class="carousel-caption">
                    <h5>Atención y Confianza</h5>
                    <h5>Ofrecemos la mejor atención que tu mimadito se merece</h5>
                </div>

            </div>
            <div class="carousel-item text-center" style="background-image: url('./img/bañando.jpg');">

                <div class="carousel-caption">
                        <h5 class="">Baños</h5>
                        <h5>Utilizamos distintos shampoos para cada tipo de piel</h5>
                </div>
           
            </div>
            <div class="carousel-item text-center" style="background-image: url('./img/corte.jpg');">
                <div class="carousel-caption">
                        <h5>Corte de Pelo</h5>
                        <h5>Dejamos el pelo de tu mimadito suave y cómodo</h5>
                </div>

            </div>
            <div class="carousel-item text-center" style="background-image: url('./img/mimado.jpg');">
                <div class="carousel-caption">
                        <h5>Mimados como en casa 💕</h5>
                </div>

            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAuto" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselAuto" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


<div class="middle">
    <div class="w-header">
        <p class="fs-1">Nuestra Atención</p>
        <p class="fs-4 w-50">Para una mejor atención a tu mimadito, ofrecemos nuestros servicios bajo reserva de turnos</p>
        <p>Podes reservar un turno haciendo click abajo 😊</p>
        <a class="btn btn-primary btn-sm w-50" href="index.php?vista=calendar">Quiero reservar!</a>

        <p class="fs-1 mt-5">Nuestro Contacto</p>
        <p class="fs-4 w-50">Podes seguirnos en nuestras redes sociales para enterarte de más promociones y novedades</p>
        <div class="m-contact d-flex justify-content-center gap-5 mb-5">
            <div>
                <a href="https://www.instagram.com/petshopmimaditos" target="_blank">
                    <img src="./img/ig-logo.png" alt="instagram">
                    <p>PetShop Mimaditos</p>
                </a>
            </div>

            <div>
                <a href="https://wa.me/595985697266?text=Hola! Quiero reservar un turno por favor" target="_blank">
                    <img src="./img/wsp-logo.png" alt="whatsapp">
                    <p>WhatsApp Mimaditos</p>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="footer pt-5">
    <div class="w-header">
        <p class="fs-1">Testimonios</p>
        <p class="fs-6 w-75 text-center">Estos son algunos testimonios y opiniones que contentos recibimos de nuestros clientes 🤲</p>
    </div>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">


            <?php
           require_once("./php/main.php");
            $check_testi = con();
            $check_testi = $check_testi->query("SELECT testimonio.testimonio_desc, testimonio.testimonio_puntaje, cliente.cliente_nombre, cliente.cliente_apellido FROM testimonio INNER JOIN cliente ON testimonio.cliente_id = cliente.cliente_id");
            $rowCount = $check_testi->rowCount();
            // active solo debe tener el primero
            $active = 'active';
            if ($rowCount > 0) {
                $datos = $check_testi->fetchAll();
                foreach($datos as $row){
                    //multiplica puntaje * estrellas
                    $puntaje = str_repeat('⭐', $row["testimonio_puntaje"]);
                    echo '
                    <div class="carousel-item '.$active.'">
                        <div class="testimonio">
                            <i class="fa fa-quote-left fa-lg"></i>
                            <h5>'.$row["testimonio_desc"].'</h5>
                            <p>'.$puntaje.'</p>
                            <p>'.$row["cliente_nombre"] .' '.$row["cliente_apellido"].'</p>
                        </div>
                    </div>

            ';
            $active ='';
            }
            $check_testi = null;
        }
        ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>


    <p class="ubicacion w-header fs-5">Ubicación: Estamos ubicados en la ciudad de Asunción - Av. Bruno Guggiari c/ Mayas
        <a href="https://maps.app.goo.gl/c2ucCAhb3BpKpjdn7" target="_blank">
                <img src="./img/map-logo.png" alt="Mapa">
        </a>
    </p>


</div>