<?php include '../app/views/layouts/header_estudiante.php'; ?>
<link rel="stylesheet" href="<?php echo URL_BASE; ?>css/estudiante.css">
<style>
    .pagination {
        display: flex;
        justify-content: center;
        padding-left: 0;
        list-style: none;
        border-radius: 0.5rem;
        margin: 1.5rem 0 0 0;
    }
    .page-item {
        margin: 0 2px;
    }
    .page-link {
        display: block;
        min-width: 40px;
        height: 40px;
        padding: 0.5rem 0.9rem;
        color: #3576F6;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 0.25rem;
        text-align: center;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }
    .page-item.active .page-link,
    .page-link:hover {
        background: #3576F6;
        color: #fff;
        font-weight: bold;
        border-color: #3576F6;
    }
</style>

<div class="dashboard-wrapper">
    <main class="main-content">
        <header class="content-header">
            <div>
                <h1>Mis Pagos</h1>
                <p>Historial de transacciones y comprobantes de pago.</p>
            </div>
        </header>

        <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Curso</th>
                    <th>Método</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Comprobante</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mis_pagos as $pago): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($pago->fecha_pago)); ?></td>
                        <td><?php echo $pago->titulo_curso; ?></td>
                        <td><span class="metodo-tag"><?php echo ucfirst($pago->metodo_pago); ?></span></td>
                        <td><strong>$<?php echo $pago->monto_pagado; ?></strong></td>
                        <td>
                            <span class="status-pill status-<?php echo $pago->estado_pago; ?>">
                                <?php echo ucfirst($pago->estado_pago); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($pago->comprobante_archivo): ?>
                                <a href="<?php echo URL_BASE; ?>uploads/comprobantes/<?php echo $pago->comprobante_archivo; ?>" target="_blank">📄 Ver archivo</a>
                            <?php else: ?>
                                <span class="text-muted">Digital</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Paginación -->
        <div style="text-align:center; margin-top:20px;">
            <?php if (isset($total_paginas) && $total_paginas > 1): ?>
                <nav aria-label="Paginación de pagos" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item<?php if ($i == (isset($pagina) ? $pagina : 1)) echo ' active'; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
            </tbody>
        </table>
    </div>
    </main>
</div>

<?php include '../app/views/layouts/footer.php'; ?>