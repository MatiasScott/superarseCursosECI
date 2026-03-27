<?php include '../app/views/layouts/header_admin.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/admin.css">

<main class="admin-main-content">
    <div class="container container-admin-centered py-5">
        <div class="mb-4">
            <h2 class="h3">Crear Nuevo Curso</h2>
            <p class="text-muted">Completa la información para publicar un nuevo programa educativo.</p>
        </div>

        <form action="<?= URL_BASE ?>admin/guardar_curso" method="POST" enctype="multipart/form-data" class="admin-form-container">

            <div class="form-section-title">Información General</div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group mb-3">
                        <label>Título del Curso:</label>
                        <input type="text" name="titulo" class="form-control-admin" placeholder="Ej: Excel Avanzado para Negocios" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Imagen de Portada:</label>
                        <div class="custom-file">
                            <input type="file" name="imagen_portada" class="custom-file-input" id="portada" accept="image/*" required>
                            <label class="custom-file-label" for="portada">Elegir imagen...</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section-title">Modalidades y Precios</div>
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="modalidad[]" value="Intensivo/VIP">
                    <div class="form-group mb-3">
                        <label>Precio Intensivo/VIP ($):</label>
                        <input type="number" name="precio[]" step="0.01" class="form-control-admin" placeholder="240.00" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Cupos Intensivo/VIP:</label>
                        <input type="number" name="cupos_modalidad[]" min="0" class="form-control-admin" placeholder="Ej: 10" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>¿Qué incluye Intensivo/VIP?</label>
                        <textarea name="descripcion[]" rows="2" class="form-control-admin" placeholder="Incluye acceso a material premium, tutorías, etc."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Horarios Intensivo/VIP</label>
                        <input type="text" name="horarios[]" class="form-control-admin" placeholder="Ej: Sábados 8-12h, Online">
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="modalidad[]" value="Presencial">
                    <div class="form-group mb-3">
                        <label>Precio Presencial ($):</label>
                        <input type="number" name="precio[]" step="0.01" class="form-control-admin" placeholder="120.00" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Cupos Presencial:</label>
                        <input type="number" name="cupos_modalidad[]" min="0" class="form-control-admin" placeholder="Ej: 10" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>¿Qué incluye Presencial?</label>
                        <textarea name="descripcion[]" rows="2" class="form-control-admin" placeholder="Incluye clases presenciales, material impreso, etc."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Horarios Presencial</label>
                        <input type="text" name="horarios[]" class="form-control-admin" placeholder="Ej: Lunes a Viernes 18-21h">
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="modalidad[]" value="Híbrida">
                    <div class="form-group mb-3">
                        <label>Precio Híbrida ($):</label>
                        <input type="number" name="precio[]" step="0.01" class="form-control-admin" placeholder="70.00" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Cupos Híbrida:</label>
                        <input type="number" name="cupos_modalidad[]" min="0" class="form-control-admin" placeholder="Ej: 10" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>¿Qué incluye Híbrida?</label>
                        <textarea name="descripcion[]" rows="2" class="form-control-admin" placeholder="Incluye acceso online y presencial, etc."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Horarios Híbrida</label>
                        <input type="text" name="horarios[]" class="form-control-admin" placeholder="Ej: Mixto, consultar detalles">
                    </div>
                </div>
            </div>

            <div class="form-section-title">Cupos y Fechas</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" class="form-control-admin" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Fecha Fin:</label>
                        <input type="date" name="fecha_fin" class="form-control-admin" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Límite Inscripción:</label>
                        <input type="date" name="fecha_limite_inscripcion" class="form-control-admin" required>
                    </div>
                </div>
            </div>

            <div class="form-section-title">Detalles del Curso (Pestañas)</div>
                        <div class="form-group mb-3">
                            <label>Descripción Detallada:</label>
                            <textarea name="contenido_detallado" rows="4" class="form-control-admin" placeholder="Descripción completa del curso..." required></textarea>
                        </div>
            <div class="form-group mb-3">
                <label>Descripción Corta:</label>
                <textarea name="descripcion_corta" rows="2" class="form-control-admin" placeholder="Breve resumen para la tarjeta de inicio..." required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Objetivos:</label>
                        <textarea name="objetivos" rows="5" class="form-control-admin" placeholder="• Objetivo 1&#10;• Objetivo 2"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Programa / Temario:</label>
                        <textarea name="programa" rows="5" class="form-control-admin" placeholder="Módulo 1: ...&#10;Módulo 2: ..."></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Requisitos:</label>
                        <textarea name="requisitos" rows="3" class="form-control-admin"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>¿Qué incluye?</label>
                        <textarea name="incluye" rows="3" class="form-control-admin"></textarea>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-3">
                <a href="<?= URL_BASE ?>admin/cursos" class="btn-cancel-admin">Cancelar</a>
                <button type="submit" class="btn-publish ml-3">Publicar Curso</button>
            </div>
        </form>
    </div>
</main>

<script>
    // Script para mostrar el nombre de la imagen seleccionada
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("portada").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?php include '../app/views/layouts/footer_admin.php'; ?>