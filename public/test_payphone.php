<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Integración Payphone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 2rem; background: #f8f9fa; }
        .test-card { background: white; border-radius: 10px; padding: 2rem; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .test-pass { color: #28a745; font-weight: bold; }
        .test-fail { color: #dc3545; font-weight: bold; }
        .test-warning { color: #ffc107; font-weight: bold; }
        .code-block { background: #f4f4f4; padding: 1rem; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">🧪 Test de Integración Payphone</h1>

        <?php
        // Incluir configuración
        require_once '../app/config/config.php';
        require_once '../app/config/Database.php';

        $tests_passed = 0;
        $tests_failed = 0;
        ?>

        <!-- TEST 1: Verificar constantes -->
        <div class="test-card">
            <h3>1️⃣ Verificar Constantes de Payphone</h3>
            <?php
            $token_exists = defined('PAYPHONE_TOKEN');
            $store_exists = defined('PAYPHONE_STORE_ID');
            $url_exists = defined('URL_BASE');

            if ($token_exists && $store_exists && $url_exists) {
                echo '<p class="test-pass">✅ PASS: Todas las constantes están definidas</p>';
                $tests_passed++;
            } else {
                echo '<p class="test-fail">❌ FAIL: Faltan constantes</p>';
                $tests_failed++;
            }
            ?>
            <div class="code-block">
                <strong>PAYPHONE_TOKEN:</strong> <?= $token_exists ? '✓ Definido (' . substr(PAYPHONE_TOKEN, 0, 20) . '...)' : '✗ No definido'; ?><br>
                <strong>PAYPHONE_STORE_ID:</strong> <?= $store_exists ? '✓ ' . PAYPHONE_STORE_ID : '✗ No definido'; ?><br>
                <strong>URL_BASE:</strong> <?= $url_exists ? '✓ ' . URL_BASE : '✗ No definido'; ?>
            </div>
        </div>

        <!-- TEST 2: Verificar archivos del controlador -->
        <div class="test-card">
            <h3>2️⃣ Verificar Archivos de Controlador</h3>
            <?php
            $pago_controller = file_exists('../app/controllers/PagoController.php');
            $inscripcion_controller = file_exists('../app/controllers/InscripcionController.php');

            if ($pago_controller && $inscripcion_controller) {
                echo '<p class="test-pass">✅ PASS: Controladores existen</p>';
                $tests_passed++;
            } else {
                echo '<p class="test-fail">❌ FAIL: Faltan controladores</p>';
                $tests_failed++;
            }
            ?>
            <div class="code-block">
                <strong>PagoController.php:</strong> <?= $pago_controller ? '✓ Existe' : '✗ No existe'; ?><br>
                <strong>InscripcionController.php:</strong> <?= $inscripcion_controller ? '✓ Existe' : '✗ No existe'; ?>
            </div>
        </div>

        <!-- TEST 3: Verificar vistas -->
        <div class="test-card">
            <h3>3️⃣ Verificar Vistas de Pago</h3>
            <?php
            $payphone_view = file_exists('../app/views/pago/payphone.php');
            $resultado_view = file_exists('../app/views/pago/resultado.php');

            if ($payphone_view && $resultado_view) {
                echo '<p class="test-pass">✅ PASS: Vistas existen</p>';
                $tests_passed++;
            } else {
                echo '<p class="test-fail">❌ FAIL: Faltan vistas</p>';
                $tests_failed++;
            }
            ?>
            <div class="code-block">
                <strong>payphone.php:</strong> <?= $payphone_view ? '✓ Existe' : '✗ No existe'; ?><br>
                <strong>resultado.php:</strong> <?= $resultado_view ? '✓ Existe' : '✗ No existe'; ?>
            </div>
        </div>

        <!-- TEST 4: Verificar conexión a base de datos -->
        <div class="test-card">
            <h3>4️⃣ Verificar Conexión a Base de Datos</h3>
            <?php
            try {
                $db = Database::conectar();
                echo '<p class="test-pass">✅ PASS: Conexión exitosa</p>';
                $tests_passed++;
                
                // Verificar tabla pagos
                $stmt = $db->query("SHOW TABLES LIKE 'pagos'");
                $table_exists = $stmt->rowCount() > 0;
                
                if ($table_exists) {
                    echo '<p class="test-pass">✅ Tabla "pagos" existe</p>';
                    
                    // Verificar columnas necesarias
                    $columns = $db->query("SHOW COLUMNS FROM pagos")->fetchAll(PDO::FETCH_COLUMN);
                    $required_columns = [
                        'payphone_id_transaccion',
                        'payphone_client_transaction_id',
                        'tipo_verificacion'
                    ];
                    
                    $missing_columns = array_diff($required_columns, $columns);
                    
                    if (empty($missing_columns)) {
                        echo '<p class="test-pass">✅ Todas las columnas requeridas existen</p>';
                    } else {
                        echo '<p class="test-warning">⚠️ WARNING: Faltan columnas: ' . implode(', ', $missing_columns) . '</p>';
                        echo '<p>Ejecuta el script: <code>database/update_pagos_table.sql</code></p>';
                    }
                } else {
                    echo '<p class="test-fail">❌ Tabla "pagos" no existe</p>';
                }
            } catch (Exception $e) {
                echo '<p class="test-fail">❌ FAIL: Error de conexión - ' . $e->getMessage() . '</p>';
                $tests_failed++;
            }
            ?>
        </div>

        <!-- TEST 5: Verificar rutas -->
        <div class="test-card">
            <h3>5️⃣ Verificar Rutas del Sistema</h3>
            <div class="code-block">
                <strong>URL Base:</strong> <?= URL_BASE; ?><br>
                <strong>Ruta Pasarela:</strong> <?= URL_BASE; ?>public/pago/payphone<br>
                <strong>Ruta Éxito:</strong> <?= URL_BASE; ?>public/pago/payphone?status=success<br>
                <strong>Ruta Fallo:</strong> <?= URL_BASE; ?>public/pago/payphone?status=failure
            </div>
            <p class="mt-3">
                <a href="<?= URL_BASE; ?>public/curso/index" class="btn btn-primary" target="_blank">
                    🔗 Probar Catálogo de Cursos
                </a>
            </p>
        </div>

        <!-- TEST 6: Verificar modelos -->
        <div class="test-card">
            <h3>6️⃣ Verificar Modelos</h3>
            <?php
            $inscripcion_model = file_exists('../app/models/InscripcionModel.php');
            $curso_model = file_exists('../app/models/CursoModel.php');

            if ($inscripcion_model && $curso_model) {
                echo '<p class="test-pass">✅ PASS: Modelos existen</p>';
                $tests_passed++;
            } else {
                echo '<p class="test-fail">❌ FAIL: Faltan modelos</p>';
                $tests_failed++;
            }
            ?>
            <div class="code-block">
                <strong>InscripcionModel.php:</strong> <?= $inscripcion_model ? '✓ Existe' : '✗ No existe'; ?><br>
                <strong>CursoModel.php:</strong> <?= $curso_model ? '✓ Existe' : '✗ No existe'; ?>
            </div>
        </div>

        <!-- RESUMEN -->
        <div class="test-card" style="background: <?= $tests_failed > 0 ? '#fff3cd' : '#d4edda'; ?>">
            <h2>📊 Resumen de Pruebas</h2>
            <p style="font-size: 1.5rem;">
                <strong class="test-pass">✅ Pasadas:</strong> <?= $tests_passed; ?><br>
                <strong class="test-fail">❌ Falladas:</strong> <?= $tests_failed; ?>
            </p>
            
            <?php if ($tests_failed === 0): ?>
                <div class="alert alert-success">
                    <h4>🎉 ¡Todo configurado correctamente!</h4>
                    <p>El sistema está listo para procesar pagos con Payphone.</p>
                    <p><strong>Siguiente paso:</strong></p>
                    <ol>
                        <li>Ve al <a href="<?= URL_BASE; ?>public/curso/index">catálogo de cursos</a></li>
                        <li>Selecciona un curso</li>
                        <li>Elige "Tarjeta de Crédito" como método de pago</li>
                        <li>Completa la transacción en la pasarela de Payphone</li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <h4>⚠️ Hay problemas que resolver</h4>
                    <p>Revisa los tests fallados arriba y corrige los problemas antes de continuar.</p>
                    <p><strong>Recursos:</strong></p>
                    <ul>
                        <li>📖 <a href="../PAYPHONE_INTEGRATION.md">Guía de Integración</a></li>
                        <li>📋 <a href="../IMPLEMENTATION_SUMMARY.md">Resumen de Implementación</a></li>
                        <li>💾 <a href="../database/update_pagos_table.sql">Script de BD</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- INFORMACIÓN ADICIONAL -->
        <div class="test-card">
            <h3>📚 Documentación y Recursos</h3>
            <ul>
                <li>📄 <a href="../PAYPHONE_INTEGRATION.md" target="_blank">PAYPHONE_INTEGRATION.md</a> - Guía completa</li>
                <li>📄 <a href="../IMPLEMENTATION_SUMMARY.md" target="_blank">IMPLEMENTATION_SUMMARY.md</a> - Resumen</li>
                <li>📄 <a href="../PAYPHONE_CREDENTIALS_EXAMPLE.md" target="_blank">PAYPHONE_CREDENTIALS_EXAMPLE.md</a> - Credenciales</li>
                <li>💾 <a href="../database/update_pagos_table.sql" target="_blank">update_pagos_table.sql</a> - Script SQL</li>
            </ul>
        </div>
    </div>
</body>
</html>
