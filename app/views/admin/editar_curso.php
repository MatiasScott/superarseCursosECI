<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<div class="container admin-layout" style="display: flex;">

    <main class="admin-main-content">
        <div class="container container-admin-centered py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Editar Curso</h2>
                    <!-- <h2><?= print_r($modalidades) ?></h2> -->
                    <p class="text-muted">Modificando: <strong><?= $curso->titulo ?></strong></p>
                </div>
                <a href="<?= URL_BASE ?>admin/cursos" class="btn-cancel-admin">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                </a>
            </div>

            <form action="<?= URL_BASE ?>admin/guardar_edicion" method="POST" enctype="multipart/form-data" class="admin-form-container">
                <input type="hidden" name="imagen_portada_actual" value="<?= $curso->imagen_portada ?>">
                <input type="hidden" name="id_curso" value="<?= $curso->id_curso ?>">

                <div class="form-section-title">Información Básica</div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label>Título del Curso</label>
                            <input type="text" name="titulo" value="<?= $curso->titulo ?>" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Estado del Curso</label>
                            <select name="estado" class="form-control-admin">
                                <option value="activo" <?= $curso->estado == 'activo' ? 'selected' : '' ?>>✅ Activo / Publicado</option>
                                <option value="inactivo" <?= $curso->estado == 'inactivo' ? 'selected' : '' ?>>🚫 Inactivo / Borrador</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Fechas, Cupos y Precio</div>
                <div class="form-section-title">Modalidades</div>
                <div class="row">
                    <?php if (!empty($modalidades)): ?>
                        <?php foreach ($modalidades as $i => $mod): ?>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Nombre Modalidad</label>
                                    <input type="text" name="modalidades[<?= $i ?>][nombre]" value="<?= htmlspecialchars($mod->nombre) ?>" class="form-control-admin" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Precio ($)</label>
                                    <input type="number" step="0.01" name="modalidades[<?= $i ?>][precio]" value="<?= floatval($mod->precio) ?>" class="form-control-admin" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Cupos de esta modalidad</label>
                                    <input type="number" min="0" name="modalidades[<?= $i ?>][cupos]" value="<?= isset($mod->cupos) ? intval($mod->cupos) : 0 ?>" class="form-control-admin" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>¿Qué incluye?</label>
                                    <textarea name="modalidades[<?= $i ?>][descripcion]" rows="2" class="form-control-admin"><?= htmlspecialchars($mod->descripcion) ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Horarios</label>
                                    <input type="text" name="modalidades[<?= $i ?>][horarios]" value="<?= htmlspecialchars($mod->horarios) ?>" class="form-control-admin" placeholder="Ej: Lunes a Viernes 18-21h">
                                </div>
                                <input type="hidden" name="modalidades[<?= $i ?>][id]" value="<?= $mod->id ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12"><div class="alert alert-warning">No hay modalidades registradas para este curso.</div></div>
                    <?php endif; ?>
                </div>

                <div class="form-section-title">Cupos y Fechas</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Inicio del Curso</label>
                            <input type="date" name="fecha_inicio" value="<?= $curso->fecha_inicio ?>" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Fin del Curso</label>
                            <input type="date" name="fecha_fin" value="<?= $curso->fecha_fin ?>" required class="form-control-admin">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Límite Inscripción</label>
                            <input type="date" name="fecha_limite_inscripcion" value="<?= $curso->fecha_limite_inscripcion ?>" class="form-control-admin">
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Imagen de Portada</div>
                <div class="row align-items-center mb-4">
                    <div class="col-md-2">
                        <img src="<?= URL_BASE ?>img/cursos/<?= $curso->imagen_portada ?>" class="img-thumbnail shadow-sm" style="height: 80px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-10">
                        <div class="custom-file">
                            <input type="file" name="imagen_portada" class="custom-file-input" id="portadaEdicion" accept="image/*">
                            <label class="custom-file-label" for="portadaEdicion">Cambiar imagen de portada...</label>
                        </div>
                        <small class="text-muted">Deja este campo vacío si no deseas cambiar la imagen actual.</small>
                    </div>
                </div>

                <div class="form-section-title">Descripción y Pestañas</div>
                <div class="form-group mb-3">
                    <label>Descripción Corta (Vista previa)</label>
                    <textarea name="descripcion_corta" rows="2" class="form-control-admin"><?= $curso->descripcion_corta ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Objetivos</label>
                            <textarea name="objetivos" rows="5" class="form-control-admin"><?= $curso->objetivos ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Programa / Temario</label>
                            <textarea name="programa" rows="5" class="form-control-admin"><?= $curso->programa ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Requisitos</label>
                            <textarea name="requisitos" rows="3" class="form-control-admin"><?= $curso->requisitos ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>¿Qué incluye el curso?</label>
                            <textarea name="incluye" rows="3" class="form-control-admin"><?= $curso->incluye ?></textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-3">
                    <a href="<?= URL_BASE ?>admin/cursos" class="btn-cancel-admin">Descartar Cambios</a>
                    <button type="submit" class="btn-publish ml-3">
                        <i class="fas fa-check-circle mr-1"></i> Actualizar Curso
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // Script para mostrar el nombre del archivo seleccionado en el label
    document.getElementById('portadaEdicion').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?php include '../app/views/layouts/footer_admin.php'; ?>