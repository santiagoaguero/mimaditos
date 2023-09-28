<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">Reservas</a>
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
                        <li><a class="dropdown-item" href="index.php?vista=mimadito_list">Lista de Mimaditos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?vista=tipo_mimadito">Nuevo Tipo de Mimaditos</a></li>
                        <li><a class="dropdown-item" href="index.php?vista=tipo_mimadito">Lista de Tipo de Mimaditos</a></li>
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
                    <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-current="page" aria-expanded="false">
                    Dashboard
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?vista=calendar">Calendario</a></li>
                        <li><a class="dropdown-item" href="#">Horarios</a></li>
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