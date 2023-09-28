<?php 
var_dump($_SESSION);
echo $_SESSION["cuenta"] == "google" ? '<a href="index.php?vistas=glogout.php">Cerrar Google</a>'  : "";

?>


<h1>Hola <?php echo $_SESSION["nombre"] ?> !</h1>.