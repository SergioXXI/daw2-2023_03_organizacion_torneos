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

-- Insertar datos de prueba para la tabla 'clase'
INSERT INTO clase (titulo, descripcion, imagen_id) VALUES
    ('Campeonato Nacional', 'Torneo de alto nivel nacional', 1),
    ('Torneo Local', 'Competición a nivel local', 2),
    ('Copa Internacional', 'Torneo con equipos de diferentes países', 3);

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

-- Insertar datos de prueba para la tabla 'equipo'
INSERT INTO equipo (nombre, descripcion, licencia, categoria_id) VALUES
    ('Equipo A', 'Descripción del Equipo A', 'ABC123', 1),
    ('Equipo B', 'Descripción del Equipo B', 'XYZ789', 2),
    ('Equipo C', 'Descripción del Equipo C', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'equipo_participante'
INSERT INTO equipo_participante (equipo_id, participante_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'usuario'
INSERT INTO usuario (nombre, apellido1, apellido2, email, rol, password) VALUES
    ('Juan', 'Pérez', 'Gómez', 'juan@example.com', 'Admin', 'password123'),
    ('María', 'García', 'López', 'maria@example.com', 'Usuario', 'securepass');

-- Insertar datos de prueba para la tabla 'participante'
INSERT INTO participante (fecha_nacimiento, licencia, tipo_participante_id) VALUES
    ('1990-05-15', 'ABC123', 1),
    ('1985-12-10', 'XYZ789', 2),
    ('1995-08-22', 'DEF456', 3);

-- Insertar datos de prueba para la tabla 'participante_documento'
INSERT INTO participante_documento (participante_id, documento_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

-- Insertar datos de prueba para la tabla 'tipo_participante'
INSERT INTO tipo_participante (nombre, descripcion) VALUES
    ('Jugador', 'Participante que juega en equipos'),
    ('Árbitro', 'Oficial encargado de hacer cumplir las reglas'),
    ('Entrenador', 'Persona a cargo del entrenamiento del equipo');

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

-- Insertar datos de prueba para la tabla 'direccion'
INSERT INTO direccion (calle, numero, cod_postal, ciudad, provincia, pais) VALUES
    ('Calle Principal', 123, 12345, 'Ciudad A', 'Provincia X', 'País Y'),
    ('Avenida Secundaria', 456, 54321, 'Ciudad B', 'Provincia Z', 'País W');

-- Insertar datos de prueba para la tabla 'documento'
INSERT INTO documento (ruta) VALUES
    ('/documentos/doc1.pdf'),
    ('/documentos/doc2.pdf'),
    ('/documentos/doc3.pdf');

-- Insertar datos de prueba para la tabla 'imagen'
INSERT INTO imagen (ruta) VALUES
    ('/imagenes/img1.jpg'),
    ('/imagenes/img2.jpg'),
    ('/imagenes/img3.jpg');
