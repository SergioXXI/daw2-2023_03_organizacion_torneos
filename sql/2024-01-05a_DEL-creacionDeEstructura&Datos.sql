<<<<<<< HEAD
DROP DATABASE IF EXISTS `daw2_2023_03_organizacion_torneos`;
CREATE DATABASE `daw2_2023_03_organizacion_torneos`
    DEFAULT CHARACTER SET = 'utf8mb4';
USE `daw2_2023_03_organizacion_torneos`;

-- SCHEMA
-- Iniciar transacción
START TRANSACTION;

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000)
);

DROP TABLE IF EXISTS `torneo`;
CREATE TABLE `torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000),
  `participantes_max` int NOT NULL,
  `disciplina_id` bigint NOT NULL,
  `tipo_torneo_id` bigint NOT NULL,
  `clase_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `torneo_imagen`;
CREATE TABLE `torneo_imagen` (
  `torneo_id` bigint NOT NULL,
  `imagen_id` bigint,
  PRIMARY KEY (`torneo_id`, `imagen_id`)
);

DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE `disciplina` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(1000)
);

DROP TABLE IF EXISTS `tipo_torneo`;
CREATE TABLE `tipo_torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS `clase`;
CREATE TABLE `clase` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(1000),
  `imagen_id` bigint
);

DROP TABLE IF EXISTS `normativa`;
CREATE TABLE `normativa` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) UNIQUE NOT NULL,
  `descripcion` varchar(1000),
  `documento_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `torneo_normativa`;
CREATE TABLE `torneo_normativa` (
  `torneo_id` bigint NOT NULL,
  `normativa_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `normativa_id`)
);

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `edad_min` int NOT NULL,
  `edad_max` int NOT NULL
);

DROP TABLE IF EXISTS `premio`;
CREATE TABLE `premio` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL COMMENT 'trofeo',
  `descripcion` varchar(500),
  `categoria_id` bigint NOT NULL,
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint
);

DROP TABLE IF EXISTS `torneo_categoria`;
CREATE TABLE `torneo_categoria` (
  `torneo_id` bigint NOT NULL,
  `categoria_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `categoria_id`)
);

DROP TABLE IF EXISTS `partido`;
CREATE TABLE `partido` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `jornada` int NOT NULL,
  `fecha` timestamp NOT NULL,
  `torneo_id` bigint NOT NULL,
  `direccion_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `partido_equipo`;
CREATE TABLE `partido_equipo` (
  `partido_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  `puntos` int NOT NULL COMMENT 'Puntos de ese equipo en ese partido',
  PRIMARY KEY (`partido_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `torneo_equipo`;
CREATE TABLE `torneo_equipo` (
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE `equipo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(10000),
  `licencia` varchar(250) UNIQUE NOT NULL COMMENT 'Numero de licencia',
  `categoria_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `equipo_participante`;
CREATE TABLE `equipo_participante` (
  `equipo_id` bigint NOT NULL,
  `participante_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol_id` bigint
);

DROP TABLE IF EXISTS `participante`;
CREATE TABLE `participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha_nacimiento` date NOT NULL,
  `licencia` varchar(250) UNIQUE NOT NULL,
  `tipo_participante_id` bigint NOT NULL,
  `imagen_id` bigint,
  `usuario_id` bigint UNIQUE
);

DROP TABLE IF EXISTS `participante_documento`;
CREATE TABLE `participante_documento` (
  `participante_id` bigint NOT NULL,
  `documento_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `documento_id`)
);

DROP TABLE IF EXISTS `tipo_participante`;
CREATE TABLE `tipo_participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(500)
);

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `usuario_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(500)
);

DROP TABLE IF EXISTS `pista`;
CREATE TABLE `pista` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(100),
  `direccion_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `reserva_material`;
CREATE TABLE `reserva_material` (
  `reserva_id` bigint NOT NULL,
  `material_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `material_id`)
);

DROP TABLE IF EXISTS `reserva_pista`;
CREATE TABLE `reserva_pista` (
  `reserva_id` bigint NOT NULL,
  `pista_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `pista_id`)
);

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `direccion` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `calle` varchar(100) NOT NULL,
  `numero` int,
  `cod_postal` int NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL
);

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE `imagen` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) UNIQUE NOT NULL
);

ALTER TABLE `torneo` COMMENT = 'Tabla principal de torneo';

ALTER TABLE `disciplina` COMMENT = 'Por ej si el torneo es de fútbol, baloncesto...';

ALTER TABLE `tipo_torneo` COMMENT = 'Por ej: Triangular';

ALTER TABLE `clase` COMMENT = 'Por ej: Campeonato Nacional';

ALTER TABLE `torneo` ADD FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`);

ALTER TABLE `torneo` ADD FOREIGN KEY (`tipo_torneo_id`) REFERENCES `tipo_torneo` (`id`);

ALTER TABLE `torneo` ADD FOREIGN KEY (`clase_id`) REFERENCES `clase` (`id`);

ALTER TABLE `torneo_imagen` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_imagen` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `clase` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `normativa` ADD FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`);

ALTER TABLE `torneo_normativa` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_normativa` ADD FOREIGN KEY (`normativa_id`) REFERENCES `normativa` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `torneo_categoria` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_categoria` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `partido` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `partido` ADD FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`);

ALTER TABLE `partido_equipo` ADD FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`);

ALTER TABLE `partido_equipo` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `torneo_equipo` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_equipo` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `equipo` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `equipo_participante` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `equipo_participante` ADD FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`tipo_participante_id`) REFERENCES `tipo_participante` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

ALTER TABLE `participante_documento` ADD FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`);

ALTER TABLE `participante_documento` ADD FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`);

ALTER TABLE `reserva` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

ALTER TABLE `pista` ADD FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`);

ALTER TABLE `reserva_material` ADD FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

ALTER TABLE `reserva_material` ADD FOREIGN KEY (`material_id`) REFERENCES `material` (`id`);

ALTER TABLE `reserva_pista` ADD FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

ALTER TABLE `reserva_pista` ADD FOREIGN KEY (`pista_id`) REFERENCES `pista` (`id`);

ALTER TABLE `usuario` ADD FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

-- Confirmar la transacción
COMMIT;

-- DATA

-- Iniciar transacción
START TRANSACTION;
INSERT INTO rol (nombre, descripcion) VALUES
    ('sysadmin', 'Tiene acceso a absolutamente todo'),
    ('admin', 'Administrador del sistema'),
    ('organizador', 'Usuario registrado que organiza torneos'),
    ('gestor', 'Usuario registrado que gestiona equipos'),
    ('participante', 'Usuario registrado que participa en torneos');
    -- ('guest', 'Usuario no registrado');


-- Insertar datos de prueba para la tabla 'disciplina'
INSERT INTO disciplina (nombre, descripcion) VALUES
    ('Fútbol', 'Deporte de equipo con un balón'),
    ('Baloncesto', 'Deporte de equipo con una pelota naranja'),
    ('Tenis', 'Deporte de raqueta individual');

-- Insertar datos de prueba para la tabla 'tipo_torneo'
INSERT INTO tipo_torneo (nombre) VALUES
    ('Eliminatorias'),
    ('Liga'),
    ('Torneo amistoso');

-- Insertar datos de prueba para la tabla 'imagen'
INSERT INTO imagen (ruta) VALUES
    ('/imagenes/img1.jpg'),
    ('/imagenes/img2.jpg'),
    ('/imagenes/img3.jpg');

-- Insertar datos de prueba para la tabla 'clase'
INSERT INTO clase (titulo, descripcion, imagen_id) VALUES
    ('Campeonato Nacional', 'Torneo de alto nivel nacional', 1),
    ('Torneo Local', 'Competición a nivel local', 2),
    ('Copa Internacional', 'Torneo con equipos de diferentes países', 3);

INSERT INTO `torneo` (`nombre`, `descripcion`, `participantes_max`, `disciplina_id`, `tipo_torneo_id`, `clase_id`)
VALUES
  ('Torneo de Fútbol', 'Torneo de fútbol a nivel nacional', 16, 1, 1, 1),
  ('Torneo de Baloncesto', 'Torneo de baloncesto juvenil', 12, 2, 2, 2),
  ('Torneo de Tenis', 'Torneo de tenis individual', 32, 3, 3, 3);

-- Insertar datos de prueba para la tabla 'documento'
INSERT INTO documento (ruta) VALUES
    ('/documentos/doc1.pdf'),
    ('/documentos/doc2.pdf'),
    ('/documentos/doc3.pdf');
    
-- Insertar datos de prueba para la tabla 'normativa'
INSERT INTO normativa (nombre, descripcion, documento_id) VALUES
    ('Normativa 1', 'Descripción de la normativa 1', 1),
    ('Normativa 2', 'Descripción de la normativa 2', 2),
    ('Normativa 3', 'Descripción de la normativa 3', 3);

-- Insertar datos de prueba para la tabla 'categoria'
INSERT INTO categoria (nombre, edad_min, edad_max) VALUES
    ('Infantil', 6, 12),
    ('Juvenil', 13, 18),
    ('Adulto', 19, 99);

-- Insertar datos de prueba para la tabla 'equipo'
INSERT INTO equipo (nombre, descripcion, licencia, categoria_id) VALUES
    ('Equipo A', 'Descripción del Equipo A', 'ABC123', 1),
    ('Equipo B', 'Descripción del Equipo B', 'XYZ789', 2),
    ('Equipo C', 'Descripción del Equipo C', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'premio'
INSERT INTO premio (nombre, descripcion, categoria_id, torneo_id, equipo_id) VALUES
    ('Trofeo 1', 'Descripción del trofeo 1', 1, 1, 1),
    ('Trofeo 2', 'Descripción del trofeo 2', 2, 2, 2),
    ('Trofeo 3', 'Descripción del trofeo 3', 3, 3, 3);

-- Insertar datos de prueba para la tabla 'torneo_categoria'
INSERT INTO torneo_categoria (torneo_id, categoria_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'direccion'
INSERT INTO direccion (calle, numero, cod_postal, ciudad, provincia, pais) VALUES
    ('Calle Principal', 123, 12345, 'Ciudad A', 'Provincia X', 'País Y'),
    ('Avenida Secundaria', 456, 54321, 'Ciudad B', 'Provincia Z', 'País W');

-- Insertar datos de prueba para la tabla 'partido'
INSERT INTO partido (jornada, fecha, torneo_id, direccion_id) VALUES
    (1, '2024-01-01', 1, 1),
    (2, '2024-02-01', 2, 2),
    (3, '2024-03-01', 3, 1);

-- Insertar datos de prueba para la tabla 'partido_equipo'
INSERT INTO partido_equipo (partido_id, equipo_id, puntos) VALUES
    (1, 1, 3),
    (1, 2, 1),
    (2, 3, 2);

-- Insertar datos de prueba para la tabla 'torneo_equipo'
INSERT INTO torneo_equipo (torneo_id, equipo_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'tipo_participante'
INSERT INTO tipo_participante (nombre, descripcion) VALUES
    ('Jugador', 'Participante que juega en equipos'),
    ('Árbitro', 'Oficial encargado de hacer cumplir las reglas'),
    ('Entrenador', 'Persona a cargo del entrenamiento del equipo');

-- Insertar datos de prueba para la tabla 'participante'
INSERT INTO participante (fecha_nacimiento, licencia, tipo_participante_id) VALUES
    ('1990-05-15', 'ABC123', 1),
    ('1985-12-10', 'XYZ789', 2),
    ('1995-08-22', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'equipo_participante'
INSERT INTO equipo_participante (equipo_id, participante_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'usuario'
INSERT INTO usuario (nombre, apellido1, apellido2, email, rol_id, password) VALUES
    ('Juan', 'Pérez', 'Gómez', 'juan@example.com', 1, '123'),
    ('María', 'García', 'López', 'maria@example.com', 2, '1234'),
    ('Pedro', 'Martínez', 'Sánchez', 'pedrito@example.com', 3, '12345'),
    ('Ana', 'Rodríguez', 'Fernández', 'anita@example.com', 4, '123456'),
    ('Luis', 'González', 'García', 'surluisito29@example.com', 5, '1234567');


-- Insertar datos de prueba para la tabla 'participante_documento'
INSERT INTO participante_documento (participante_id, documento_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'reserva'
INSERT INTO reserva (fecha, usuario_id) VALUES
    ('2024-01-15', 1),
    ('2024-02-20', 2),
    ('2024-03-25', 1);

-- Insertar datos de prueba para la tabla 'material'
INSERT INTO material (nombre, color, descripcion) VALUES
    ('Balón', 'Blanco y negro', 'Balón de fútbol'),
    ('Raqueta', 'Rojo', 'Raqueta de tenis'),
    ('Silbato', 'Plateado', 'Silbato para árbitro');

-- Insertar datos de prueba para la tabla 'pista'
INSERT INTO pista (nombre, descripcion, direccion_id) VALUES
    ('Pista 1', 'Descripción de la Pista 1', 1),
    ('Pista 2', 'Descripción de la Pista 2', 2),
    ('Pista 3', 'Descripción de la Pista 3', 1);

-- Insertar datos de prueba para la tabla 'reserva_material'
INSERT INTO reserva_material (reserva_id, material_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'reserva_pista'
INSERT INTO reserva_pista (reserva_id, pista_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Confirmar la transacción
COMMIT;
=======
DROP DATABASE IF EXISTS `daw2_2023_03_organizacion_torneos`;
CREATE DATABASE `daw2_2023_03_organizacion_torneos`
    DEFAULT CHARACTER SET = 'utf8mb4';
USE `daw2_2023_03_organizacion_torneos`;

-- SCHEMA
-- Iniciar transacción
START TRANSACTION;

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000)
);

DROP TABLE IF EXISTS `torneo`;
CREATE TABLE `torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000),
  `participantes_max` int NOT NULL,
  `disciplina_id` bigint NOT NULL,
  `tipo_torneo_id` bigint NOT NULL,
  `clase_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `torneo_imagen`;
CREATE TABLE `torneo_imagen` (
  `torneo_id` bigint NOT NULL,
  `imagen_id` bigint,
  PRIMARY KEY (`torneo_id`, `imagen_id`)
);

DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE `disciplina` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(1000)
);

DROP TABLE IF EXISTS `tipo_torneo`;
CREATE TABLE `tipo_torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS `clase`;
CREATE TABLE `clase` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(1000),
  `imagen_id` bigint
);

DROP TABLE IF EXISTS `normativa`;
CREATE TABLE `normativa` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) UNIQUE NOT NULL,
  `descripcion` varchar(1000),
  `documento_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `torneo_normativa`;
CREATE TABLE `torneo_normativa` (
  `torneo_id` bigint NOT NULL,
  `normativa_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `normativa_id`)
);

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `edad_min` int NOT NULL,
  `edad_max` int NOT NULL
);

DROP TABLE IF EXISTS `premio`;
CREATE TABLE `premio` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL COMMENT 'trofeo',
  `descripcion` varchar(500),
  `categoria_id` bigint NOT NULL,
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint
);

DROP TABLE IF EXISTS `torneo_categoria`;
CREATE TABLE `torneo_categoria` (
  `torneo_id` bigint NOT NULL,
  `categoria_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `categoria_id`)
);

DROP TABLE IF EXISTS `partido`;
CREATE TABLE `partido` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `jornada` int NOT NULL,
  `fecha` timestamp NOT NULL,
  `torneo_id` bigint NOT NULL,
  `direccion_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `partido_equipo`;
CREATE TABLE `partido_equipo` (
  `partido_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  `puntos` int NOT NULL COMMENT 'Puntos de ese equipo en ese partido',
  PRIMARY KEY (`partido_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `torneo_equipo`;
CREATE TABLE `torneo_equipo` (
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE `equipo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(10000),
  `licencia` varchar(250) UNIQUE NOT NULL COMMENT 'Numero de licencia',
  `categoria_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `equipo_participante`;
CREATE TABLE `equipo_participante` (
  `equipo_id` bigint NOT NULL,
  `participante_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `equipo_id`)
);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol_id` bigint
);

DROP TABLE IF EXISTS `participante`;
CREATE TABLE `participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha_nacimiento` date NOT NULL,
  `licencia` varchar(250) UNIQUE NOT NULL,
  `tipo_participante_id` bigint NOT NULL,
  `imagen_id` bigint,
  `usuario_id` bigint UNIQUE
);

DROP TABLE IF EXISTS `participante_documento`;
CREATE TABLE `participante_documento` (
  `participante_id` bigint NOT NULL,
  `documento_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `documento_id`)
);

DROP TABLE IF EXISTS `tipo_participante`;
CREATE TABLE `tipo_participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(500)
);

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `usuario_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(500)
);

DROP TABLE IF EXISTS `pista`;
CREATE TABLE `pista` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(100),
  `direccion_id` bigint NOT NULL
);

DROP TABLE IF EXISTS `reserva_material`;
CREATE TABLE `reserva_material` (
  `reserva_id` bigint NOT NULL,
  `material_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `material_id`)
);

DROP TABLE IF EXISTS `reserva_pista`;
CREATE TABLE `reserva_pista` (
  `reserva_id` bigint NOT NULL,
  `pista_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `pista_id`)
);

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `direccion` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `calle` varchar(100) NOT NULL,
  `numero` int,
  `cod_postal` int NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL
);

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE `imagen` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) UNIQUE NOT NULL
);

ALTER TABLE `torneo` COMMENT = 'Tabla principal de torneo';

ALTER TABLE `disciplina` COMMENT = 'Por ej si el torneo es de fútbol, baloncesto...';

ALTER TABLE `tipo_torneo` COMMENT = 'Por ej: Triangular';

ALTER TABLE `clase` COMMENT = 'Por ej: Campeonato Nacional';

ALTER TABLE `torneo` ADD FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`);

ALTER TABLE `torneo` ADD FOREIGN KEY (`tipo_torneo_id`) REFERENCES `tipo_torneo` (`id`);

ALTER TABLE `torneo` ADD FOREIGN KEY (`clase_id`) REFERENCES `clase` (`id`);

ALTER TABLE `torneo_imagen` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_imagen` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `clase` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `normativa` ADD FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`);

ALTER TABLE `torneo_normativa` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_normativa` ADD FOREIGN KEY (`normativa_id`) REFERENCES `normativa` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `premio` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `torneo_categoria` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_categoria` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `partido` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `partido` ADD FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`);

ALTER TABLE `partido_equipo` ADD FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`);

ALTER TABLE `partido_equipo` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `torneo_equipo` ADD FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`);

ALTER TABLE `torneo_equipo` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `equipo` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

ALTER TABLE `equipo_participante` ADD FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);

ALTER TABLE `equipo_participante` ADD FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`tipo_participante_id`) REFERENCES `tipo_participante` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`);

ALTER TABLE `participante` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

ALTER TABLE `participante_documento` ADD FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`);

ALTER TABLE `participante_documento` ADD FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`);

ALTER TABLE `reserva` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

ALTER TABLE `pista` ADD FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`);

ALTER TABLE `reserva_material` ADD FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

ALTER TABLE `reserva_material` ADD FOREIGN KEY (`material_id`) REFERENCES `material` (`id`);

ALTER TABLE `reserva_pista` ADD FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

ALTER TABLE `reserva_pista` ADD FOREIGN KEY (`pista_id`) REFERENCES `pista` (`id`);

ALTER TABLE `usuario` ADD FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

-- Confirmar la transacción
COMMIT;

-- DATA

-- Iniciar transacción
START TRANSACTION;
INSERT INTO rol (nombre, descripcion) VALUES
    ('sysadmin', 'Tiene acceso a absolutamente todo'),
    ('admin', 'Administrador del sistema'),
    ('organizador', 'Usuario registrado que organiza torneos'),
    ('gestor', 'Usuario registrado que gestiona equipos'),
    ('participante', 'Usuario registrado que participa en torneos');
    -- ('guest', 'Usuario no registrado');


-- Insertar datos de prueba para la tabla 'disciplina'
INSERT INTO disciplina (nombre, descripcion) VALUES
    ('Fútbol', 'Deporte de equipo con un balón'),
    ('Baloncesto', 'Deporte de equipo con una pelota naranja'),
    ('Tenis', 'Deporte de raqueta individual');

-- Insertar datos de prueba para la tabla 'tipo_torneo'
INSERT INTO tipo_torneo (nombre) VALUES
    ('Eliminatorias'),
    ('Liga'),
    ('Torneo amistoso');

-- Insertar datos de prueba para la tabla 'imagen'
INSERT INTO imagen (ruta) VALUES
    ('/imagenes/img1.jpg'),
    ('/imagenes/img2.jpg'),
    ('/imagenes/img3.jpg');

-- Insertar datos de prueba para la tabla 'clase'
INSERT INTO clase (titulo, descripcion, imagen_id) VALUES
    ('Campeonato Nacional', 'Torneo de alto nivel nacional', 1),
    ('Torneo Local', 'Competición a nivel local', 2),
    ('Copa Internacional', 'Torneo con equipos de diferentes países', 3);

INSERT INTO `torneo` (`nombre`, `descripcion`, `participantes_max`, `disciplina_id`, `tipo_torneo_id`, `clase_id`)
VALUES
  ('Torneo de Fútbol', 'Torneo de fútbol a nivel nacional', 16, 1, 1, 1),
  ('Torneo de Baloncesto', 'Torneo de baloncesto juvenil', 12, 2, 2, 2),
  ('Torneo de Tenis', 'Torneo de tenis individual', 32, 3, 3, 3);

-- Insertar datos de prueba para la tabla 'documento'
INSERT INTO documento (ruta) VALUES
    ('/documentos/doc1.pdf'),
    ('/documentos/doc2.pdf'),
    ('/documentos/doc3.pdf');
    
-- Insertar datos de prueba para la tabla 'normativa'
INSERT INTO normativa (nombre, descripcion, documento_id) VALUES
    ('Normativa 1', 'Descripción de la normativa 1', 1),
    ('Normativa 2', 'Descripción de la normativa 2', 2),
    ('Normativa 3', 'Descripción de la normativa 3', 3);

-- Insertar datos de prueba para la tabla 'categoria'
INSERT INTO categoria (nombre, edad_min, edad_max) VALUES
    ('Infantil', 6, 12),
    ('Juvenil', 13, 18),
    ('Adulto', 19, 99);

-- Insertar datos de prueba para la tabla 'equipo'
INSERT INTO equipo (nombre, descripcion, licencia, categoria_id) VALUES
    ('Equipo A', 'Descripción del Equipo A', 'ABC123', 1),
    ('Equipo B', 'Descripción del Equipo B', 'XYZ789', 2),
    ('Equipo C', 'Descripción del Equipo C', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'premio'
INSERT INTO premio (nombre, descripcion, categoria_id, torneo_id, equipo_id) VALUES
    ('Trofeo 1', 'Descripción del trofeo 1', 1, 1, 1),
    ('Trofeo 2', 'Descripción del trofeo 2', 2, 2, 2),
    ('Trofeo 3', 'Descripción del trofeo 3', 3, 3, 3);

-- Insertar datos de prueba para la tabla 'torneo_categoria'
INSERT INTO torneo_categoria (torneo_id, categoria_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'direccion'
INSERT INTO direccion (calle, numero, cod_postal, ciudad, provincia, pais) VALUES
    ('Calle Principal', 123, 12345, 'Ciudad A', 'Provincia X', 'País Y'),
    ('Avenida Secundaria', 456, 54321, 'Ciudad B', 'Provincia Z', 'País W');

-- Insertar datos de prueba para la tabla 'partido'
INSERT INTO partido (jornada, fecha, torneo_id, direccion_id) VALUES
    (1, '2024-01-01', 1, 1),
    (2, '2024-02-01', 2, 2),
    (3, '2024-03-01', 3, 1);

-- Insertar datos de prueba para la tabla 'partido_equipo'
INSERT INTO partido_equipo (partido_id, equipo_id, puntos) VALUES
    (1, 1, 3),
    (1, 2, 1),
    (2, 3, 2);

-- Insertar datos de prueba para la tabla 'torneo_equipo'
INSERT INTO torneo_equipo (torneo_id, equipo_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'tipo_participante'
INSERT INTO tipo_participante (nombre, descripcion) VALUES
    ('Jugador', 'Participante que juega en equipos'),
    ('Árbitro', 'Oficial encargado de hacer cumplir las reglas'),
    ('Entrenador', 'Persona a cargo del entrenamiento del equipo');

-- Insertar datos de prueba para la tabla 'participante'
INSERT INTO participante (fecha_nacimiento, licencia, tipo_participante_id) VALUES
    ('1990-05-15', 'ABC123', 1),
    ('1985-12-10', 'XYZ789', 2),
    ('1995-08-22', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'equipo_participante'
INSERT INTO equipo_participante (equipo_id, participante_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'usuario'
INSERT INTO usuario (nombre, apellido1, apellido2, email, rol_id, password) VALUES
    ('Juan', 'Pérez', 'Gómez', 'juan@example.com', 1, '123'),
    ('María', 'García', 'López', 'maria@example.com', 2, '1234'),
    ('Pedro', 'Martínez', 'Sánchez', 'pedrito@example.com', 3, '12345'),
    ('Ana', 'Rodríguez', 'Fernández', 'anita@example.com', 4, '123456'),
    ('Luis', 'González', 'García', 'surluisito29@example.com', 5, '1234567');


-- Insertar datos de prueba para la tabla 'participante_documento'
INSERT INTO participante_documento (participante_id, documento_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'reserva'
INSERT INTO reserva (fecha, usuario_id) VALUES
    ('2024-01-15', 1),
    ('2024-02-20', 2),
    ('2024-03-25', 1);

-- Insertar datos de prueba para la tabla 'material'
INSERT INTO material (nombre, color, descripcion) VALUES
    ('Balón', 'Blanco y negro', 'Balón de fútbol'),
    ('Raqueta', 'Rojo', 'Raqueta de tenis'),
    ('Silbato', 'Plateado', 'Silbato para árbitro');

-- Insertar datos de prueba para la tabla 'pista'
INSERT INTO pista (nombre, descripcion, direccion_id) VALUES
    ('Pista 1', 'Descripción de la Pista 1', 1),
    ('Pista 2', 'Descripción de la Pista 2', 2),
    ('Pista 3', 'Descripción de la Pista 3', 1);

-- Insertar datos de prueba para la tabla 'reserva_material'
INSERT INTO reserva_material (reserva_id, material_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'reserva_pista'
INSERT INTO reserva_pista (reserva_id, pista_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Confirmar la transacción
COMMIT;
>>>>>>> origin/G2-Torneos
