<div class="welcome">
    <div class="w-header">
        <p class="fs-1">Hola <?php echo ' '. $_SESSION["nombre"].' ';?>!</p>
        <p class="fs-5 w-50">Nosotros nos encargamos de brindar la mejor experiencia para tu mimado</p>
    </div>

    <div id="carouselAuto" class="carousel slide w-100" data-bs-ride="carousel">
        <div class="carousel-inner fw-bold mb-5">
            <div class="carousel-item active text-center">
                <div class="card d-inline-block" style="width: 20rem;">
                    <img src="./img/atencion.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Atención y Confianza</p>
                        <p class="card-text">Ofrecemos la mejor atención que tu mimadito se merece</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item text-center">
                <div class="card d-inline-block" style="width: 20rem;">
                    <img src="./img/baño.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Baños Medicados</p>
                        <p class="card-text">Nuestro baño ayuda a la salud de la piel de tu mimadito</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item text-center">
                <div class="card d-inline-block" style="width: 20rem;">
                    <img src="./img/corte.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Corte de Pelo</p>
                        <p class="card-text">Dejamos el pelo de tu mimadito suave y cómodo</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item text-center">
                <div class="card d-inline-block" style="width: 20rem;">
                    <img src="./img/mimado.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Mimados como en casa 💕</p>
                    </div>
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


<div class="middle mt-2">
    <div class="w-header">
        <p class="fs-1">Nuestra Atención</p>
        <p class="fs-4 w-50">Para una mejor atención a tu mimadito, ofrecemos nuestros servicios bajo reserva de turnos</p>
        <p>Podes reservar un turno haciendo click abajo 😊</p>
        <a class="btn btn-primary w-50" href="index.php?vista=calendar">Quiero reservar!</a>

        <p class="fs-2 mt-5">Nuestro Contacto</p>
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

<div class="footer">
    <div class="w-header">
        <p class="fs-1 pt-5">Nuestra Ubicación</p>
        <p class="fs-4 w-75">Estamos ubicados en la ciudad de Asunción</p>
        <p>Av. Bruno Guggiari casi Mayas</p>

        <div>
            <a href="https://maps.app.goo.gl/c2ucCAhb3BpKpjdn7" target="_blank">
                <img src="./img/map-logo.png" alt="Mapa">
                <p>Ver Mapa</p>
            </a>
        </div>
    </div>
</div>
