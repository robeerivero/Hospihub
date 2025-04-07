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

-- Insertar más pacientes PIN: {5678, 7890, 2345, 6789}
INSERT INTO Paciente (Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN) VALUES 
('Luis', 'Ramírez', 645678910, '1995-09-12', 1, 'luis.ramirez@mail.com', "$2y$10$TTEHVGLUepuj0lZzE5S28.30TdXRuDIvRgRSPRuV2QxmMNUDS58CG"),
('Marta', 'Sánchez', 655678911, '2000-12-05', 2, 'marta.sanchez@mail.com', "$2y$10$eP9UVL56/tpXZHIH5jvc7ezCjnwi0hOYpjI.sdOJ.knYcCbGUqZQ2"),
('Roberto', 'Díaz', 665678912, '1988-03-25', 3, 'roberto.diaz@mail.com', "$2y$10$jKhT7jcxdbIGzq7AKw5NP.TOv17hiPXDwy88/OAm2Fm5yta1NkKvi"),
('Elena', 'Torres', 675678913, '1993-06-17', 4, 'elena.torres@mail.com', "$2y$10$CY9BTAr3FGKNuUOus.FBYu6OMsO5oSW0quOhJojg2lMuOBrZMEg3.")
('admin', 'admin', 0, '0000-00-00', 4, 'admin@mail.com', "$2y$10$hCfnOOlCoNX1lO1gkDrGfu6OnCMYVWmik1KhvyAbxZEUdGdoWd4oC")

-- Insertar más médicos PIN: {4567, 5678, 6789, 7890}
INSERT INTO Medico (Id_departamento, Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN) VALUES 
(1, 'Carmen', 'Herrera', 695678915, '1970-08-21', 1, 'carmen.herrera@mail.com', "$2y$10$3Q45m/iiDDprF38l8fZAEOg2fdt483iaLrywBUYp1hyHYe5QNcEGm"),
(2, 'José', 'Navarro', 705678916, '1982-04-10', 2, 'jose.navarro@mail.com', "$2y$10$xkkf6Ayc/vlrxa0yi83xMuE2PqVxIiUM..GX6SULyVoGPOh1cw2mO"),
(3, 'Patricia', 'Ortega', 715678917, '1991-01-15', 3, 'patricia.ortega@mail.com', " $2y$10$IvfthNOLDWTVAfNZ9LzrAOGFe35ChWSjK.nRa0bBqDO2L3SWkNAsq"),
(4, 'Alejandro', 'Jiménez', 725678918, '1975-07-09', 4, 'alejandro.jimenez@mail.com', "$2y$10$WWghxpLpOxwEVCOGHJUTi.kT.PRoz1q5msK5zkm0R1JFr07zPr5Le");
