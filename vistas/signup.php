<div class="container">
    <form class="signup row g-3 shadow" method="POST" action="" autocomplete="off" >
        <div class="text-center" class="">
            <img src="./img/mimaditos-logo.png" alt="reservet"  class="w-50 img-fluid">
        </div>
        <div class="form-rest mb-6 mt-6"></div>
        <p class="text-center">Gracias por elegirnos para cuidar a tu mimado, por favor introduce tus datos para conocernos más</p>
        <h4 class="text-center text-secondary mb-0">Información Personal</h4>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control " id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required>
            <label for="inputName" class="is-required">Nombre</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required>
            <label for="inputApellido" class="is-required">Apellido</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="text" class="form-control " id="inputUser" name="usuario" placeholder="Nombre" pattern="^[a-zA-Z0-9$@._]{4,40}$" required>
            <label for="inputUser" class="is-required">@ Usuario</label>
            <div id="username-validation-message"></div>
            <div class="col-auto">
                <span id="userHelpInline" class="form-text">
                El @ de usuario debe tener mínimo 4 caracteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @ . _ Ej: lionel
                </span>
            </div>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" pattern="[0-9- ]{6,100}" required>
            <label for="inputTelefono" class="is-required">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputCiudad" name="ciudad" placeholder="Ciudad">
            <label for="inputCiudad">Ciudad</label>
        </div>
        <div class="col-12 form-floating">
            <input type="text" class="form-control" id="inputAddress" name="direccion" placeholder="Direccion">
            <label for="inputAddress" class="form-label">Dirección</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required>
            <label for="inputEmail4" class="is-required">Email</label>
        </div>
        <h4 class="text-center text-secondary mt-4 mb-0">Información de tu Mimadito</h4>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputMascota" name="mascota" placeholder="Mimadito" >
            <label for="inputMascota" class="is-required">Nombre de tu mimadito</label>
        </div>
        <div class="col-md-6 form-floating">
            <select class="form-control" id="inputTipo" name="tipo" placeholder="Mimadito">
                <option value="0" selected="">Seleccione una opción</option>
                <option value="1">Perro</option>
                <option value="2">Gato</option>
                <option value="3">Ave</option>
                <option value="4">Otro</option>
            </select>
            <label for="inputTipo" class="is-required">Es un ?</label>
        </div>
        <div class="col-md-4 form-floating">
            <select class="form-control" id="inputTamaño" name="tamaño" placeholder="Mimadito" required>
                <option value="0" selected="">Seleccione una opción</option>
                <option value="1">Pequeño</option>
                <option value="2">Mediano</option>
                <option value="3">Grande</option>
                <option value="4">Enorme</option>
            </select>
            <label for="inputTamaño" class="is-required">Tamaño</label>
        </div>
        <div class="col-md-4 form-floating">
            <select class="form-control" id="inputSexo" name="sexo" placeholder="Mimadito" required>
                <option value="0" selected="">Seleccione una opción</option>
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
            <label for="inputSexo">Es</label>
        </div>
        <div class="col-md-4 form-floating">
            <input type="number" class="form-control" id="floatingEdad" name="edad" placeholder="Edad" min="0" title="Edad de tu mimadito" pattern="[0-9]{1,11}" >
            <label for="floatingEdad">Edad</label>
        </div>
        <h4 class="text-center text-secondary mt-4 mb-0">Seguridad</h4>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="[a-zA-Z0-9$@]{6,100}" required>
            <label for="inputPassword" class="form-label is-required">Contraseña</label>
            <div class="col-auto">
                <span id="passwordHelpInline" class="form-text">
                La contraseña debe tener mínimo 6 carácteres, puede contener letras y números, no debe contener espacios ni emojis. Se aceptan los símbolos $ @
                </span>
            </div>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="[a-zA-Z0-9$@]{6,100}" required>
            <label for="inputPassword2" class="form-label is-required">Confirme su contraseña</label>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Crear Cuenta</button>
        </div>
        <p class="text-center">Una vez acceda con su cuenta podrá registrar más datos sobre su mimadito ♥</p>

            <p class="text-center text-secondary">Ya tenes una cuenta? <a href="index.php?vista=login" class="mt-0 btn btn-outline-primary btn-sm"> Ingresa acá !</a></p>


    </form>
    <?php 
            if(isset($_POST["contraseña"]) && isset($_POST["contraseña"]) &&
            isset($_POST["contraseña2"]) && isset($_POST["contraseña2"])){
                require_once("./php/guardar_signup.php");
            }
        ?>
</div>