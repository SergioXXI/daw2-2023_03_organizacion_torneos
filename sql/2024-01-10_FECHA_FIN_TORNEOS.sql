-- añade fecha fin a la tabla torneos
UPDATE `participante` SET `usuario_id` = '1' WHERE `participante`.`id` = 1;
UPDATE `participante` SET `usuario_id` = '2' WHERE `participante`.`id` = 2;
UPDATE `participante` SET `usuario_id` = '3' WHERE `participante`.`id` = 3;

ALTER TABLE participante
MODIFY COLUMN usuario_id bigint(20) NOT NULL;