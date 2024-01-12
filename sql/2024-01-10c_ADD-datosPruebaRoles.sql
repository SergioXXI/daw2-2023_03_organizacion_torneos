INSERT INTO `auth_item` (`name`, `type`, `description`) VALUES 
('sysadmin', 1, 'Tiene acceso a absolutamente todo'),
('admin', 1, 'Administrador del sistema'),
('organizador', 1, 'Usuario registrado que organiza torneos'),
('gestor', 1, 'Usuario registrado que gestiona equipos'),
('participante', 1, 'Usuario registrado que participa en torneos');

INSERT INTO `auth_assignment` (`item_name`, `user_id`) VALUES 
('sysadmin', 1),
('admin', 2),
('organizador', 3),
('gestor', 4),
('participante', 5);

INSERT INTO auth_item_child(parent,child) 
VALUES
    ('sysadmin','admin'),
    ('sysadmin','organizador'),
    ('sysadmin', 'gestor'),
    ('sysadmin', 'usuario'),
    ('admin', 'organizador'),
    ('admin', 'gestor'),
    ('admin', 'usuario');
