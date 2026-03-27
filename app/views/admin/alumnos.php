<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<main class="admin-main-content">
    <div class="container container-admin-centered py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-0">Gestión Académica</h2>
                <p class="text-muted">Califica a los estudiantes y sube sus certificados de aprobación.</p>
            </div>
            <div class="stats-mini d-flex gap-3">
                <div class="text-right">
                    <small class="d-block text-muted">Total Alumnos</small>
                    <span class="h5 font-weight-bold"><?= count($inscripciones) ?></span>
                </div>
            </div>
        </div>

        <form method="get" class="mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2" style="background:#fff; border-radius:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:1.2rem 1.5rem;">
                <input type="text" name="estudiante" class="form-control" style="max-width:320px; font-size:1.15rem; border-radius:0.7rem; border:1.5px solid #FFD740; margin-right:1rem;" placeholder="🔍 Buscar por estudiante" value="<?= isset($_GET['estudiante']) ? htmlspecialchars($_GET['estudiante']) : '' ?>">
                <input type="text" name="curso" class="form-control" style="max-width:320px; font-size:1.15rem; border-radius:0.7rem; border:1.5px solid #FFD740; margin-right:1rem;" placeholder="📚 Buscar por curso" value="<?= isset($_GET['curso']) ? htmlspecialchars($_GET['curso']) : '' ?>">
                <button type="submit" class="btn btn-warning font-weight-bold px-4 py-2" style="font-size:1.15rem; border-radius:0.7rem; box-shadow:0 2px 8px rgba(255,215,64,0.12);">Buscar</button>
            </div>
        </form>
        <div class="admin-card-table">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th class="text-center">Nota</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Certificado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inscripciones)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">No hay alumnos para gestionar.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $filtro_estudiante = isset($_GET['estudiante']) ? strtolower(trim($_GET['estudiante'])) : '';
                        $filtro_curso = isset($_GET['curso']) ? strtolower(trim($_GET['curso'])) : '';
                        $filtrados = [];
                        foreach ($inscripciones as $i) {
                            $nombre_completo = strtolower($i->nombre_usuario . ' ' . $i->apellido_usuario);
                            $curso_nombre = strtolower($i->titulo_curso);
                            // Solo filtra por uno u otro, no ambos
                            if ($filtro_estudiante !== '' && $filtro_curso === '') {
                                if (strpos($nombre_completo, $filtro_estudiante) !== false) {
                                    $filtrados[] = $i;
                                }
                            } elseif ($filtro_curso !== '' && $filtro_estudiante === '') {
                                if (strpos($curso_nombre, $filtro_curso) !== false) {
                                    $filtrados[] = $i;
                                }
                            } elseif ($filtro_estudiante === '' && $filtro_curso === '') {
                                $filtrados[] = $i;
                            }
                        }
                        // Paginación
                        $por_pagina = 10;
                        $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
                        $total = count($filtrados);
                        $total_paginas = ceil($total / $por_pagina);
                        $inicio = ($pagina - 1) * $por_pagina;
                        $paginados = array_slice($filtrados, $inicio, $por_pagina);
                        foreach ($paginados as $i):
                        ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= $i->nombre_usuario ?> <?= $i->apellido_usuario ?></div>
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= $i->titulo_curso ?></div>
                                </td>
                                <td class="text-center" style="width: 110px;">
                                    <?php if (empty($i->nota_final)): ?>
                                        <form action="<?= URL_BASE ?>admin/calificar" method="POST" enctype="multipart/form-data" style="display:inline;">
                                            <input type="hidden" name="id_inscripcion" value="<?= $i->id_inscripcion ?>">
                                            <input type="number" name="nota" value="" step="0.1" min="0" max="10" class="form-control input-nota mx-auto" required>
                                            <button type="submit" class="btn-save-admin" title="Guardar" style="margin-top:4px;"><i class="fas fa-save"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <span><?= $i->nota_final ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="width: 120px;">
                                    <span class="badge-academico estado-<?= strtolower($i->estado_academico) ?>">
                                        <?= ucfirst($i->estado_academico) ?>
                                    </span>
                                </td>
                                <td class="text-center" style="width: 160px;">
                                    <?php if (empty($i->certificado_path)): ?>
                                        <form action="<?= URL_BASE ?>admin/calificar" method="POST" enctype="multipart/form-data" style="display:inline;">
                                            <input type="hidden" name="id_inscripcion" value="<?= $i->id_inscripcion ?>">
                                            <label for="f-<?= $i->id_inscripcion ?>" class="btn btn-sm btn-secondary" style="margin-right:6px;">
                                                <i class="fas fa-file-upload"></i> Seleccionar PDF
                                            </label>
                                            <input type="file" name="certificado" accept=".pdf" class="custom-file-input" id="f-<?= $i->id_inscripcion ?>" style="display:none;" required onchange="this.form.submit();">
                                        </form>
                                    <?php else: ?>
                                        <a href="<?= URL_BASE ?>uploads/certificados/<?= $i->certificado_path ?>" target="_blank" class="btn btn-sm btn-success">Ver Certificado</a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="width: 160px;">
                                    <div class="d-flex align-items-center gap-2 justify-content-center">
                                        <!-- Modificar: abre modal para editar nota y certificado -->
                                        <button type="button" class="btn btn-sm btn-warning btn-modificar-cert" data-toggle="modal" data-target="#modalEditar-<?= $i->id_inscripcion ?>">
                                            <i class="fas fa-edit"></i> Modificar
                                        </button>
                                        <!-- Eliminar: borra toda la inscripción -->
                                        <form action="<?= URL_BASE ?>admin/eliminar_inscripcion" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_inscripcion" value="<?= $i->id_inscripcion ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar inscripción completa?');"><i class="fas fa-trash"></i> Eliminar</button>
                                        </form>
                                    </div>
                                    <!-- Modal para editar nota y certificado -->
                                    <div class="modal fade" id="modalEditar-<?= $i->id_inscripcion ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel-<?= $i->id_inscripcion ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="<?= URL_BASE ?>admin/modificar_inscripcion" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditarLabel-<?= $i->id_inscripcion ?>">Modificar Nota y Certificado</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_inscripcion" value="<?= $i->id_inscripcion ?>">
                                                        <div class="form-group">
                                                            <label for="nota-<?= $i->id_inscripcion ?>">Nota</label>
                                                            <input type="number" name="nota" id="nota-<?= $i->id_inscripcion ?>" value="<?= $i->nota_final ?>" step="0.1" min="0" max="10" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="certificado-<?= $i->id_inscripcion ?>">Certificado (PDF)</label>
                                                            <input type="file" name="certificado" id="certificado-<?= $i->id_inscripcion ?>" accept=".pdf" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Paginación -->
                        <?php if ($total_paginas > 1): ?>
                            <tr>
                                <td colspan="5">
                                    <nav aria-label="Paginación de alumnos" class="mt-3">
                                        <ul class="pagination justify-content-center">
                                            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                                <li class="page-item <?php if ($i == $pagina) echo 'active'; ?>">
                                                    <a class="page-link" href="?pagina=<?= $i ?><?php if ($filtro_estudiante) echo '&estudiante=' . urlencode($filtro_estudiante); ?><?php if ($filtro_curso) echo '&curso=' . urlencode($filtro_curso); ?>">
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

<script>
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', e => {
            let fileName = e.target.files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>

<?php include '../app/views/layouts/footer_admin.php'; ?>