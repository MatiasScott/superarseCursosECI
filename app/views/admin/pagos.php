<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<div class="container admin-layout">

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Verificación de Pagos</h2>
                    <p class="text-muted">Revisa las transferencias y aprueba el acceso a los cursos.</p>
                </div>
                <div class="badge badge-warning p-2">
                    <i class="fas fa-clock mr-1"></i> Pendientes: <?= count($pagos_pendientes) ?>
                </div>
            </div>

            <form method="get" class="mb-4">
                <div class="d-flex flex-wrap align-items-center gap-2" style="background:#fff; border-radius:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:1.2rem 1.5rem;">
                    <input type="text" name="usuario" class="form-control" style="max-width:400px; font-size:1.2rem; border-radius:0.7rem; border:1.5px solid #FFD740; margin-right:1rem;" placeholder="🔍 Buscar por nombre de usuario" value="<?= isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : '' ?>">
                    <button type="submit" class="btn btn-warning font-weight-bold px-4 py-2" style="font-size:1.2rem; border-radius:0.7rem; box-shadow:0 2px 8px rgba(255,215,64,0.12);">Buscar</button>
                </div>
            </form>
            <div class="admin-card-table">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Curso</th>
                            <th class="text-center">Método</th>
                            <th class="text-center">Comprobante</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pagos_pendientes)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-check-double fa-3x mb-3 d-block text-success"></i>
                                    No hay pagos pendientes por verificar.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $filtro_usuario = isset($_GET['usuario']) ? strtolower(trim($_GET['usuario'])) : '';
                            $filtrados = [];
                            foreach ($pagos_pendientes as $pago) {
                                $nombre_usuario = strtolower($pago->nombre_usuario);
                                if ($filtro_usuario === '' || strpos($nombre_usuario, $filtro_usuario) !== false) {
                                    $filtrados[] = $pago;
                                }
                            }
                            // Paginación
                            $por_pagina = 10;
                            $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
                            $total = count($filtrados);
                            $total_paginas = ceil($total / $por_pagina);
                            $inicio = ($pagina - 1) * $por_pagina;
                            $paginados = array_slice($filtrados, $inicio, $por_pagina);
                            foreach ($paginados as $pago):
                            ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold"><?= $pago->nombre_usuario ?></div>
                                        <small class="text-muted">Estudiante</small>
                                    </td>
                                    <td>
                                        <span class="text-dark"><?= $pago->titulo_curso ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-method">
                                            <i class="fas fa-university mr-1"></i> <?= ucfirst($pago->metodo_pago) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="comprobante-container">
                                            <?php if (!empty($pago->comprobante_archivo)): ?>
                                                <a href="<?= URL_BASE; ?>uploads/comprobantes/<?= $pago->comprobante_archivo ?>"
                                                    target="_blank"
                                                    class="btn-view-pdf"
                                                    title="Ver comprobante de pago">
                                                    <i class="fas fa-file-pdf"></i> Ver PDF
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin archivo</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <form action="<?= URL_BASE; ?>admin/aprobar_pago" method="POST" class="d-inline">
                                            <input type="hidden" name="id_pago" value="<?= $pago->id_pago; ?>">
                                            <button type="submit" class="btn-approve mr-1" title="Aprobar Pago">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="submit" name="accion" value="rechazar" class="btn-reject" title="Rechazar Pago">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Paginación -->
                            <?php if ($total_paginas > 1): ?>
                                <tr>
                                    <td colspan="5">
                                        <nav aria-label="Paginación de pagos" class="mt-3">
                                            <ul class="pagination justify-content-center">
                                                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                                    <li class="page-item <?php if ($i == $pagina) echo 'active'; ?>">
                                                        <a class="page-link" href="?pagina=<?= $i ?><?php if ($filtro_usuario) echo '&usuario=' . urlencode($filtro_usuario); ?>">
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