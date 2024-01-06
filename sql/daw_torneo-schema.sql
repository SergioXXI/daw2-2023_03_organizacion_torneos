DROP DATABASE IF EXISTS `daw2_2023_03_organizacion_torneos`;
CREATE DATABASE `daw2_2023_03_organizacion_torneos`
    DEFAULT CHARACTER SET = 'utf8mb4';
USE `daw_torneo`;

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
