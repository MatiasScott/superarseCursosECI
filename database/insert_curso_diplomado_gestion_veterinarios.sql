-- Inserción de curso: Diplomado en Gestión y Dirección de Centros Veterinarios
INSERT INTO cursos (
    titulo,
    descripcion_corta,
    contenido_detallado,
    precio,
    cupos_totales,
    cupos_disponibles,
    fecha_inicio,
    fecha_fin,
    fecha_limite_inscripcion,
    imagen_portada,
    estado,
    objetivos,
    programa,
    requisitos,
    incluye
) VALUES (
    'Diplomado en Gestión y Dirección de Centros Veterinarios',
    'Capacita en gestión, liderazgo y administración de centros veterinarios para optimizar la operación, el servicio y la sostenibilidad.',
    'Módulo 1: Gestión Administrativa del Centro\nMódulo 2: Gestión Financiera y Rentabilidad\nMódulo 3: Marketing y Atención al Cliente\nMódulo 4: Liderazgo y Gestión de Personal\nMódulo 5: Innovación y Tecnologías Aplicadas a la Gestión\nMódulo 6: Integración, Evaluación y Cierre del Programa',
    0.00, -- Actualiza el precio si es necesario
    30,   -- Cupos totales (ajusta según necesidad)
    30,   -- Cupos disponibles (igual que totales al inicio)
    '2026-03-01', -- Fecha de inicio (ajusta según necesidad)
    '2026-05-31', -- Fecha de fin (ajusta según necesidad)
    '2026-02-28', -- Fecha límite de inscripción (ajusta según necesidad)
    'diplomado_gestion_veterinarios.jpg', -- Nombre de la imagen de portada
    'activo',
    'Capacitar en herramientas de gestión, liderazgo y administración de centros veterinarios, combinando teoría, talleres prácticos y experiencias de integración para optimizar la operación, el servicio y la sostenibilidad del negocio.',
    'Módulo 1: Gestión Administrativa del Centro\nMódulo 2: Gestión Financiera y Rentabilidad\nMódulo 3: Marketing y Atención al Cliente\nMódulo 4: Liderazgo y Gestión de Personal\nMódulo 5: Innovación y Tecnologías Aplicadas a la Gestión\nMódulo 6: Integración, Evaluación y Cierre del Programa',
    'Profesionales o personas interesadas en la administración y gestión de centros veterinarios, con o sin título en Veterinaria.\nInterés en fortalecer habilidades de gestión, liderazgo y administración.\nDisposición para aprender y aplicar herramientas prácticas.',
    '• Hospedaje: incluido por 3 días (2 noches).\n• Alimentación: 7 comidas\n• Estación de bebidas: Café, té y refrescos durante los descansos.\n• Visita turística: Excursión al centro de Quito para fortalecer la integración.\n• Transporte: ida y vuelta (en caso de que sea fuera de Quito)'
);
