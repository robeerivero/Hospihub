-- Insertar direcciones adicionales
INSERT INTO Direccion (Ciudad, Calle) VALUES 
('Sevilla', 'Calle Sierpes 12'),
('Bilbao', 'Gran Vía 45'),
('Zaragoza', 'Paseo Independencia 33'),
('Málaga', 'Avenida de Andalucía 20');

-- Insertar hospitales adicionales
INSERT INTO Hospital (Nombre, Id_direccion) VALUES 
('Hospital de Sevilla', 1),
('Hospital de Bilbao', 2),
('Hospital de Zaragoza', 3),
('Hospital de Málaga', 4);

-- Insertar más departamentos
INSERT INTO Departamento (Id_hospital, Nombre, Ubicacion) VALUES 
(1, 'Neurología', 'Piso 1'),
(2, 'Oncología', 'Piso 2'),
(3, 'Dermatología', 'Piso 3'),
(4, 'Ginecología', 'Piso 4');

-- Insertar más pacientes
INSERT INTO Paciente (Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN) VALUES 
('Luis', 'Ramírez', 645678910, '1995-09-12', 1, 'luis.ramirez@mail.com', 5678),
('Marta', 'Sánchez', 655678911, '2000-12-05', 2, 'marta.sanchez@mail.com', 7890),
('Roberto', 'Díaz', 665678912, '1988-03-25', 3, 'roberto.diaz@mail.com', 2345),
('Elena', 'Torres', 675678913, '1993-06-17', 4, 'elena.torres@mail.com', 6789);

-- Insertar más médicos
INSERT INTO Medico (Id_departamento, Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN) VALUES 
(1, 'Carmen', 'Herrera', 695678915, '1970-08-21', 1, 'carmen.herrera@mail.com', 4567),
(2, 'José', 'Navarro', 705678916, '1982-04-10', 2, 'jose.navarro@mail.com', 5678),
(3, 'Patricia', 'Ortega', 715678917, '1991-01-15', 3, 'patricia.ortega@mail.com', 6789),
(4, 'Alejandro', 'Jiménez', 725678918, '1975-07-09', 4, 'alejandro.jimenez@mail.com', 7890);
