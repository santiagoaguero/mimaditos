<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reservas</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Nuevo</a></li>
                        <li><a class="dropdown-item" href="#">Lista</a></li>
                        <li><a class="dropdown-item" href="#"> Buscar </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Usuarios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Nuevo</a></li>
                        <li><a class="dropdown-item" href="#">Lista</a></li>
                        <li><a class="dropdown-item" href="#"> Buscar </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dashboard
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=turnos">Turnos</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=calendar">Calendario</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=horarios">Horarios</a></li>
                    </ul>
                </li>
            </ul>
        <div class="d-flex">
            <a class="btn btn-outline-info" href="#" role="button">Mi Perfil</a>

            <!-- <a href="index.php?vista=user_update&user_id_upd=<?php echo $_SESSION['id']?>" class="btn btn-secondary">
                Mi Perfil
            </a> -->
            <a href="index.php?vista=logout" class="btn btn-outline-secondary" role="button">
                Salir
            </a>
        </div>
    </div>
    </div>
</nav>