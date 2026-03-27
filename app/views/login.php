<?php include '../app/views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/login.css">

<div class="flex-center min-h-80">
    <div class="card-login shadow">
        <div class="text-center mb-4">
            <i class="fas fa-user-circle fa-4x mb-3" style="color: var(--accent-color);"></i>
            <h2>Bienvenido</h2>
            <p class="text-muted">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center py-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo URL_BASE; ?>usuario/autenticar" method="POST">
            <div class="form-group mb-3">
                <label><i class="fas fa-envelope mr-1"></i> Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required placeholder="tu@correo.com">
            </div>
            <div class="form-group mb-4">
                <label><i class="fas fa-lock mr-1"></i> Contraseña</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login-main w-100">Entrar al Sistema</button>
        </form>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>