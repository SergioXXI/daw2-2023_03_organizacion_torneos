-- Borra el campo rol de la tabla usuario y la tabla rol
ALTER TABLE usuario DROP FOREIGN KEY usuario_ibfk_1;

ALTER TABLE usuario DROP COLUMN rol_id;

DROP TABLE IF EXISTS rol;