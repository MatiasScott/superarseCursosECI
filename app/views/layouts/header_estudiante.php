<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante - Superarse</title>
    <link rel="icon" type="image/png" href="<?= URL_BASE ?>img/logoSuperarse.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>css/global.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-estudiante">
        <div class="container">
            <a class="navbar-brand" href="<?= URL_BASE ?>home">
                <img src="<?= URL_BASE ?>img/logoSuperarse.png" alt="Logo" class="logo-header">
                <span class="brand-text">Portal Estudiante</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navEstudiante">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navEstudiante">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_BASE ?>estudiante/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_BASE ?>estudiante/catalogo">
                            <i class="fas fa-th-list"></i> Cursos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_BASE ?>estudiante/mis_cursos">
                            <i class="fas fa-book-reader"></i> Mis Cursos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_BASE ?>estudiante/pagos">
                            <i class="fas fa-receipt"></i> Mis Pagos
                        </a>
                    </li>

                    <li class="nav-item dropdown ml-lg-3">
                        <a class="nav-link dropdown-toggle user-profile-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user-avatar-mini">
                                <?= isset($_SESSION['nombre']) ? strtoupper(substr($_SESSION['nombre'], 0, 1)) : 'U' ?>
                            </div>
                            <span class="d-none d-md-inline">
                                <?= $_SESSION['nombre'] ?? 'Usuario' ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                            <a class="dropdown-item" href="<?= URL_BASE ?>estudiante/perfil">
                                <i class="fas fa-user-cog mr-2"></i> Mi Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= URL_BASE ?>usuario/logout">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>