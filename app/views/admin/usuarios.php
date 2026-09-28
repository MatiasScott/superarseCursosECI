<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<?php
$msj = isset($_GET['msj']) ? $_GET['msj'] : '';

// Paginación
$por_pagina = 15;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$total = count($usuarios);
$total_paginas = (int) ceil($total / $por_pagina);
$inicio = ($pagina - 1) * $por_pagina;
$paginados = array_slice($usuarios, $inicio, $por_pagina);

$alertas = [
    'creado'           => ['alert-success', 'Usuario creado correctamente.'],
    'actualizado'      => ['alert-success', 'Usuario actualizado correctamente.'],
    'eliminado'        => ['alert-success', 'Usuario eliminado correctamente.'],
    'no_encontrado'    => ['alert-warning', 'El usuario no existe o fue eliminado.'],
    'error_propio'     => ['alert-danger', 'No puedes eliminar el usuario con el que estás conectado.'],
    'error_ultimo_admin' => ['alert-danger', 'No se puede eliminar: debe quedar al menos un administrador.'],
    'error_eliminar'   => ['alert-danger', 'No se pudo eliminar el usuario.']
];
if (isset($alertas[$msj])):
    ?>
    <div class="container mt-3">
        <div class="alert <?= $alertas[$msj][0] ?> alert-dismissible fade show" role="alert">
            <?= $alertas[$msj][1] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<div class="container admin-layout">

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Gestión de Usuarios</h2>
                    <p class="text-muted">Crea, edita y elimina administradores y estudiantes del sistema.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-mini d-flex gap-3">
                        <div class="text-right">
                            <small class="d-block text-muted">En el listado</small>
                            <span class="h5 font-weight-bold"><?= (int) $total ?></span>
                        </div>
                        <div class="text-right">
                            <small class="d-block text-muted">Administradores</small>
                            <span class="h5 font-weight-bold"><?= (int) $total_admins ?></span>
                        </div>
                    </div>
                    <a href="<?= URL_BASE ?>admin/crear_usuario" class="btn-publish">
                        <i class="fas fa-user-plus mr-2"></i> Nuevo Usuario
                    </a>
                </div>
            </div>

            <form method="get" class="mb-4">
                <div class="d-flex flex-wrap align-items-center gap-2" style="background:#fff; border-radius:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:1.2rem 1.5rem;">
                    <input type="text" name="q" class="form-control" style="max-width:320px; font-size:1.05rem; border-radius:0.7rem; border:1.5px solid #FFD740; margin-right:1rem;" placeholder="🔍 Buscar nombre, email o cédula" value="<?= htmlspecialchars($busqueda) ?>">
                    <select name="rol" class="form-control" style="max-width:200px; font-size:1.05rem; border-radius:0.7rem; border:1.5px solid #FFD740; margin-right:1rem;">
                        <option value="">Todos los roles</option>
                        <option value="admin" <?= $filtro_rol === 'admin' ? 'selected' : '' ?>>Administradores</option>
                        <option value="estudiante" <?= $filtro_rol === 'estudiante' ? 'selected' : '' ?>>Estudiantes</option>
                    </select>
                    <button type="submit" class="btn btn-warning font-weight-bold px-4 py-2" style="font-size:1.05rem; border-radius:0.7rem;">Filtrar</button>
                    <?php if ($busqueda !== '' || $filtro_rol !== ''): ?>
                        <a href="<?= URL_BASE ?>admin/usuarios" class="btn btn-outline-secondary" style="border-radius:0.7rem;">Limpiar</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="admin-card-table">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Cédula / RUC</th>
                            <th>Contacto</th>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Inscripciones</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($paginados)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">No hay usuarios que coincidan con la búsqueda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($paginados as $u): ?>
                                <?php $es_yo = isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === intval($u->id_usuario); ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark">
                                            <?= htmlspecialchars($u->nombre . ' ' . $u->apellido) ?>
                                            <?php if ($es_yo): ?>
                                                <span class="badge-admin ml-1" style="font-size:0.7rem; border-radius:10px; padding:2px 8px;">TÚ</span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">ID: #<?= $u->id_usuario ?> · Registrado: <?= empty($u->fecha_registro) ? '-' : date('d/m/Y', strtotime($u->fecha_registro)) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($u->cedula_ruc) ?></td>
                                    <td>
                                        <div><?= htmlspecialchars($u->email) ?></div>
                                        <small class="text-muted"><?= $u->telefono && $u->telefono !== 'SIN-TELEFONO' ? htmlspecialchars($u->telefono) : 'Sin teléfono' ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($u->rol === 'admin'): ?>
                                            <span class="badge-academico" style="background:#fff3e0; color:#ef6c00;">Admin</span>
                                        <?php else: ?>
                                            <span class="badge-academico estado-cursando">Estudiante</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-cupos"><?= (int) $u->total_inscripciones ?></span>
                                        <small class="text-muted d-block"><?= (int) $u->cursos_pagados ?> pagados</small>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="<?= URL_BASE ?>admin/editar_usuario/<?= $u->id_usuario ?>" class="btn-action-edit">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <?php if ($es_yo): ?>
                                                <button type="button" class="btn-action-delete" style="opacity:0.5; cursor:not-allowed;" title="No puedes eliminar tu propio usuario" disabled>
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </button>
                                            <?php else: ?>
                                                <form action="<?= URL_BASE ?>admin/eliminar_usuario" method="POST" style="display:inline;">
                                                    <input type="hidden" name="id_usuario" value="<?= $u->id_usuario ?>">
                                                    <button type="submit" class="btn-action-delete" onclick="return confirm('¿Eliminar a <?= htmlspecialchars($u->nombre . ' ' . $u->apellido, ENT_QUOTES) ?>?\n\nTambién se eliminarán sus <?= (int) $u->total_inscripciones ?> inscripción(es) y sus pagos. Esta acción no se puede deshacer.');">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ($total_paginas > 1): ?>
                                <tr>
                                    <td colspan="6">
                                        <nav aria-label="Paginación de usuarios" class="mt-3">
                                            <ul class="pagination justify-content-center">
                                                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                                    <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                                        <a class="page-link" href="?<?= $busqueda !== '' ? 'q=' . urlencode($busqueda) . '&' : '' ?><?= $filtro_rol !== '' ? 'rol=' . urlencode($filtro_rol) . '&' : '' ?>pagina=<?= $i ?>">
                                                            <?= $i ?>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </nav>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include '../app/views/layouts/footer_admin.php'; ?>
