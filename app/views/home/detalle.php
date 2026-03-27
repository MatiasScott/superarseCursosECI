<?php include '../app/views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/home.css">
<link rel="stylesheet" href="<?= URL_BASE ?>css/detalle.css">

<main class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="detail-header mb-4">
                <h1><?= $curso->titulo; ?></h1>
                <div style="margin: 0.5em 0 1em 0; font-size: 1.15em; color: #bfa100; font-weight: 500; display: flex; align-items: center; gap: 1em;">
                    <i class="fas fa-calendar-alt" style="color: #bfa100;"></i> Inicio: <?= date('d/m/Y', strtotime($curso->fecha_inicio)); ?>
                </div>
                <!-- <h2><?= print_r($modalidades) ?></h2> -->
                <img src="<?= URL_BASE; ?>img/cursos/<?= $curso->imagen_portada; ?>" class="img-banner-detail">
            </div>

            <div class="tabs-container">
                <div class="tabs-header">
                    <button class="tab-btn active" onclick="openTab(event, 'objetivos')">Objetivos</button>
                    <button class="tab-btn" onclick="openTab(event, 'contenido')">Contenido</button>
                    <button class="tab-btn" onclick="openTab(event, 'inscripcion')">Inscripción</button>
                </div>

                <div class="tabs-content card-body-custom">
                    <div id="objetivos" class="tab-pane active">
                        <h3><i class="fas fa-bullseye text-accent"></i> Objetivo:</h3>
                        <p><?= nl2br($curso->objetivos); ?></p>
                    </div>

                    <div id="contenido" class="tab-pane">
                        <h3><i class="fas fa-list-ul text-accent"></i> Programa:</h3>
                        <div class="programa-texto"><?= nl2br($curso->programa); ?></div>
                    </div>

                    <div id="inscripcion" class="tab-pane">
                        <div class="inscripcion-info">
                            <h4>Requisitos:</h4>
                            <p><?= nl2br($curso->requisitos); ?></p>
                            <h4>Incluye:</h4>
                            <div id="info-modalidad-seleccionada">
                                <p class="mb-1 text-muted">Selecciona una modalidad para ver detalles.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <div class="card-pago-pro card-inscripcion-mejorada">
                    <div class="insc-header mb-3">
                        <h3 class="insc-title">Inscripción</h3>
                        <?php
                        $esVeterinarios = (stripos($curso->titulo, 'veterinario') !== false);
                        ?>
                        <div class="price-display" id="precio-curso">
                            $0.00
                        </div>
                    </div>
                    <?php if ($curso->cupos_disponibles > 0): ?>
                        <form action="<?= URL_BASE; ?>inscripcion/procesar" method="POST" enctype="multipart/form-data" id="form-inscripcion">
                            <input type="hidden" name="id_curso" value="<?= $curso->id_curso; ?>">
                            <div class="form-group mb-3">
                                <label class="insc-label">Modalidad:</label>
                                <div id="modalidad-options" class="d-flex flex-column gap-3">
                                    <?php foreach ($modalidades as $mod): ?>
                                        <button type="button" class="btn btn-modalidad modalidad-card" 
                                            data-value="<?= htmlspecialchars($mod->nombre) ?>" 
                                            data-precio="<?= floatval($mod->precio) ?>" 
                                            data-id="<?= $mod->id ?>"
                                            tabindex="0">
                                            <span class="modalidad-icon">
                                                <?php
                                                if (stripos($mod->nombre, 'intensivo') !== false) {
                                                    echo '<i class="fas fa-bolt"></i>';
                                                } elseif (stripos($mod->nombre, 'presencial') !== false) {
                                                    echo '<i class="fas fa-users"></i>';
                                                } elseif (stripos($mod->nombre, 'híbrida') !== false || stripos($mod->nombre, 'hibrida') !== false) {
                                                    echo '<i class="fas fa-laptop-house"></i>';
                                                } else {
                                                    echo '<i class="fas fa-graduation-cap"></i>';
                                                }
                                                ?>
                                            </span>
                                            <span>
                                                <strong><?= htmlspecialchars($mod->nombre) ?></strong><br>
                                                <?php if (floatval($mod->precio) > 0): ?>
                                                    <span class="text-muted">$<?= number_format($mod->precio, 2) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">No disponible</span>
                                                <?php endif; ?>
                                            </span>
                                            <span class="checkmark"><i class="fas fa-check-circle"></i></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="modalidad" id="modalidad-select" required>
                            </div>
                            <div class="form-group mb-3" id="horario-group" style="display:none;">
                                <label class="insc-label">Horario:</label>
                                <select name="horario" id="horario-select" class="form-control custom-select">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Matutino">Matutino</option>
                                    <option value="Nocturno">Nocturno</option>
                                </select>
                            </div>
                            <input type="hidden" name="precio_modalidad" id="precio-modalidad" value="">
                            <div class="form-group mb-3">
                                <label class="insc-label">Método de pago:</label>
                                <select name="metodo" id="selector-metodo" class="form-control custom-select" required>
                                    <option value="">-- Seleccionar --</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                    <option value="payphone">Tarjeta de Crédito</option>
                                </select>
                            </div>
                            <div id="info-transferencia" class="info-box hidden mb-3">
                                <div style="margin-bottom: 1em;">
                                    <strong>Banco: Banco del Produbanco</strong><br>
                                    <span style="font-size:0.98em;">Tipo de cuenta: Cuenta de Ahorros</span><br>
                                    <span style="font-size:0.98em;">Número de Cuenta: 02005290577</span><br>
                                    <span style="font-size:0.98em;">RUC: 1792951704001</span><br>
                                    <span style="font-size:0.98em;">Nombre del Beneficiario: Instituto Superior Tecnológico Superarse</span>
                                </div>
                                <hr style="border-top: 1px dashed #ccc; margin: 0.7em 0;">
                                <div>
                                    <strong>Banco: Banco de Guayaquil</strong><br>
                                    <span style="font-size:0.98em;">Tipo de cuenta: Cuenta de Ahorros</span><br>
                                    <span style="font-size:0.98em;">Número de Cuenta: 13748241</span><br>
                                    <span style="font-size:0.98em;">RUC: 1792951704001</span><br>
                                    <span style="font-size:0.98em;">Nombre del Beneficiario: Instituto Superior Tecnológico Superarse</span>
                                </div>
                                <hr style="border-top: 1px dashed #ccc; margin: 0.7em 0;">
                                <div>
                                    <strong>Banco: Banco de Pichincha</strong><br>
                                    <span style="font-size:0.98em;">Tipo de cuenta: Cuenta de Corriente</span><br>
                                    <span style="font-size:0.98em;">Número de Cuenta: 2100198810</span><br>
                                    <span style="font-size:0.98em;">RUC: 1792951704001</span><br>
                                    <span style="font-size:0.98em;">Nombre del Beneficiario: Instituto Superior Tecnológico Superarse</span>
                                </div>
                                <input type="file" name="comprobante" class="form-control-file" style="margin-top:1em;">
                            </div>
                            <button type="submit" class="btn btn-insc-main w-100 mt-2">Confirmar Inscripción</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-dark text-center">Cupos Agotados</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- FontAwesome para iconos -->
<style>
    .card-inscripcion-mejorada {
        background: linear-gradient(120deg, #232323 80%, #3a2e00 100%);
        border-radius: 22px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        padding: 2.2rem 1.5rem 2rem 1.5rem;
        color: #fffbe6;
        border: 1.5px solid #FFD700;
        margin-bottom: 2rem;
    }

    .insc-header {
        text-align: center;
        margin-bottom: 1.2rem;
    }

    .insc-title {
        font-size: 2rem;
        font-weight: 700;
        color: #FFD700;
        margin-bottom: 0.2em;
        letter-spacing: 0.5px;
    }

    .price-display {
        font-size: 2.3rem;
        font-weight: 800;
        color: #FFD700;
        margin-bottom: 0.2em;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px #00000033;
    }

    .insc-label {
        font-weight: 600;
        color: #ffe066;
        margin-bottom: 0.3em;
        font-size: 1.08rem;
    }

    .form-group.mb-3 {
        margin-bottom: 1.2rem !important;
    }

    .btn-insc-main {
        background: linear-gradient(90deg, #FFD700 60%, #ffe066 100%);
        color: #232323;
        font-weight: 700;
        font-size: 1.18rem;
        border-radius: 14px;
        border: none;
        box-shadow: 0 2px 8px #00000022;
        padding: 0.85em 0;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    }

    .btn-insc-main:hover,
    .btn-insc-main:focus {
        background: linear-gradient(90deg, #ffe066 60%, #FFD700 100%);
        color: #000;
        box-shadow: 0 4px 16px #FFD70044;
    }

    /* Modalidad cards (ya definidos antes, se mantienen) */
    .modalidad-card {
        background: linear-gradient(120deg, #fffbe6 80%, #ffe066 100%);
        border: 2px solid #FFD700;
        border-radius: 18px;
        padding: 20px 18px 16px 18px;
        font-size: 1.13rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s, transform 0.15s;
        text-align: left;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        outline: none;
    }

    .modalidad-card:hover,
    .modalidad-card:focus {
        border-color: #ffb700;
        background: linear-gradient(120deg, #fffde4 80%, #ffe066 100%);
        box-shadow: 0 6px 24px rgba(255, 215, 0, 0.13);
        transform: translateY(-2px) scale(1.02);
    }

    .modalidad-card.selected {
        border-color: #000;
        background: linear-gradient(120deg, #fff8d1 80%, #ffe066 100%);
        box-shadow: 0 8px 32px rgba(255, 215, 0, 0.18);
        transform: scale(1.03);
    }

    .modalidad-card strong {
        font-size: 1.18rem;
        color: #222;
        display: block;
    }

    .modalidad-card .text-muted {
        font-size: 1.04rem;
        color: #b09a3d;
        font-weight: 500;
    }

    .modalidad-icon {
        font-size: 2.1rem;
        color: #FFD700;
        flex-shrink: 0;
        margin-right: 2px;
        filter: drop-shadow(0 1px 0 #fff8d1);
    }

    .modalidad-card.selected .modalidad-icon {
        color: #ffb700;
        filter: drop-shadow(0 2px 2px #ffe066);
    }

    .modalidad-card .checkmark {
        position: absolute;
        right: 18px;
        top: 18px;
        font-size: 1.3rem;
        color: #2ecc40;
        display: none;
    }

    .modalidad-card.selected .checkmark {
        display: block;
        animation: pop 0.3s;
    }

    @keyframes pop {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        80% {
            transform: scale(1.2);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
<script src="<?= URL_BASE; ?>js/detalle.js"></script>
<script>
document.getElementById('form-inscripcion').addEventListener('submit', function(e) {
    if (!modalidadSelect.value) {
        e.preventDefault();
        alert('Debes seleccionar una modalidad antes de continuar.');
    }
});
</script>
<script>
    // Precios por modalidad (dinámicos desde PHP)
    const precios = {};
    <?php foreach ($modalidades as $mod): ?>
        precios["<?= addslashes($mod->nombre) ?>"] = <?= floatval($mod->precio) ?>;
    <?php endforeach; ?>
    const modalidadSelect = document.getElementById('modalidad-select');
    const precioDiv = document.getElementById('precio-curso');
    const precioInput = document.getElementById('precio-modalidad');
    const horarioGroup = document.getElementById('horario-group');
    const horarioSelect = document.getElementById('horario-select');
    const modalidadBtns = document.querySelectorAll('.btn-modalidad');

    // Guardar info de modalidades para mostrar descripción y horario
    const modalidadesInfo = {};
    <?php foreach ($modalidades as $mod): ?>
        modalidadesInfo["<?= addslashes($mod->nombre) ?>"] = {
            descripcion: "<?= addslashes(preg_replace('/\r?\n/', '\\n', $mod->descripcion)) ?>",
            horarios: "<?= addslashes(preg_replace('/\r?\n/', '\\n', $mod->horarios)) ?>"
        };
    <?php endforeach; ?>

    const infoModalidadDiv = document.getElementById('info-modalidad-seleccionada');

    modalidadBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            modalidadBtns.forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            const val = btn.getAttribute('data-value');
            const precio = btn.getAttribute('data-precio');
            modalidadSelect.value = val;
            precioDiv.textContent = '$' + parseFloat(precio).toFixed(2);
            precioInput.value = precio;
            // Mostrar horario solo si es presencial
            if (val === 'Presencial') {
                horarioGroup.style.display = '';
                horarioSelect.required = true;
            } else {
                horarioGroup.style.display = 'none';
                horarioSelect.value = '';
                horarioSelect.required = false;
            }
            // Mostrar descripción y horario de la modalidad seleccionada
            if (modalidadesInfo[val]) {
                let html = '';
                if (modalidadesInfo[val].descripcion) {
                    // Separar por saltos de línea y mostrar como lista
                    const items = modalidadesInfo[val].descripcion.split(/\r?\n|\r|\\n/).map(i => i.trim()).filter(i => i.length > 0);
                    if (items.length > 1) {
                        html += '<ul>' + items.map(i => '<li>' + i + '</li>').join('') + '</ul>';
                    } else {
                        html += '<p>' + items[0] + '</p>';
                    }
                }
                if (modalidadesInfo[val].horarios) {
                    html += '<div><strong>Horario:</strong> ' + modalidadesInfo[val].horarios.replace(/\n/g, '<br>') + '</div>';
                }
                infoModalidadDiv.innerHTML = html;
            } else {
                infoModalidadDiv.innerHTML = '<p class="mb-1 text-muted">Selecciona una modalidad para ver detalles.</p>';
            }
        });
    });
</script>

<?php include '../app/views/layouts/footer.php'; ?>
