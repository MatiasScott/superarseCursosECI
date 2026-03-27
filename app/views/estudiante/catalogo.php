<?php include '../app/views/layouts/header_estudiante.php'; ?>
<link rel="stylesheet" href="<?php echo URL_BASE; ?>css/estudiante.css">

<!-- ESTILOS ESPECÍFICOS -->
<style>
    /* 1. Estructura General de la Cuadrícula (No tocar) */
    .custom-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        padding: 20px 0;
        align-items: stretch;
    }

    .custom-grid-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        background-color: #fff;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .custom-card-img-wrapper {
        position: relative;
        height: 200px;
        width: 100%;
    }

    .custom-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .custom-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .custom-card-desc {
        flex-grow: 1;
        margin-bottom: 15px;
    }

    .custom-card-footer {
        margin-top: auto;
        width: 100%;
    }

    /* --- 2. ESTILO ESPECÍFICO PARA LOS PRECIOS (Estilo Imagen) --- */
    .custom-pricing-box {
        background-color: #f9f9fa; /* Fondo gris muy suave */
        border-radius: 12px;       /* Bordes redondeados */
        padding: 12px 5px;
        margin-bottom: 15px;
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columnas exactas */
        gap: 5px;
        border: 1px solid #eee;
    }

    .custom-pricing-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    /* Líneas divisorias sutiles entre columnas (opcional, como en algunas UI modernas) */
    .custom-pricing-col:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -2.5px;
        top: 10%;
        height: 80%;
        width: 1px;
        background-color: #e0e0e0;
    }

    .custom-pricing-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px; /* Espacio entre icono y texto */
        white-space: nowrap; /* Evita que el texto se parta feo */
    }

    /* Ajuste para pantallas muy pequeñas: iconos arriba del texto si no caben */
    @media (max-width: 360px) {
        .custom-pricing-label { flex-direction: column; gap: 2px; font-size: 0.75rem; }
    }

    .custom-pricing-amount {
        font-size: 1rem;
        font-weight: 500;
        color: #222;
    }

    /* Botón */
    .custom-btn-container {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }
</style>

<div class="catalogo-container">
    <div class="container">
        <!-- Header -->
        <div class="catalogo-header">
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h2 class="catalogo-title">
                        <i class="fas fa-book-reader"></i> Catálogo de Cursos
                    </h2>
                    <p class="catalogo-subtitle">Explora nuestra oferta de formación técnica y tecnológica</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="cursos-stats">
                        <span class="stat-badge">
                            <i class="fas fa-graduation-cap"></i> <?php echo count($cursos); ?> cursos disponibles
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de cursos -->
        <div class="custom-grid-container">
            <?php foreach ($cursos as $curso): ?>
                <?php if ($curso->cupos_disponibles > 0): ?>
                <div class="custom-grid-card">
                    
                    <!-- Imagen -->
                    <div class="custom-card-img-wrapper">
                        <img src="<?php echo URL_BASE; ?>img/cursos/<?php echo $curso->imagen_portada; ?>" 
                             alt="<?php echo $curso->titulo; ?>" 
                             class="custom-card-img">
                        <div class="course-badge" style="position: absolute; top: 10px; right: 10px;">
                            <?php if ($curso->cupos_disponibles > 10): ?>
                                <span class="badge-disponible">Disponible</span>
                            <?php elseif ($curso->cupos_disponibles > 0): ?>
                                <span class="badge-ultimos">Últimos cupos</span>
                            <?php else: ?>
                                <span class="badge-lleno">Lleno</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="custom-card-body">
                        <h3 class="course-title"><?php echo $curso->titulo; ?></h3>
                        
                        <div class="custom-card-desc">
                            <p class="course-desc mb-2"><?php echo $curso->descripcion_corta; ?></p>
                        </div>

                        <div class="course-info mb-3">
                            <div class="info-item">
                                <i class="fas fa-users"></i>
                                <span><?php echo $curso->cupos_disponibles; ?> cupos</span>
                            </div>
                            <div class="info-item">
                                    <i class="fas fa-certificate" style="color:#ffb300;"></i>
                                    <span>Certificado</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-calendar-alt" style="color:#ffb300;"></i>
                                    <span>Inicio: <?php echo date('d/m/Y', strtotime($curso->fecha_inicio)); ?></span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="custom-card-footer">
                            
                            <!-- SECCIÓN DE PRECIOS MODIFICADA -->
                            <div class="custom-pricing-box">
                                <!-- Columna 1: Intensivo -->
                                <div class="custom-pricing-col">
                                    <div class="custom-pricing-label">
                                        <i class="fas fa-bolt" style="color:#ffb300;"></i> Intensivo
                                    </div>
                                    <div class="custom-pricing-amount">
                                        $<?php echo number_format($curso->precio_intensivo, 2); ?>
                                    </div>
                                </div>
                                
                                <!-- Columna 2: Presencial -->
                                <div class="custom-pricing-col">
                                    <div class="custom-pricing-label">
                                        <i class="fas fa-users" style="color:#4caf50;"></i> Presencial
                                    </div>
                                    <div class="custom-pricing-amount">
                                        $<?php echo number_format($curso->precio_presencial, 2); ?>
                                    </div>
                                </div>

                                <!-- Columna 3: Híbrida -->
                                <div class="custom-pricing-col">
                                    <div class="custom-pricing-label">
                                        <i class="fas fa-sync-alt" style="color:#2196f3;"></i> Híbrida
                                    </div>
                                    <div class="custom-pricing-amount">
                                        $<?php echo number_format($curso->precio_hibrida, 2); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN SECCIÓN PRECIOS -->

                            <div class="custom-btn-container">
                                <a href="<?php echo URL_BASE; ?>curso/detalle/<?php echo $curso->id_curso; ?>" class="btn-inscribir">
                                    <i class="fas fa-arrow-right"></i> Inscribirme
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($cursos)): ?>
            <div class="no-courses">
                <i class="fas fa-inbox"></i>
                <h3>No hay cursos disponibles</h3>
                <p>Por el momento no contamos con cursos activos. Vuelve pronto.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>