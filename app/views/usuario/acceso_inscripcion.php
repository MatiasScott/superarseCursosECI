<?php include '../app/views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/login.css">

<main class="flex-center">
    <div class="card-acceso">
        <div class="text-center mb-5">
            <h2 class="display-5 font-weight-bold">¡Casi listo para empezar!</h2>
            <p class="text-muted">Para completar tu inscripción al curso, necesitamos identificarte.</p>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="opcion-card text-center p-4 rounded shadow-sm h-100">
                    <div class="icon-box"><i class="fas fa-user-plus"></i></div>
                    <h3>Nuevo Estudiante</h3>
                    <p class="small text-muted mb-4">Crea una cuenta para gestionar tus cursos y certificados en el futuro.</p>
                    <a href="<?= URL_BASE ?>usuario/registro" class="btn btn-outline-dark btn-block font-weight-bold">CREAR CUENTA</a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="opcion-card highlight text-center p-4 rounded shadow-sm h-100">
                    <div class="icon-box"><i class="fas fa-key"></i></div>
                    <h3>Ya tengo cuenta</h3>
                    <p class="small text-muted mb-4">Si ya eres parte de Educación Continua, inicia sesión para finalizar.</p>
                    <a href="<?= URL_BASE ?>usuario/login" class="btn-login-main btn-block">INICIAR SESIÓN</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 border-top pt-4">
            <a href="<?= URL_BASE ?>" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Volver al catálogo de cursos</a>
        </div>
    </div>
</main>

<?php include '../app/views/layouts/footer.php'; ?>