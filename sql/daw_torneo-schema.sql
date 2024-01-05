CREATE TABLE `torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `participantes_max` int NOT NULL,
  `disciplina_id` bigint NOT NULL,
  `tipo_torneo_id` bigint NOT NULL,
  `clase_id` bigint NOT NULL
);

CREATE TABLE `torneo_imagen` (
  `torneo_id` bigint NOT NULL,
  `imagen_id` bigint,
  PRIMARY KEY (`torneo_id`, `imagen_id`)
);

CREATE TABLE `disciplina` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(1000)
);

CREATE TABLE `tipo_torneo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL
);

CREATE TABLE `clase` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(1000),
  `imagen_id` bigint
);

CREATE TABLE `normativa` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) UNIQUE NOT NULL,
  `descripcion` varchar(1000),
  `documento_id` bigint NOT NULL
);

CREATE TABLE `torneo_normativa` (
  `torneo_id` bigint NOT NULL,
  `normativa_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `normativa_id`)
);

CREATE TABLE `categoria` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `edad_min` int NOT NULL,
  `edad_max` int NOT NULL
);

CREATE TABLE `premio` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL COMMENT 'trofeo',
  `descripcion` varchar(500),
  `categoria_id` bigint NOT NULL,
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint
);

CREATE TABLE `torneo_categoria` (
  `torneo_id` bigint NOT NULL,
  `categoria_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `categoria_id`)
);

CREATE TABLE `partido` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `jornada` int NOT NULL,
  `fecha` timestamp NOT NULL,
  `torneo_id` bigint NOT NULL,
  `direccion_id` bigint NOT NULL
);

CREATE TABLE `partido_equipo` (
  `partido_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  `puntos` int NOT NULL COMMENT 'Puntos de ese equipo en ese partido',
  PRIMARY KEY (`partido_id`, `equipo_id`)
);

CREATE TABLE `torneo_equipo` (
  `torneo_id` bigint NOT NULL,
  `equipo_id` bigint NOT NULL,
  PRIMARY KEY (`torneo_id`, `equipo_id`)
);

CREATE TABLE `equipo` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(10000),
  `licencia` varchar(250) UNIQUE NOT NULL COMMENT 'Numero de licencia',
  `categoria_id` bigint NOT NULL
);

CREATE TABLE `equipo_participante` (
  `equipo_id` bigint NOT NULL,
  `participante_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `equipo_id`)
);

CREATE TABLE `usuario` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL,
  `rol` varchar(100),
  `password` varchar(100) NOT NULL
);

CREATE TABLE `participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha_nacimiento` date NOT NULL,
  `licencia` varchar(250) UNIQUE NOT NULL,
  `tipo_participante_id` bigint NOT NULL,
  `imagen_id` bigint,
  `usuario_id` bigint UNIQUE
);

CREATE TABLE `participante_documento` (
  `participante_id` bigint NOT NULL,
  `documento_id` bigint NOT NULL,
  PRIMARY KEY (`participante_id`, `documento_id`)
);

CREATE TABLE `tipo_participante` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(500)
);

CREATE TABLE `reserva` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `usuario_id` bigint NOT NULL
);

CREATE TABLE `material` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(500)
);

CREATE TABLE `pista` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` varchar(100),
  `direccion_id` bigint NOT NULL
);

CREATE TABLE `reserva_material` (
  `reserva_id` bigint NOT NULL,
  `material_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `material_id`)
);

CREATE TABLE `reserva_pista` (
  `reserva_id` bigint NOT NULL,
  `pista_id` bigint NOT NULL,
  PRIMARY KEY (`reserva_id`, `pista_id`)
);

CREATE TABLE `direccion` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `calle` varchar(100) NOT NULL,
  `numero` int,
  `cod_postal` int NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL
);

CREATE TABLE `documento` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) UNIQUE NOT NULL
);

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
