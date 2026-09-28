<?php
$es_yo = isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === intval($usuario->id_usuario);
$rol_actual = isset($_GET['rol']) ? $_GET['rol'] : $usuario->rol;
$cedula_actual = isset($_GET['cedula_ruc']) ? $_GET['cedula_ruc'] : $usuario->cedula_ruc;
$nombre_actual = isset($_GET['nombre']) ? $_GET['nombre'] : $usuario->nombre;
$apellido_actual = isset($_GET['apellido']) ? $_GET['apellido'] : $usuario->apellido;
$email_actual = isset($_GET['email']) ? $_GET['email'] : $usuario->email;
$telefono_actual = isset($_GET['telefono']) ? $_GET['telefono'] : $usuario->telefono;
?>
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
                    <h2 class="h3 mb-0">Editar Usuario</h2>
                    <p class="text-muted">Modificando: <strong><?= htmlspecialchars($usuario->nombre . ' ' . $usuario->apellido) ?></strong> (ID #<?= $usuario->id_usuario ?>)</p>
                </div>
                <a href="<?= URL_BASE ?>admin/usuarios" class="btn-cancel-admin">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                </a>
            </div>

            <form action="<?= URL_BASE ?>admin/guardar_edicion_usuario" method="POST" class="admin-form-container">
                <input type="hidden" name="id_usuario" value="<?= $usuario->id_usuario ?>">

                <div class="form-section-title">Datos Personales</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Cédula / RUC</label>
                            <input type="text" name="cedula_ruc" value="<?= htmlspecialchars($cedula_actual) ?>" maxlength="13" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" value="<?= ($telefono_actual === 'SIN-TELEFONO') ? '' : htmlspecialchars($telefono_actual) ?>" maxlength="20" class="form-control-admin" placeholder="Sin teléfono">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nombres</label>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($nombre_actual) ?>" maxlength="100" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Apellidos</label>
                            <input type="text" name="apellido" value="<?= htmlspecialchars($apellido_actual) ?>" maxlength="100" required class="form-control-admin">
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Acceso al Sistema</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Correo Electrónico</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($email_actual) ?>" maxlength="150" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Rol</label>
                            <select name="rol" class="form-control-admin" <?= $es_yo ? 'disabled' : '' ?>>
                                <option value="estudiante" <?= $rol_actual === 'estudiante' ? 'selected' : '' ?>>👨‍🎓 Estudiante</option>
                                <option value="admin" <?= $rol_actual === 'admin' ? 'selected' : '' ?>>🛡️ Administrador</option>
                            </select>
                            <?php if ($es_yo): ?>
                                <input type="hidden" name="rol" value="<?= $rol_actual ?>">
                                <small class="text-muted">No puedes cambiar tu propio rol.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Nueva Contraseña</label>
                            <input type="password" name="password" minlength="6" class="form-control-admin" placeholder="Dejar vacío = igual">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info py-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Este usuario tiene <strong><?= (int) $total_inscripciones ?></strong> inscripción(es) registradas en el sistema.
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-3">
                    <a href="<?= URL_BASE ?>admin/usuarios" class="btn-cancel-admin">Descartar Cambios</a>
                    <button type="submit" class="btn-publish">
                        <i class="fas fa-check-circle mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>

            <div class="admin-form-container mt-4 d-flex justify-content-between align-items-center">
                <div>
                    <strong class="text-dark">Zona de riesgo</strong>
                    <p class="text-muted mb-0">
                        Al eliminar este usuario se borran también sus
                        <strong><?= (int) $total_inscripciones ?></strong> inscripción(es) y sus pagos.
                    </p>
                </div>
                <?php if ($es_yo): ?>
                    <button type="button" class="btn-action-delete" style="opacity:0.5; cursor:not-allowed;" title="No puedes eliminar tu propio usuario" disabled>
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                <?php else: ?>
                    <form action="<?= URL_BASE ?>admin/eliminar_usuario" method="POST" onsubmit="return confirm('¿Eliminar a <?= htmlspecialchars($usuario->nombre . ' ' . $usuario->apellido, ENT_QUOTES) ?>?\n\nTambién se eliminarán sus <?= (int) $total_inscripciones ?> inscripción(es) y sus pagos. Esta acción no se puede deshacer.');">
                        <input type="hidden" name="id_usuario" value="<?= $usuario->id_usuario ?>">
                        <button type="submit" class="btn-action-delete">
                            <i class="fas fa-trash-alt"></i> Eliminar Usuario
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php include '../app/views/layouts/footer_admin.php'; ?>
