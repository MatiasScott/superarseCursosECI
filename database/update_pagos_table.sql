-- Script SQL para verificar/actualizar la estructura de la tabla de pagos
-- Sistema: Educación Continua - Integración con Payphone
-- Fecha: Enero 2026

-- ============================================
-- VERIFICAR SI LA TABLA EXISTE
-- ============================================
-- Si la tabla no existe, créala con esta estructura:

CREATE TABLE IF NOT EXISTS `pagos` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_inscripcion` int(11) NOT NULL,
  `metodo_pago` enum('transferencia','payphone') NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `comprobante_archivo` varchar(255) DEFAULT NULL,
  `payphone_id_transaccion` varchar(255) DEFAULT NULL,
  `payphone_client_transaction_id` varchar(255) DEFAULT NULL,
  `estado_pago` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `tipo_verificacion` enum('manual','automatica') NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pago`),
  KEY `id_inscripcion` (`id_inscripcion`),
  KEY `idx_client_transaction` (`payphone_client_transaction_id`),
  KEY `idx_estado` (`estado_pago`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripciones` (`id_inscripcion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- SI LA TABLA YA EXISTE, AGREGAR COLUMNAS FALTANTES
-- ============================================

-- Agregar columna payphone_id_transaccion si no existe
SET @column_exists = (
  SELECT COUNT(*) 
  FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_NAME = 'pagos' 
  AND COLUMN_NAME = 'payphone_id_transaccion'
);

SET @sql = IF(@column_exists = 0, 
  'ALTER TABLE pagos ADD COLUMN payphone_id_transaccion VARCHAR(255) NULL AFTER comprobante_archivo', 
  'SELECT "Column payphone_id_transaccion already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar columna payphone_client_transaction_id si no existe
SET @column_exists = (
  SELECT COUNT(*) 
  FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_NAME = 'pagos' 
  AND COLUMN_NAME = 'payphone_client_transaction_id'
);

SET @sql = IF(@column_exists = 0, 
  'ALTER TABLE pagos ADD COLUMN payphone_client_transaction_id VARCHAR(255) NULL AFTER payphone_id_transaccion', 
  'SELECT "Column payphone_client_transaction_id already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar columna tipo_verificacion si no existe
SET @column_exists = (
  SELECT COUNT(*) 
  FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_NAME = 'pagos' 
  AND COLUMN_NAME = 'tipo_verificacion'
);

SET @sql = IF(@column_exists = 0, 
  'ALTER TABLE pagos ADD COLUMN tipo_verificacion ENUM("manual", "automatica") NOT NULL DEFAULT "manual" AFTER estado_pago', 
  'SELECT "Column tipo_verificacion already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================
-- ACTUALIZAR ENUM DE metodo_pago SI ES NECESARIO
-- ============================================
-- Esto asegura que 'payphone' esté en las opciones de metodo_pago

ALTER TABLE pagos 
MODIFY COLUMN metodo_pago ENUM('transferencia', 'payphone') NOT NULL;

-- ============================================
-- CREAR ÍNDICES PARA MEJORAR RENDIMIENTO
-- ============================================

-- Índice para búsqueda por client_transaction_id (usado en callbacks de Payphone)
CREATE INDEX IF NOT EXISTS idx_client_transaction 
ON pagos(payphone_client_transaction_id);

-- Índice para búsqueda por estado de pago
CREATE INDEX IF NOT EXISTS idx_estado 
ON pagos(estado_pago);

-- Índice para búsqueda por fecha
CREATE INDEX IF NOT EXISTS idx_fecha 
ON pagos(fecha_pago);

-- ============================================
-- VERIFICAR ESTRUCTURA FINAL
-- ============================================
-- Ejecuta esto para ver la estructura final de la tabla:

DESCRIBE pagos;

-- ============================================
-- CONSULTAS ÚTILES PARA VERIFICAR DATOS
-- ============================================

-- Ver todos los pagos con Payphone
-- SELECT * FROM pagos WHERE metodo_pago = 'payphone' ORDER BY fecha_pago DESC;

-- Ver pagos pendientes
-- SELECT * FROM pagos WHERE estado_pago = 'pendiente' ORDER BY fecha_pago DESC;

-- Ver últimas transacciones
-- SELECT 
--   p.id_pago,
--   p.metodo_pago,
--   p.monto_pagado,
--   p.estado_pago,
--   p.payphone_client_transaction_id,
--   p.fecha_pago,
--   i.id_usuario,
--   c.titulo as curso
-- FROM pagos p
-- JOIN inscripciones i ON p.id_inscripcion = i.id_inscripcion
-- JOIN cursos c ON i.id_curso = c.id_curso
-- ORDER BY p.fecha_pago DESC
-- LIMIT 10;

-- ============================================
-- LIMPIEZA (OPCIONAL - SOLO PARA DESARROLLO)
-- ============================================

-- Eliminar pagos de prueba pendientes (CUIDADO: solo en desarrollo)
-- DELETE FROM pagos WHERE estado_pago = 'pendiente' AND metodo_pago = 'payphone' AND fecha_pago < DATE_SUB(NOW(), INTERVAL 1 HOUR);

-- ============================================
-- FINALIZADO
-- ============================================

SELECT 'Estructura de tabla pagos actualizada correctamente' AS status;
