<?php include '../app/views/layouts/header_estudiante.php'; ?>
<link rel="stylesheet" href="<?php echo URL_BASE; ?>css/estudiante.css">
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-warning text-dark font-weight-bold" style="font-size:1.5rem;">
                    <i class="fas fa-clipboard-list"></i> Mis Inscripciones
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height:180px;">
                    <span style="font-size:5rem; font-weight:900; color:#FFC107; line-height:1;"><?php echo count($inscripciones); ?></span>
                    <span style="font-size:2rem; color:#666; font-weight:600;">Inscripciones activas</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-warning text-dark font-weight-bold" style="font-size:1.5rem;">
                    <i class="fas fa-money-check-alt"></i> Estado de Pagos
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height:180px;">
                    <div class="mb-3">
                        <span style="font-size:3rem; font-weight:800; color:#FFC107;"><?php echo count($pagos_pendientes); ?></span>
                        <span class="badge badge-warning ml-2" style="font-size:1.2rem;">Pendientes</span>
                    </div>
                    <div class="mb-3">
                        <span style="font-size:3rem; font-weight:800; color:#28a745;"><?php echo count($pagos_aprobados); ?></span>
                        <span class="badge badge-success ml-2" style="font-size:1.2rem;">Aprobados</span>
                    </div>
                    <div>
                        <span style="font-size:3rem; font-weight:800; color:#dc3545;"><?php echo count($pagos_rechazados); ?></span>
                        <span class="badge badge-danger ml-2" style="font-size:1.2rem;">Rechazados</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../app/views/layouts/footer.php'; ?>
