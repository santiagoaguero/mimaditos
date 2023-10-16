<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?vista=home">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php 
        
        if($_SESSION["user"] == "cli" && $_SESSION["rol"] == 4)
            {
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item ">
                <a class="nav-link active" aria-current="page" href="index.php?vista=calendar">Reservar</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link active" aria-current="page" href="index.php?vista=servicios">Servicios</a>
            </li>
            <li class="nav-item ">
            <a class="nav-link active" aria-current="page" href="index.php?vista=horario">Horario</a>
            </li>
        </ul>
    <div class="d-flex">
        <a href="index.php?vista=perfil&user=<?php echo $_SESSION['usuario']?>" class="btn btn-outline-info">
            Mi Perfil
        </a>
        <a href="index.php?vista=logout" class="btn btn-outline-secondary" role="button">
            Salir
        </a>
    </div>
</div>
<?php

    } else {
        if(headers_sent()){//si ya se enviaron headers se redirecciona con js porque con php da errores.  
            echo '
            <script>
                window.location.href="index.php?vista=logout"
            </script>
            ';
        } else {
            header("Location: index.php?vista=logout");
        }
    }
    ?>
    </div>
</nav>