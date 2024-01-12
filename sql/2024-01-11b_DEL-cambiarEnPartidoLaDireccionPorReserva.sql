-- Eliminar direccion_id de partido y agregar reserva_id
ALTER TABLE `partido` DROP FOREIGN KEY `partido_ibfk_2`;

ALTER TABLE `partido` DROP COLUMN `direccion_id`;

ALTER TABLE `partido` ADD `reserva_id` BIGINT;

ALTER TABLE `partido` ADD CONSTRAINT `partido_ibfk_2` FOREIGN KEY (`reserva_id`) REFERENCES `reserva`(`id`);