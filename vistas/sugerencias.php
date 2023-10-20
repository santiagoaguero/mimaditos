<div class="forms">
    <div class="container">
        <form class="formularioAjax row g-3 shadow" method="POST" action="./php/sugerencias.php" autocomplete="off">
            <h2 class="subtitle text-center">Ayudanos a mejorar!</h2>
            <p class="fs-5 lh-1">A fin de seguir mejorando nuestros servicios y a la vez la experiencia que se llevan vos y tus mimaditos, no dudes en puntuarnos y dejarnos algún comentario que quieras hacer, con gusto lo leeremos y pondremos en práctica :)</p>
            <p>Si ya recibiste algún servicio nuestro, por favor puntúanos para saber tu opinión al respecto, de verdad lo valoraremos</p>
            <div class="sugerencias-puntos">
                <input type="radio" class="btn-check" name="puntaje" id="option1" autocomplete="off" value="1">
                <label class="btn" for="option1">1</label>
                <input type="radio" class="btn-check" name="puntaje" id="option2" autocomplete="off" value="2">
                <label class="btn" for="option2">2</label>
                <input type="radio" class="btn-check" name="puntaje" id="option3" autocomplete="off" value="3">
                <label class="btn" for="option3">3</label>
                <input type="radio" class="btn-check" name="puntaje" id="option4" autocomplete="off" value="4">
                <label class="btn" for="option4">4</label>
                <input type="radio" class="btn-check" name="puntaje" id="option5" autocomplete="off" value="5">
                <label class="btn" for="option5">5</label>
            </div>
            <div class="col-md-12 form-floating">
                <textarea type="text" class="form-control" id="inputSugerencias" name="sugerencias" placeholder="Notas" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ,.!¡?¿ ]{0,255}"></textarea>
                <label for="inputSugerencias">Sugerencias</label>
            </div>
            <input type="hidden" name="user" value="<?php echo $_SESSION["id"];?>" required >
            <div class="form-rest mb-6 mt-6"></div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary mb-3">Enviar</button>
            </div>
        </form>
    </div>
</div>