-- Agregar campos modalidad y horario a la tabla inscripciones para cursos con opciones
ALTER TABLE inscripciones 
ADD COLUMN modalidad VARCHAR(30) DEFAULT NULL,
ADD COLUMN horario VARCHAR(20) DEFAULT NULL;
