-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-02-2026 a las 15:02:12
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `superar1_sistema_educacion_continua`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `descripcion_corta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `contenido_detallado` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `objetivos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `programa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `requisitos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `incluye` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `cupos_totales` int NOT NULL,
  `cupos_disponibles` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_limite_inscripcion` date NOT NULL,
  `imagen_portada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado` enum('activo','inactivo','agotado') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `titulo`, `descripcion_corta`, `contenido_detallado`, `objetivos`, `programa`, `requisitos`, `incluye`, `cupos_totales`, `cupos_disponibles`, `fecha_inicio`, `fecha_fin`, `fecha_limite_inscripcion`, `imagen_portada`, `estado`, `created_at`) VALUES
(19, 'Curso Superior en Grooming y Peluquería Canina y Felina', 'Enfocados en estética, bienestar y cuidado responsable de los animales.', '', 'Formar profesionales capacitados en grooming y peluquería canina y felina, enfocados en la higiene, estética y bienestar de perros y gatos, mediante la aplicación segura y ética de técnicas, herramientas y productos especializados, para su desempeño en centros veterinarios, peluquerías caninas o de manera independiente.', 'Módulo 1: Fundamentos de Grooming y Bienestar Animal \r\nMódulo 2: Herramientas y Preparación del Espacio de Grooming \r\nMódulo 3: Técnicas de Grooming y Corte de Pelo \r\nMódulo 4: Higiene y Cuidado Integral de Mascotas \r\nMódulo 5: Grooming Felino y Estilizado Avanzado \r\nMódulo 6: Emprendimiento y Profesionalización en Grooming ', 'Ser mayor de 16 años.\r\n\r\nPoseer interés en el cuidado, estética y bienestar de perros y gatos.\r\n\r\nPresentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso.', 'Certificado de aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770148164_03.jpg', 'activo', '2026-02-03 19:49:24'),
(20, 'Curso Superior en Adiestramiento y Comportamiento de Mascotas', 'Capacítate en manejo avanzado de mascotas. Aprende a diagnosticar conductas, mejorar la comunicación y asegurar el bienestar animal mediante práctica y análisis de casos.', '', 'Capacitar a los participantes en técnicas avanzadas de adiestramiento y manejo del comportamiento de mascotas, combinando teoría, práctica y análisis de casos, para promover el bienestar animal, fortalecer la comunicación humano-mascota y mejorar la convivencia en diferentes entornos.', 'Módulo 1: Fundamentos del Comportamiento Animal\r\nMódulo 2: Comunicación y Señales Caninas y Felinas\r\nMódulo 3: Técnicas de Adiestramiento Positivo\r\nMódulo 4: Manejo de Problemas de Conducta\r\nMódulo 5: Integración de Adiestramiento y Bienestar\r\nMódulo 6: Evaluación y Cierre del Curso', 'Ser mayor de 18 años\r\nDisposición total para trabajar bajo metodologías de refuerzo positivo y respeto al bienestar animal.\r\nPresentar documento de identidad vigente.', 'certificado de aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770150741_f694eeac-306c-4f08-900f-d75115c0caa6.jfif', 'activo', '2026-02-03 20:32:21'),
(21, 'Curso Superior en Gestión y Dirección de Centros Veterinarios', 'Un programa intensivo de gestión y liderazgo para transformar la operación y asegurar la sostenibilidad de centros veterinarios competitivos.', '', 'Capacitar intensivamente a los participantes en herramientas de gestión, liderazgo y administración de centros veterinarios, combinando teoría, talleres prácticos y experiências de integración para optimizar la operación, el servicio y la sostenibilidad del negócio.', 'Módulo 1: Gestión Administrativa del Centro\r\nMódulo 2: Gestión Financiera y Rentabilidad\r\nMódulo 3: Marketing y Atención al Cliente\r\nMódulo 4: Liderazgo y Gestión de Personal\r\nMódulo 5: Innovación y Tecnologías Aplicadas a la Gestión\r\nMódulo 6: Integración, Evaluación y Cierre del Programa', 'Ser mayor de 16 años.\r\n\r\nPresentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso.', 'Certificados de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770234560_cff73094-6383-48c4-a534-08222686bea8.jfif', 'activo', '2026-02-03 20:47:46'),
(22, 'Curso Superior en Laboratorio Clínico Veterinario Integral', 'Capacitación integral en procesamiento e interpretación de análisis diagnósticos. Potencia tus competencias clínicas con rigor ético, bioseguridad y criterios técnicos para mejorar la práctica veterinaria diaria.', '', 'Desarrollar competencias teórico-prácticas en el laboratorio clínico veterinaria integral, capacitando al participante para realizar, procese e interpretar análisis de laboratorio, aplicando normas de bioseguridad, técnicas diagnósticas y criterios de integración clínico-laboratorial, que contribuyan a la toma de decisiones en la práctica veterinaria con Erica y calidad profesional', 'Módulo 1: Introducción al Laboratorio Clínico Veterinario\r\nMódulo 2: Hematología Veterinaria\r\nMódulo 3: Bioquímica Clínica Veterinaria\r\nMódulo 4: Uroanálisis y Coproparasitológica\r\nMódulo 5: Microbiología y Citología Veterinaria\r\nMódulo 6: Integración Diagnóstica y Proyecto Práctico Final', 'Ser mayor de 16 años.\r\n\r\nPresentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso.\r\n', 'Certificado de Aprobación  ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770234589_2518f117-5401-4d07-ace5-975f50c880ef.jfif', 'activo', '2026-02-03 21:00:16'),
(23, 'Curso Superior en Nutrición y Equilibrio Animal', 'Domina el diseño de dietas y principios nutricionales avanzados. Aprende de forma práctica a optimizar la salud y el rendimiento de diversas especies con bases científicas.', 'La nutrición es la base de la medicina preventiva y el rendimiento productivo. Este curso ofrece una inmersión profunda en los requerimientos nutricionales de diferentes especies, capacitando a los alumnos para formular planes alimenticios precisos y eficaces.', 'Capacitar a los participantes en los principios avanzados de nutrición y balance alimenticio en animales, combinando teoría, análisis de casos y prácticas aplicadas, para optimizar la salud, el rendimiento y el bienestar animal en diferentes especies.', 'Módulo 1: Fundamentos de Nutrición Animal\r\nMódulo 2: Evaluación y Diagnóstico Nutricional\r\nMódulo 3: Formulación y Balance de Dietas\r\nMódulo 4: Nutrición y Salud Animal\r\nMódulo 5: Innovaciones en Nutrición y Suplementación\r\nMódulo 6: Integración, Evaluación y Cierre', 'Presentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\n\r\n\r\nSer mayor de 16 años.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770153746_37e75c44-3160-4121-9939-bfb17e10bf61.jfif', 'activo', '2026-02-03 21:22:26'),
(24, 'Curso Superior en Estación Total y GNSS Avanzado', 'Capacitación avanzada en Estación Total y GNSS. Aprende a ejecutar, procesar e interpretar levantamientos topográficos y georreferenciación para ingeniería y construcción.', 'En el mundo de la ingeniería y construcción moderna, la precisión es el factor crítico de éxito. Este programa intensivo está diseñado para profesionalizar el uso de herramientas de medición electrónica y satelital, garantizando que el participante pueda liderar levantamientos topográficos bajo estándares internacionales.', 'Capacitar a los participantes en el uso avanzado de la Estación Total y sistemas GNSS, integrando fundamentos teóricos y prácticas de campo, para la correcta ejecución, procesamiento e interpretación de levantamientos topográficos de alta precisión aplicados a proyectos de ingeniería, construcción y georreferenciación', 'Módulo 1: Fundamentos de Topografía y Geodesia Aplicada\r\nMódulo 2: Manejo y Configuración de Estación Total\r\nMódulo 3: Levantamientos con Estación Total\r\nMódulo 4: Sistemas GNSS y Posicionamiento Satelital\r\nMódulo 5: Procesamiento e Integración de Dato\r\nMódulo 6: Integración, Evaluación y Cierre del Curso', 'Ser mayor de 16 años.\r\n\r\nPresentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770154424_40da7fdc-7337-4d8d-bf44-2c09cc9d0d59.jfif', 'activo', '2026-02-03 21:33:44'),
(25, 'Curso Superior en Fotogrametría y Mapeo con Drones.', 'Aprende a planificar, ejecutar y procesar levantamientos aéreos bajo la normativa de Ecuador. Genera datos geoespaciales precisos para construcción, agricultura y gestión territorial.', 'La fotogrametría ha revolucionado la captura de datos terrestres. Este programa técnico desarrolla competencias integrales para transformar imágenes aéreas en información geográfica de alta precisión, garantizando que cada proyecto cumpla con los estándares de calidad y las regulaciones aeronáuticas actuales.', 'Capacitar a los participantes en el uso de fotogrametría y mapeo, desarrollando competencias técnicas para la planificación, ejecución y procesamiento de levantamientos fotogramétricos, aplicando buenas prácticas operativas, criterios de calidad y cumplimiento de la normativa vigente en Ecuador, con el fin de generar productos geoespaciales confiables para aplicaciones en topografía, catastro, agricultura, construcción y gestión territorial.', 'Módulo 1: Fundamentos de Fotogrametría con Drones\r\nMódulo 2: Normativa, Seguridad y Planificación de Misiones\r\nMódulo 3: Ejecución de Levantamientos Fotogramétricos\r\nMódulo 4: Pilotaje Profesional y Maniobras Avanzadas\r\nMódulo 5: Aplicaciones Profesionales del Drone\r\nMódulo 6: Proyecto Práctico Final', 'Ser mayor de 16 años.\r\n\r\nPresentar documento de identidad vigente.\r\n\r\nRealizar el pago correspondiente a la matrícula o inscripción.\r\n\r\nContar con disposición para participar activamente en las prácticas del curso.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770155471_c461dfc8-cc0b-4126-8783-5afa23dd3328.jfif', 'activo', '2026-02-03 21:51:11'),
(26, 'Curso Superior en Manejo Profesional de Drones', 'Curso de drones enfocado en el uso profesional, seguro y responsable, alineado a la normativa ecuatoriana y orientado a aplicaciones comerciales.', '', 'Capacitar a los participantes en el manejo profesional, seguro y responsable de drones, desarrollando competencias técnicas, operativas y normativas que les permitan planificar, ejecutar y evaluar operaciones aéreas no tripuladas para aplicaciones profesionales y comerciales en el contexto ecuatoriano, cumpliendo la normativa vigente y aplicando buenas prácticas de seguridad, eficiencia y calidad.', 'Módulo 1: Introducción y Fundamentos del Drone\r\nMódulo 2: Normativa y Legislación en Ecuador\r\nMódulo 3: Planificación de Vuelo y Operación Técnica\r\nMódulo 4: Pilotaje Profesional y Maniobras Avanzadas\r\nMódulo 5: Aplicaciones Profesionales del Drone\r\nMódulo 6: Proyecto Práctico Final', 'Ser mayor de 16 años.\r\n\r\nNo se requiere experiencia previa.\r\n\r\nInterés en aprender sobre drones y su uso profesional.\r\n\r\nAcceso a un celular, tablet o computadora con conexión a internet.\r\n\r\nDisposición para cumplir normas de seguridad y regulaciones vigentes.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770213256_813c238d-0a8c-4f54-84fa-dff1940116d7.jfif', 'activo', '2026-02-04 13:54:16'),
(27, 'Curso Superior en Peritaje Geomensor Especializado', 'Curso de peritajes geomensores orientado a la elaboración de informes técnicos válidos para procesos administrativos y judiciales.', 'Este curso tiene como objetivo capacitar a los participantes en la realización de peritajes geomensores especializados, aplicando métodos técnicos, normativos y legales para la elaboración de informes periciales técnicamente sustentados. Los participantes desarrollarán competencias para intervenir en procesos administrativos y judiciales, garantizando rigor técnico, validez legal y cumplimiento de la normativa vigente.', 'Capacitar a los participantes en la realización de peritajes geomensores especializados, aplicando métodos técnicos, normativos y legales para la elaboración de informes periciales técnicamente sustentados, aplicables en procesos administrativos y judiciales.', 'Módulo 1: Fundamentos del Peritaje Geomensor\r\nMódulo 2: Métodos y Técnicas de Levantamiento\r\nMódulo 3: Análisis y Resolución de Conflictos de Linderos\r\nMódulo 4: Elaboración de Informes Periciales\r\nMódulo 5: Integración de Datos y Validación\r\nMódulo 6: Caso Integral y Cierre del Curso', 'Tener 18 años o más.\r\n\r\nNo se requiere experiencia previa (recomendado para profesionales o estudiantes afines).\r\n\r\nInterés en temas técnicos, legales y periciales.\r\n\r\nAcceso a computadora o dispositivo con conexión a internet.\r\n\r\nDisposición para cumplir normas técnicas y legales.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770214532_597a2ca5-c574-4f93-9357-e82762bbc282.jfif', 'activo', '2026-02-04 14:15:32'),
(28, 'Curso Superior en Python para ArcGIS: Geotecnologías Aplicadas', 'Curso de Python aplicado a ArcGIS para automatizar procesos geoespaciales y optimizar flujos de trabajo en SIG.', 'Este curso tiene como objetivo desarrollar competencias en el uso de Python aplicado a ArcGIS, permitiendo al participante automatizar procesos geoespaciales, analizar y manipular datos SIG y desarrollar scripts eficientes para la optimización de flujos de trabajo en geo tecnologías. Los conocimientos adquiridos serán aplicables en distintos contextos profesionales como planificación territorial, gestión ambiental, catastro y análisis espacial, fortaleciendo la productividad y la toma de decisiones basadas en datos.', 'Desarrollar competencias en el uso de Python aplicado a ArcGIS, permitiendo al participante automatizar procesos geoespaciales, analizar y manipular datos SIG y desarrollar scripts\r\n\r\neficientes para la optimización de flujos de trabajo en geo tecnologías, aplicables a distintos contextos profesionales como planificación territorial, gestión ambiental, catastro y análisis espacial.', 'Módulo 1: Introducción a Python para ArcGIS\r\nMódulo 2: Fundamentos de ArcPy y Manejo de Datos Geoespaciale\r\nMódulo 3: Automatización de Procesos en ArcGIS\r\nMódulo 4: Análisis Espacial y Manipulación Avanzada de Datos\r\nMódulo 5: Aplicaciones Avanzadas y Casos de Uso\r\nMódulo 6: Proyecto Práctico Final', 'Tener 16 años o más.\r\n\r\nConocimientos básicos de computación.\r\n\r\nNo es obligatorio tener experiencia previa en programación (se enseñará desde cero).\r\n\r\nAcceso a computadora con ArcGIS instalado o versión de prueba.\r\n\r\nInterés en geo tecnologías, SIG y automatización.', 'Certificado de Aprobación', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770214941_597a2ca5-c574-4f93-9357-e82762bbc282.jfif', 'activo', '2026-02-04 14:22:21'),
(29, 'Curso Superior en Sistemas de Información Geográfica (SIG) con enfoque en Teledetección', 'Curso de SIG y teledetección para el análisis y gestión de información geoespacial aplicada a la planificación y gestión ambiental.', 'Este curso tiene como objetivo capacitar a los participantes en el uso de Sistemas de Información Geográfica (SIG) y teledetección para el análisis, interpretación y gestión de información geoespacial. Los participantes desarrollarán habilidades para aplicar estas herramientas en la planificación territorial, gestión ambiental y apoyo a la toma de decisiones, fortaleciendo el análisis espacial y la gestión eficiente del territorio.', 'Capacitar a los participantes en el uso de Sistemas de Información Geográfica (SIG) y teledetección para el análisis, interpretación y gestión de información geoespacial, aplicada a la planificación territorial, gestión ambiental y apoyo a la toma de decisiones.', 'Módulo 1: Fundamentos de SIG y Cartografía Digital\r\nMódulo 2: Introducción al Software SIG\r\nMódulo 3: Análisis Espacial y Gestión de Datos Geográficos\r\nMódulo 4: Fundamentos de Teledetección\r\nMódulo 5: Procesamiento e Interpretación de Imágenes Satelitales\r\nMódulo 6: Integración SIG–Teledetección y Cierre del Curso', 'Ser mayor de 16 años.\r\n\r\nNo se requiere experiencia previa en SIG o teledetección.\r\n\r\nConocimientos básicos de computación.\r\n\r\nAcceso a computadora con conexión a internet.\r\n\r\nInterés en temas ambientales, territoriales y geotecnológicos.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770215287_ae44c104-a342-4f80-818d-31f2c96b9fe1.jfif', 'activo', '2026-02-04 14:28:07'),
(30, 'Programa de Alta Gerencia en Inteligencia Artificial aplicada a la Gestión Empresaria', 'Curso de Inteligencia Artificial aplicada a la gestión empresarial para mejorar decisiones, eficiencia e innovación.', '', 'Capacitar a los participantes en el uso estratégico y aplicado de la Inteligencia Artificial en la gestión empresarial, potenciando la toma de decisiones, la eficiencia operativa y la innovación organizacional', 'Módulo 1: Fundamentos de IA para la Gestión Empresarial\r\nMódulo 2: IA para la Toma de Decisiones Estratégicas (Parte I)\r\nMódulo 3: IA para la Toma de Decisiones Estratégicas (Parte II)\r\nMódulo 4: IA Aplicada a las Áreas Clave de la Empresa\r\nMódulo 5: IA Generativa y Productividad Ejecutiva\r\nMódulo 6: Estrategia, ética y Futuro de la IA Empresarial', 'Tener 18 años o más.\r\n\r\nNo se requieren conocimientos previos en IA o programación.\r\n\r\nConocimientos básicos de computación.\r\n\r\nAcceso a computadora o dispositivo con conexión a internet.\r\n\r\nInterés en tecnología, negocios e innovación.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770231955_12.jpg', 'activo', '2026-02-04 14:33:04'),
(31, 'Programa de Alta Gerencia en Liderazgo y Desarrollo de Habilidades Directivas', 'Curso de liderazgo y dirección enfocado en fortalecer la toma de decisiones, la gestión de equipos y el rendimiento organizacional.', 'Este curso tiene como objetivo capacitar a líderes y directivos para fortalecer sus competencias de liderazgo, toma de decisiones estratégicas y gestión de equipos. Los participantes desarrollarán habilidades directivas clave que impulsen el rendimiento organizacional, la innovación y la efectividad empresarial, promoviendo una cultura de alto desempeño y liderazgo transformacional.', 'Capacitar a líderes y directivos para fortalecer sus competencias de liderazgo, toma de decisiones estratégicas y gestión de equipos, desarrollando habilidades directivas clave que impulsen el rendimiento organizacional, la innovación y la efectividad empresarial.', 'Módulo 1: Liderazgo Estratégico y Gestión del Cambio\r\nMódulo 2: Inteligencia Emocional y Comunicación Directiva\r\nMódulo 3: Toma de Decisiones y Pensamiento Estratégico\r\nMódulo 4: Motivación y Desarrollo de Equipos de Alto Rendimiento\r\nMódulo 5: Innovación, Creatividad y Liderazgo Transformador\r\nMódulo 6: Plan de Acción y Cierre del Programa', 'Tener 18 años o más.\r\n\r\nNo se requiere experiencia previa en cargos directivos.\r\n\r\nInterés en liderazgo, gestión y desarrollo organizacional.\r\n\r\nAcceso a computadora o dispositivo con conexión a internet.\r\n\r\nDisposición para participar activamente en actividades prácticas.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770216158_cbb10664-9a81-4bd2-be86-e2cf4b9dcfb1.jfif', 'activo', '2026-02-04 14:42:38'),
(32, 'Programa de Alta Gerencia en Uso Responsable y Ético de la Inteligencia Artificial en la Empresa', 'Curso de ética y uso responsable de la Inteligencia Artificial para líderes y profesionales.', 'Este curso tiene como objetivo capacitar a profesionales y líderes empresariales para comprender, aplicar y supervisar el uso responsable, ético y seguro de la Inteligencia Artificial. Los participantes aprenderán a alinear la implementación de la IA con principios éticos, normativos y estratégicos dentro de la organización, promoviendo una adopción tecnológica confiable, transparente y sostenible.', 'Capacitar a profesionales y líderes empresariales para comprender, aplicar y supervisar el uso responsable, ético y seguro de la Inteligencia Artificial, alineando su implementación con principios éticos, normativos y estratégicos dentro de la organización.', 'Módulo 1: Inteligencia Artificial y Estrategia Empresarial\r\nMódulo 2: Ética Corporativa y Principios de IA Responsable\r\nMódulo 3: Riesgos Legales, Privacidad y Cumplimiento Normativo en IA\r\nMódulo 4: Uso Responsable de la IA Generativa en el Entorno Empresarial\r\nMódulo 5: Gobierno de la IA, Cultura Organizacional y Futuro\r\nMódulo 6: Proyecto Estratégico de Uso Responsable de la IA', 'Tener 18 años o más.\r\n\r\nNo se requieren conocimientos técnicos previos en IA.\r\n\r\nInterés en ética, tecnología, gestión y gobernanza digital.\r\n\r\nAcceso a computadora o dispositivo con conexión a internet.\r\n\r\nDisposición para el análisis de casos y reflexión crítica.', 'Certificado de Aprobación ', 45, 45, '2026-03-02', '2026-03-30', '2026-02-23', '1770216433_0896586f-6c6c-4d4e-95ea-3fea7f214f96.jfif', 'activo', '2026-02-04 14:47:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_modalidades`
--

CREATE TABLE `cursos_modalidades` (
  `id` int NOT NULL,
  `id_curso` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cupos` int DEFAULT '0',
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `horarios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `icono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cursos_modalidades`
--

INSERT INTO `cursos_modalidades` (`id`, `id_curso`, `nombre`, `precio`, `cupos`, `descripcion`, `horarios`, `icono`) VALUES
(118, 20, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).  · Alimentación: Desayuno, almuerzo y cena incluidos.  · Estación de bebidas: Café, té y refrescos durante los descansos.  · Visita turística: Excursión al centro de Quito para fortalecer la integración.  · Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Viernes, sábado y domingo', NULL),
(119, 20, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n· Certificados', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(120, 20, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n· Certificados', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(127, 23, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).  · Alimentación: Desayuno, almuerzo y cena incluidos.  · Estación de bebidas: Café, té y refrescos durante los descansos.  · Visita turística: Excursión al centro de Quito para fortalecer la integración.  · Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(128, 23, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n· Certificados', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(129, 23, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificados', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(130, 24, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(131, 24, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(132, 24, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(133, 25, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(134, 25, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(135, 25, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(139, 26, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(140, 26, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(141, 26, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(142, 27, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(143, 27, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(144, 27, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(145, 28, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(146, 28, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(147, 28, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(148, 29, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(149, 29, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(150, 29, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(163, 31, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(164, 31, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(165, 31, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(166, 32, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(167, 32, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(168, 32, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(181, 19, 'Intensivo/VIP', 240.00, 15, '•Hospedaje: incluido por 3 días (2 noches). \r\n•Alimentación: Desayuno, almuerzo y cena incluidos. \r\n•Estación de bebidas: Café, té y refrescos durante los descansos. \r\n•Visita turística: Excursión al centro de Quito para fortalecer la integración. \r\n•Transporte: ida y vuelta (en caso de que sea fuera de Quito) ', 'Viernes, sábado y domingo  ', NULL),
(182, 19, 'Presencial', 120.00, 15, '•Estación de bebidas: Café, té y refrescos durante los descansos.  •Certificado\r\n', '•	Horario matutino  Martes y jueves: 7:00 – 9:00 Sábados: 8:00 – 12:00  / •	Horario nocturno   	Martes y jueves: 18:00 – 20:00  Sábados: 8:00 – 12:00 ', NULL),
(183, 19, 'Híbrida', 70.00, 15, '•Estación de bebidas: Café, té y refrescos durante los descansos.\r\n•Certificado\r\n', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  Presencial: sábados (8:00 – 12:00) ', NULL),
(187, 30, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.\r\n\r\n· Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(188, 30, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00                   Horario nocturno :  Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(189, 30, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(196, 21, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).\r\n\r\n· Alimentación: Desayuno, almuerzo y cena incluidos.\r\n\r\n· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n\r\n· Visita turística: Excursión al centro de Quito para fortalecer la integración.', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(197, 21, 'Presencial', 120.00, 15, 'Estación de bebidas: Café, té y refrescos durante los descansos.\r\nCertificados', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(198, 21, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.\r\n· Certificados', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL),
(199, 22, 'Intensivo/VIP', 240.00, 15, '· Hospedaje: incluido por 3 días (2 noches).  · Alimentación: Desayuno, almuerzo y cena incluidos.  · Estación de bebidas: Café, té y refrescos durante los descansos.  · Visita turística: Excursión al centro de Quito para fortalecer la integración.  · Transporte: ida y vuelta (en caso de que sea fuera de Quito)', 'Horario matutino  o Viernes, sábado y domingo', NULL),
(200, 22, 'Presencial', 120.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.  · Certificado', 'Martes y jueves: 7:00 – 9:00 o Sábados: 8:00 – 12:00      Horario nocturno  o Martes y jueves: 18:00 – 20:00 o Sábados: 8:00 – 12:00', NULL),
(201, 22, 'Híbrida', 70.00, 15, '· Estación de bebidas: Café, té y refrescos durante los descansos.  · Certificado', 'Virtual: lunes, miércoles y jueves (19:00 – 21:00)  o Presencial: sábados (8:00 – 12:00)', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_inscripcion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_curso` int NOT NULL,
  `estado_pago` enum('pendiente','pagado') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'pendiente',
  `fecha_inscripcion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado_academico` enum('cursando','aprobado','reprobado') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'cursando',
  `nota_final` decimal(5,2) DEFAULT '0.00',
  `certificado_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `modalidad` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `horario` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int NOT NULL,
  `id_inscripcion` int NOT NULL,
  `metodo_pago` enum('transferencia','payphone') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `comprobante_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `payphone_id_transaccion` int DEFAULT NULL,
  `payphone_client_transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_pago` enum('pendiente','aprobado','rechazado') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'pendiente',
  `tipo_verificacion` enum('manual','automatica') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'manual',
  `fecha_pago` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `cedula_ruc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `rol` enum('admin','estudiante') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'estudiante',
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula_ruc`, `nombre`, `apellido`, `email`, `password`, `rol`, `telefono`, `fecha_registro`) VALUES
(1, '1725433203', 'Matias Scott', 'Valdivieso Salvatierra', 'matias.valdivieso@superarse.edu.ec', '$2y$10$Sktv8wZV/2nDN5LmscLeWOex1hiHlZ5pKeYmMYJYpbBrrSyQLHMt.', 'admin', '0963796633', '2026-01-21 05:14:47'),
(2, '1724765217', 'Cindy Carolina', 'Baquero Bravo', 'carolina.baquero@superarse.edu.ec', '$2y$10$J26dFFughvfxAnVmzLU.zOaeDK.5iWWThFjv6wFuJwx60WKHX0d7S', 'admin', NULL, '2026-01-21 05:14:47'),
(3, '1727972695', 'Jennifer Michelle', 'Betancourt Sani', 'jennifer.betancourt@superarse.edu.ec', '$2y$10$lU0uJ12NJ0JirER08ifa4.SToWMFYgXx0ZjEN1TfAxl6kYcTNSwim', 'admin', NULL, '2026-01-21 05:14:47'),
(10, '1724259302', 'Alisson', 'Ortiz', 'alisson.ortiz@superarse.edu.ec', '$2y$10$DW24V/ePvdaMeA9K4kqnfu3eDprK7N.bwGHlO9PtjO2FKoYmE4Nti', 'admin', 'SIN-TELEFONO', '2026-01-27 00:54:07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`) USING BTREE;

--
-- Indices de la tabla `cursos_modalidades`
--
ALTER TABLE `cursos_modalidades`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_curso` (`id_curso`) USING BTREE;

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscripcion`) USING BTREE,
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE,
  ADD KEY `id_curso` (`id_curso`) USING BTREE;

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`) USING BTREE,
  ADD KEY `id_inscripcion` (`id_inscripcion`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`) USING BTREE,
  ADD UNIQUE KEY `cedula_ruc` (`cedula_ruc`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `cursos_modalidades`
--
ALTER TABLE `cursos_modalidades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscripcion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos_modalidades`
--
ALTER TABLE `cursos_modalidades`
  ADD CONSTRAINT `cursos_modalidades_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripciones` (`id_inscripcion`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
