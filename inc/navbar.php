<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?vista=home">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php 
            if($_SESSION["user"] == "emp" && $_SESSION["rol"] >= 1 && $_SESSION["rol"] <= 3 )
            {
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Servicios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=servicio_new">Nuevo</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=servicio_list">Lista</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=servicio_search"> Buscar </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Horario
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=horario_new">Nuevo</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=horario_list">Lista</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Reservas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=reserva_pen">Pendientes</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=reserva_con">Confirmados</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=cliente_new"> Nuevo</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=cliente_list"> Lista</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=cliente_search">  Buscar </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mimaditos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=mascota_list">Lista de Mimaditos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?vista=raza">Nueva Raza de Mimaditos</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=raza_list">Lista de Razas de Mimaditos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?vista=tipo">Nuevo Tipo de Mimaditos</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=tipo_list">Lista de Tipo de Mimaditos</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Usuarios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=user_new">Nuevo</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=user_list">Lista</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=user_search"> Buscar </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-current="page" aria-expanded="false">
                    Dashboard
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=calendar">Calendario</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=horario_list">Horarios</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=wsp">Wasap</a></li>
                    </ul>
                </li>
            </ul>
        <div class="d-flex">
            <a href="index.php?vista=user_update&user_id_upd=<?php echo $_SESSION['id']?>" class="btn btn-outline-info">
                Mi Perfil
            </a>
            <a href="index.php?vista=logout" class="btn btn-outline-secondary" role="button">
                Salir
            </a>
        </div>
    </div>
    <?php 
    } else if($_SESSION["user"] == "cli" && $_SESSION["rol"] == 4)
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
        <a href="index.php?vista=perfil&user_id=<?php echo $_SESSION['id']?>" class="btn btn-outline-info">
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