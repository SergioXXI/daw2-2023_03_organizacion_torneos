INSERT INTO `auth_item` (`name`, `type`, `description`) VALUES 
('sysadmin', 1, 'Tiene acceso a absolutamente todo'),
('admin', 1, 'Administrador del sistema'),
('organizador', 1, 'Usuario registrado que organiza torneos'),
('gestor', 1, 'Usuario registrado que gestiona equipos'),
('usuario', 1, 'Usuario registrado que participa en torneos');

INSERT INTO `auth_assignment` (`item_name`, `user_id`) VALUES 
('sysadmin', 1),
('admin', 2),
('organizador', 3),
('gestor', 4),
('usuario', 5),
('usuario', 6),
('usuario', 7),
('usuario', 8);
