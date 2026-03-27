<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Superarse</title>
    <link rel="icon" type="image/png" href="<?= URL_BASE ?>img/logoSuperarse.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>css/global.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-admin sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= URL_BASE ?>admin/dashboard">
                <img src="<?= URL_BASE ?>img/logoSuperarse.png" alt="Logo" height="40">
                <span class="text-white ml-2" style="font-size: 0.9rem; border-left: 1px solid #555; padding-left: 10px;">ADMINISTRACIÓN</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navAdmin">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-admin" href="<?= URL_BASE ?>admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a> 
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-admin" href="<?= URL_BASE ?>admin/cursos">
                            <i class="fas fa-graduation-cap"></i> Gestionar Cursos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-admin" href="<?= URL_BASE ?>admin/pagos">
                            <i class="fas fa-money-check-alt"></i> Validar Pagos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-admin" href="<?= URL_BASE ?>admin/alumnos">
                            <i class="fas fa-users"></i> Estudiantes
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="user-info-admin d-none d-md-inline">
                        <i class="fas fa-user-shield mr-1"></i> Admin: <?= $_SESSION['nombre']; ?>
                    </span>
                    <a href="<?= URL_BASE ?>usuario/logout" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>