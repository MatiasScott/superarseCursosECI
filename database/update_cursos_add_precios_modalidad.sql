-- Migración: Agregar precios por modalidad a la tabla cursos
ALTER TABLE cursos 
ADD COLUMN precio_intensivo DECIMAL(10,2) DEFAULT 0.00 AFTER precio,
ADD COLUMN precio_presencial DECIMAL(10,2) DEFAULT 0.00 AFTER precio_intensivo,
ADD COLUMN precio_hibrida DECIMAL(10,2) DEFAULT 0.00 AFTER precio_presencial;

-- Opcional: migrar el valor actual de 'precio' a las tres modalidades para cursos existentes
UPDATE cursos SET precio_intensivo = precio, precio_presencial = precio, precio_hibrida = precio;
