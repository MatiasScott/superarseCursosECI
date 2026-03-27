<?php
include '../app/views/layouts/header_admin.php';
?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<div class="container admin-layout">

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3">Resumen del Sistema</h2>
                <span class="text-muted"><i class="far fa-calendar-alt"></i> Hoy es <?= date('d/m/Y') ?></span>
            </div>

            <div class="stats-grid">
                <div class="stat-card info">
                    <div>
                        <h3>Cursos Activos</h3>
                        <p class="number"><?= $data['total_cursos'] ?></p>
                    </div>
                    <i class="fas fa-graduation-cap"></i>
                </div>

                <div class="stat-card warning">
                    <div>
                        <h3>Pagos por Validar</h3>
                        <p class="number"><?= $data['pagos_pendientes'] ?></p>
                        <a href="<?= URL_BASE ?>admin/pagos" class="small text-warning font-weight-bold">Revisar ahora →</a>
                    </div>
                    <i class="fas fa-money-check-alt"></i>
                </div>

                <div class="stat-card success">
                    <div>
                        <h3>Inscritos Hoy</h3>
                        <p class="number"><?= $data['inscritos_hoy'] ?></p>
                    </div>
                    <i class="fas fa-user-plus"></i>
                </div>

                <div class="stat-card">
                    <div>
                        <h3>Ingresos Mes</h3>
                        <p class="number">$<?= number_format($data['ingresos_mes'], 2) ?></p>
                    </div>
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>

            <div class="dashboard-lower-grid">
                <div class="quick-view-card">
                    <h4 class="h5 mb-3 border-bottom pb-2">Inscripciones Recientes</h4>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Curso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['ultimas_inscripciones'] as $reg): ?>
                                <tr>
                                    <td><?= $reg->nombre_usuario ?></td>
                                    <td><small><?= $reg->titulo_curso ?></small></td>
                                    <td><span class="badge badge-light"><?= $reg->estado_pago ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="<?= URL_BASE ?>admin/alumnos" class="btn btn-sm btn-block btn-outline-dark mt-2">Ver todos los alumnos</a>
                </div>

                <div class="quick-view-card">
                    <h4 class="h5 mb-3 border-bottom pb-2">Acciones Rápidas</h4>
                    <div class="list-group list-group-flush">
                        <a href="<?= URL_BASE ?>admin/crear_curso" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle text-success mr-2"></i> Crear nuevo curso
                        </a>
                        <a href="<?= URL_BASE ?>admin/pagos" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-invoice-dollar text-primary mr-2"></i> Validar transferencias
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include '../app/views/layouts/footer_admin.php'; ?>

                        <!--<a href="<?= URL_BASE ?>public/admin/reportes" class="list-group-item list-group-item-action">
                            <i class="fas fa-download text-muted mr-2"></i> Descargar reportes
                        </a>



