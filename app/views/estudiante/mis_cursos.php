<?php include '../app/views/layouts/header_estudiante.php'; ?>
<link rel="stylesheet" href="<?php echo URL_BASE; ?>css/estudiante.css">

<div class="dashboard-wrapper">

    <main class="main-content">
        <header class="content-header" style="background: linear-gradient(135deg, #232323 0%, #232323 100%); border-radius: 2rem 2rem 0 0; padding: 2.5rem 2rem 2rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <h1 style="color: #FFD740; font-size: 3.5rem; font-weight: 900; margin-bottom: 0.5rem;">Mis Inscripciones</h1>
            <p style="color: #fff; font-size: 1.5rem; margin-bottom: 0; font-weight: 400;">Gestiona tu avance académico y certificados.</p>
        </header>

        <section class="card-container">
            <?php if (empty($mis_inscripciones)): ?>
                <div class="empty-state">
                    <img src="<?php echo URL_BASE; ?>img/empty-courses.svg" alt="">
                    <p>Aún no tienes cursos inscritos.</p>
                    <a href="<?php echo URL_BASE; ?>" class="btn-primary">Explorar Cursos</a>
                </div>
            <?php else: ?>
                <div class="table-card">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Información del Curso</th>
                                <th>Modalidad</th>
                                <th>Horario</th>
                                <th>Pago</th>
                                <th>Académico</th>
                                <th>Calificación</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mis_inscripciones as $inscripcion): ?>
                                <tr>
                                    <td>
                                        <div class="course-info-cell">
                                            <span class="course-title"><?php echo $inscripcion->titulo_curso; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($inscripcion->modalidad)): ?>
                                            <span class="status-pill status-modalidad">
                                                <?php echo ucfirst($inscripcion->modalidad); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($inscripcion->horario)): ?>
                                            <span class="status-pill status-horario">
                                                <?php echo ucfirst($inscripcion->horario); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-pill status-<?php echo $inscripcion->estado_pago ?? 'pendiente'; ?>">
                                            <?php echo ucfirst($inscripcion->estado_pago ?? 'pendiente'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill academic-<?php echo $inscripcion->estado_academico; ?>">
                                            <?php echo ucfirst($inscripcion->estado_academico); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="grade-text"><?php echo $inscripcion->nota_final > 0 ? $inscripcion->nota_final : '--'; ?></span>
                                    </td>
                                    <td>
                                        <?php if ($inscripcion->estado_academico == 'aprobado' && !empty($inscripcion->certificado_path)): ?>
                                            <a href="<?php echo URL_BASE . 'uploads/certificados/' . $inscripcion->certificado_path; ?>" class="btn-action-download" download>
                                                📥 Certificado
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Paginación -->
                    <?php if ($total_paginas > 1): ?>
                        <nav aria-label="Paginación de cursos" class="mt-3">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                    <li class="page-item <?php if ($i == $pagina) echo 'active'; ?>">
                                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php include '../app/views/layouts/footer.php'; ?>