<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educación Continua - Cursos Online</title>
    <link rel="stylesheet" href="<?= URL_BASE ?>css/global.css">
    <link rel="icon" type="image/png" href="<?= URL_BASE ?>img/logoSuperarse.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= URL_BASE ?>">
                    <img src="<?= URL_BASE ?>img/logoSuperarse.png" class="logo-img" alt="Logo">
                    <div class="logo-text ml-2">
                        <span class="logo-main">Educación Continua</span>
                        <span class="logo-sub">e Inglés</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="<?= URL_BASE ?>">INICIO</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="https://superarse.edu.ec/" target="_blank">INSTITUTO</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-link-custom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                CONGRESOS
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 dropdown-custom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item dropdown-item-custom" href="https://agrovet.superarse.ec/" target="_blank">
                                    <i class="fas fa-leaf"></i> Agrovet
                                </a>
                                <a class="dropdown-item dropdown-item-custom" href="https://2ctm.superarse.ec/" target="_blank">
                                    <i class="fas fa-microchip"></i> II CTM 2025
                                </a>
                            </div>
                        </li>

                        <li class="nav-item ml-lg-2">
                            <a href="<?= URL_BASE ?>usuario/login" class="btn-mi-panel">
                                <i class="fas fa-user-circle"></i> MI PANEL
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>