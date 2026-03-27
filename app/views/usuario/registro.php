<?php include '../app/views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/login.css">

<div class="flex-center">
    <div class="card-login shadow">
        <div class="text-center mb-4">
            <h2>Crea tu cuenta</h2>
            <p class="text-muted">Completa tus datos para finalizar tu inscripción</p>
        </div>

        <form action="<?php echo URL_BASE; ?>usuario/guardar" method="POST">
            <div class="form-group mb-3">
                <input type="text" name="cedula_ruc" placeholder="Cédula o RUC" class="form-control" required>
            </div>

            <div class="row no-gutters mb-3">
                <div class="col-6 pr-1">
                    <input type="text" name="nombre" placeholder="Nombres" class="form-control" required>
                </div>
                <div class="col-6 pl-1">
                    <input type="text" name="apellido" placeholder="Apellidos" class="form-control" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <input type="email" name="email" placeholder="Correo electrónico" class="form-control" required>
            </div>

            <div class="form-group mb-4">
                <input type="password" name="password" placeholder="Crea una contraseña segura" class="form-control" required>
            </div>

            <button type="submit" class="btn-login-main w-100">
                Registrarse e Inscribirse
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <p class="small mb-2">¿Ya tienes cuenta?</p>
            <a href="<?php echo URL_BASE; ?>usuario/login" class="text-dark font-weight-bold" style="text-decoration: underline;">
                Solo Iniciar Sesión
            </a>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>