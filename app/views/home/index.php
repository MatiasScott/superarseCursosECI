<?php include '../app/views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= URL_BASE ?>css/home.css">

<style>
.status-badge {
    position: absolute;
    top: 18px;
    right: 18px;  /* Esto lo pone en el lado derecho. Si quieres izquierda, cambia a left: 18px; */
    background: #4caf50;
    color: #fff;
    font-weight: 700;
    font-size: 1em;
    padding: 0.32em 1.1em;
    border-radius: 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    letter-spacing: 1px;
    z-index: 2;
    min-width: unset;
    max-width: 140px;
    text-align: center;
    white-space: nowrap;
}
</style>

<section class="hero-home">
    <div class="container">
        <div class="hero-content">
            <h1>Impulsa tu carrera con <span class="text-accent">Educación Continua</span></h1>
            <p class="hero-subtitle">Cursos certificados por expertos profesionales. Formación técnica y tecnológica de
                excelencia.</p>
        </div>
    </div>
</section>

<main class="container main-content">
    <div class="section-header">
        <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Oferta Académica</h2>
        <p class="section-description">Descubre nuestros cursos diseñados para impulsar tu desarrollo profesional</p>
    </div>
    <?php
    function mostrar_precio_modalidad($valor)
    {
        return ($valor > 0) ? ('$' . number_format($valor, 2)) : '<span style="color:#b0b0b0;">No disponible</span>';
    }
    ?>
    <div class="courses-grid-home">
        <?php foreach ($cursos as $curso): ?>
            <div class="course-card-home">
                <div class="course-img-wrapper" style="position: relative;">
                    <?php
                    // Si el curso es de veterinaria, mostrar el logo especial
                    if (stripos($curso->titulo, 'veterinari') !== false) {
                        $img_src = URL_BASE . 'img/cursos/logo-veterinaria.png';
                    } else {
                        $img_src = URL_BASE . 'img/cursos/' . $curso->imagen_portada;
                    }
                    ?>
                    <img src="<?= $img_src; ?>" alt="<?= $curso->titulo; ?>" class="course-img">
                    <?php
                    // Obtener precios desde modalidades
                        $precio_intensivo = 0;
                        $precio_presencial = 0;
                        $precio_hibrida = 0;
                        $cupos_intensivo = 0;
                        $cupos_presencial = 0;
                        $cupos_hibrida = 0;
                        if (!empty($curso->modalidades)) {
                            foreach ($curso->modalidades as $mod) {
                                if (stripos($mod->nombre, 'intensivo') !== false) {
                                    $precio_intensivo = $mod->precio;
                                    $cupos_intensivo = isset($mod->cupos) ? $mod->cupos : 0;
                                }
                                if (stripos($mod->nombre, 'presencial') !== false) {
                                    $precio_presencial = $mod->precio;
                                    $cupos_presencial = isset($mod->cupos) ? $mod->cupos : 0;
                                }
                                if (stripos($mod->nombre, 'híbrida') !== false) {
                                    $precio_hibrida = $mod->precio;
                                    $cupos_hibrida = isset($mod->cupos) ? $mod->cupos : 0;
                                }
                            }
                        }
                        $precios = [
                            'intensivo' => floatval($precio_intensivo),
                            'presencial' => floatval($precio_presencial),
                            'hibrida' => floatval($precio_hibrida)
                        ];
                        $precios_validos = array_filter($precios, function ($p) {
                            return $p > 0;
                        });
                        $precio_min = count($precios_validos) > 0 ? min($precios_validos) : 0;
                    ?>
                    <?php if ($curso->cupos_disponibles > 10): ?>
                        <span class="status-badge">Disponible</span>
                    <?php elseif ($curso->cupos_disponibles > 0): ?>
                        <span class="status-badge">Últimos cupos</span>
                    <?php else: ?>
                        <span class="status-badge">Agotado</span>
                    <?php endif; ?>
                </div>

                <div class="course-body">
                    <!-- Franja de precios de modalidad eliminada aquí -->
                    <h3 class="course-title-home"><?= $curso->titulo; ?></h3>
                    <p class="course-description"><?= substr($curso->descripcion_corta, 0, 80) . '...'; ?></p>

                    <div class="course-details">
                        <?php
                        // Sumar cupos de todas las modalidades
                        $cupos_modalidades_total = 0;
                        if (!empty($curso->modalidades) && is_array($curso->modalidades)) {
                            foreach ($curso->modalidades as $mod) {
                                if (isset($mod->cupos)) {
                                    $cupos_modalidades_total += intval($mod->cupos);
                                }
                            }
                        }
                        ?>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <span><?= $cupos_modalidades_total; ?> cupos</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <span>Certificado</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Inicio: <?= date('d/m/Y', strtotime($curso->fecha_inicio)); ?></span>
                        </div>
                    </div>
                    <div class="course-modalidad-precios-table" style="margin: 0.7em auto 0.7em auto;">
                        <table style="width:100%; border-collapse:collapse; background:rgba(255,255,255,0.92); color:#222; border-radius:0.7em; box-shadow:0 1px 4px rgba(0,0,0,0.06); overflow:hidden;">
                            <thead>
                                <tr style="background:#f7f7f7;">
                                    <th style="padding:0.4em 0.5em; font-size:0.98em; font-weight:600; border:none; text-align:center;"><i class='fas fa-bolt' style='color:#ffb300;'></i> Intensivo</th>
                                    <th style="padding:0.4em 0.5em; font-size:0.98em; font-weight:600; border:none; text-align:center;"><i class='fas fa-users' style='color:#4caf50;'></i> Presencial</th>
                                    <th style="padding:0.4em 0.5em; font-size:0.98em; font-weight:600; border:none; text-align:center;"><i class='fas fa-sync-alt' style='color:#2196f3;'></i> Híbrida</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:0.3em 0.5em; text-align:center; font-size:1em; border:none;">
                                        <?php echo mostrar_precio_modalidad($precio_intensivo); ?>
                                    </td>
                                    <td style="padding:0.3em 0.5em; text-align:center; font-size:1em; border:none;">
                                        <?php echo mostrar_precio_modalidad($precio_presencial); ?>
                                    </td>
                                    <td style="padding:0.3em 0.5em; text-align:center; font-size:1em; border:none;">
                                        <?php echo mostrar_precio_modalidad($precio_hibrida); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center; font-size:0.95em; color:#bfa100; border:none;">
                                        <?= $cupos_intensivo ?> cupos
                                    </td>
                                    <td style="text-align:center; font-size:0.95em; color:#bfa100; border:none;">
                                        <?= $cupos_presencial ?> cupos
                                    </td>
                                    <td style="text-align:center; font-size:0.95em; color:#bfa100; border:none;">
                                        <?= $cupos_hibrida ?> cupos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-actions">
                        <?php if ($curso->cupos_disponibles > 0): ?>
                            <a href="<?= URL_BASE; ?>curso/detalle/<?= $curso->id_curso; ?>" class="btn-curso-home">
                                <i class="fas fa-info-circle"></i> Ver Información
                            </a>
                        <?php else: ?>
                            <button class="btn-curso-disabled" disabled>
                                <i class="fas fa-times-circle"></i> Agotado
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include '../app/views/layouts/footer.php'; ?>

