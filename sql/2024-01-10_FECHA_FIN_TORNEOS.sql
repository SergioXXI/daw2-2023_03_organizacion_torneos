-- añade fecha fin a la tabla torneos
ALTER TABLE torneo
ADD COLUMN fecha_fin TIMESTAMP NULL;

UPDATE `torneo` SET `fecha_fin` = '2024-01-09 13:08:54' WHERE `torneo`.`id` = 1;
