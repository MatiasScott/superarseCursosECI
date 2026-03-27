<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<div class="container admin-layout">

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Listado de Cursos</h2>
                    <!-- <h2><?= print_r($modalidades) ?></h2> -->
                    <p class="text-muted">Administra la oferta académica, precios y disponibilidad.</p>
                </div>
                <a href="<?= URL_BASE ?>admin/crear_curso" class="btn-publish">
                    <i class="fas fa-plus mr-2"></i> Nuevo Curso
                </a>
            </div>

            <div class="admin-card-table">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Portada</th>
                            <th>Información del Curso</th>
                            <th class="text-center">Precios Modalidad</th>
                            <th class="text-center">Disponibilidad</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cursos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">No hay cursos registrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cursos as $c): ?>
                                <?php if (empty($c->id_curso) || empty($c->titulo)) continue; ?>
                                <tr>
                                    <td>
                                        <img src="<?= URL_BASE ?>img/cursos/<?= $c->imagen_portada ?>" class="img-mini-curso">
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark"><?= $c->titulo ?></div>
                                        <small class="text-muted">ID: #<?= $c->id_curso ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div style="display: flex; flex-direction: column; gap: 0.2em; align-items: center;">
                                            <?php if (!empty($c->modalidades) && is_array($c->modalidades)): ?>
                                                <?php foreach ($c->modalidades as $mod): ?>
                                                    <span class="badge-price" title="<?= htmlspecialchars($mod->nombre) ?>" style="background:#fffbe7;color:#bfa100;border:1px solid #ffe082;margin-bottom:2px;">
                                                        <?php
                                                        if (stripos($mod->nombre, 'intensivo') !== false) {
                                                            echo '<i class="fas fa-bolt" style="color:#ffb300;margin-right:2px;"></i>';
                                                        } elseif (stripos($mod->nombre, 'presencial') !== false) {
                                                            echo '<i class="fas fa-users" style="color:#4caf50;margin-right:2px;"></i>';
                                                        } elseif (stripos($mod->nombre, 'híbrida') !== false || stripos($mod->nombre, 'hibrida') !== false) {
                                                            echo '<i class="fas fa-laptop-house" style="color:#2196f3;margin-right:2px;"></i>';
                                                        } else {
                                                            echo '<i class="fas fa-graduation-cap" style="color:#bfa100;margin-right:2px;"></i>';
                                                        }
                                                        ?>
                                                        <?= htmlspecialchars($mod->nombre) ?>: $<?= number_format($mod->precio, 2) ?>
                                                        <?php if (isset($mod->cupos)): ?>
                                                            <span style="font-size:0.97em; color:#e67e22; font-weight:600; margin-left:6px;"><i class="fas fa-users"></i> <?= $mod->cupos ?> cupos</span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($mod->horarios)): ?>
                                                            <br><span style="font-size:0.95em; color:#888;">Horario: <?= htmlspecialchars($mod->horarios) ?></span>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin modalidades</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        // Sumar cupos de todas las modalidades
                                        $cupos_modalidades = 0;
                                        if (!empty($c->modalidades) && is_array($c->modalidades)) {
                                            foreach ($c->modalidades as $mod) {
                                                if (isset($mod->cupos)) {
                                                    $cupos_modalidades += intval($mod->cupos);
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="badge-cupos" style="margin-bottom:4px;">
                                            <i class="fas fa-users mr-1"></i> <?= $cupos_modalidades ?> cupos modalidades
                                        </div>
                                        <div class="badge-cupos" style="background:#f5f5f5; color:#888; border:1px solid #e0e0e0;">
                                            <i class="fas fa-database mr-1"></i> <?= $c->cupos_disponibles ?> cupos totales
                                        </div>
                                    </td>
                                    <td class="text-right" style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.4em;">
                                        <a href="<?= URL_BASE ?>admin/editar_curso/<?= $c->id_curso ?>" class="btn-action-edit" style="width: 140px;">
                                            <i class="fas fa-edit"></i> Editar Info
                                        </a>
                                        <a href="<?= URL_BASE ?>admin/eliminar_curso/<?= $c->id_curso ?>" class="btn-action-delete" onclick="return confirm('¿Estás seguro de eliminar este curso? Esta acción no se puede deshacer.');" style="width: 140px; background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; border-radius: 6px; padding: 0.45em 0.8em; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.5em; margin-top: 2px;">
                                            <i class="fas fa-trash-alt" style="color: #c62828;"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include '../app/views/layouts/footer_admin.php'; ?>