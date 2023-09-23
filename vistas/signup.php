<div class="container">
    <form class="signup row g-3 shadow" method="POST" action="./php/guardar_signup.php" autocomplete="off">
        <div class="text-center">
            <img src="./img/logo.png" alt="reservet"  class="img-logo">
        </div>
        <h3 class="text-center">Bienvenido!</h3>
        <p class="text-center">Gracias por elegirnos para cuidar a tu mimado, por favor introduce tus datos para conocernos más</p>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputName" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required>
            <label for="inputName">Nombre</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{3,40}" required>
            <label for="inputApellido">Apellido</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" required>
            <label for="inputTelefono">Teléfono</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputCiudad" name="ciudad" placeholder="Ciudad">
            <label for="inputCiudad">Ciudad</label>
        </div>
        <div class="col-12 form-floating">
            <input type="text" class="form-control" id="inputAddress" name="direccion" placeholder="Direccion">
            <label for="inputAddress" class="form-label">Dirección</label>
        </div>
        <div class="col-md-6 form-floating">
            <input type="text" class="form-control" id="inputMascota" name="mascota" placeholder="Mimadito" >
            <label for="inputMascota">Nombre de tu mimadito</label>
        </div>
        <div class="col-md-6 form-floating">
            <select class="form-control" id="inputTamaño" name="tamaño" placeholder="Mimadito">
                <option value="0" selected="">Seleccione un tamaño</option>
                <option value="1">Pequeño</option>
                <option value="2">Mediano</option>
                <option value="3">Grande</option>
            </select>
            <label for="inputTamaño">Tamaño</label>
        </div>
        <div class="col-md-12 form-floating">
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="name@example.com" required>
            <label for="inputEmail4">Email</label>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword" name="contraseña" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{6,100}" required>
            <label for="inputPassword" class="form-label">Contraseña</label>
        </div>
        <div class="col-12 form-floating">
            <input type="password" class="form-control" id="inputPassword2" name="contraseña2" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{6,100}" required>
            <label for="inputPassword2" class="form-label">Confirme su contraseña</label>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Crear Cuenta</button>
        </div>
        <p class="text-center">Una vez accesa a su cuenta podrá registrar más datos sobre su mimadito ♥</p>
    </form>
</div>