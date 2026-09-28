<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<?php if (isset($_GET['error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<div class="container admin-layout" style="display: flex;">>

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Crear Usuario</h2>
                    <p class="text-muted">Registra un nuevo administrador o estudiante.</p>
                </div>
                <a href="<?= URL_BASE ?>admin/usuarios" class="btn-cancel-admin">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                </a>
            </div>

            <form action="<?= URL_BASE ?>admin/guardar_usuario" method="POST" class="admin-form-container">
                <div class="form-section-title">Datos Personales</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Cédula / RUC</label>
                            <input type="text" name="cedula_ruc" value="<?= htmlspecialchars($_GET['cedula_ruc'] ?? '') ?>" maxlength="13" required class="form-control-admin" placeholder="1712345678">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>" maxlength="20" class="form-control-admin" placeholder="0991234567 (opcional)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nombres</label>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>" maxlength="100" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Apellidos</label>
                            <input type="text" name="apellido" value="<?= htmlspecialchars($_GET['apellido'] ?? '') ?>" maxlength="100" required class="form-control-admin">
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Acceso al Sistema</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Correo Electrónico</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" maxlength="150" required class="form-control-admin" placeholder="usuario@superarse.edu.ec">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" minlength="6" required class="form-control-admin" placeholder="Mínimo 6 caracteres">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Rol</label>
                            <select name="rol" class="form-control-admin">
                                <option value="estudiante" <?= (($_GET['rol'] ?? '') !== 'admin') ? 'selected' : '' ?>>👨‍🎓 Estudiante</option>
                                <option value="admin" <?= (($_GET['rol'] ?? '') === 'admin') ? 'selected' : '' ?>>🛡️ Administrador</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-3">
                    <a href="<?= URL_BASE ?>admin/usuarios" class="btn-cancel-admin">Cancelar</a>
                    <button type="submit" class="btn-publish">
                        <i class="fas fa-check-circle mr-1"></i> Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include '../app/views/layouts/footer_admin.php'; ?>
