CALL Insertar_Hospital('Hospital Universitario Puerta del Mar', 'Cadiz', 'Av. Ana de Viya, 21');
CALL Insertar_Hospital('Hospital Universitario Puerto Real', 'Puerto Real', 'Calle Romería, 7');
CALL Insertar_Hospital('Carlos III', 'San Fernando', 'C. de Sinesio Delgado, 10');

CALL Insertar_Departamento('Hospital Universitario Puerta del Mar', 'Cardiologia', 'Piso 4');
CALL Insertar_Departamento('Hospital Universitario Puerto Real', 'Cardiologia', 'Piso 4');
CALL Insertar_Departamento('Carlos III', 'Cardiologia', 'Piso 5');

CALL Insertar_Departamento('Hospital Universitario Puerta del Mar', 'Dermatologia', 'Piso 2');
CALL Insertar_Departamento('Hospital Universitario Puerto Real', 'Dermatologia', 'Piso 5');
CALL Insertar_Departamento('Carlos III', 'Dermatologia', 'Piso 3');

CALL Insertar_Departamento('Hospital Universitario Puerta del Mar', 'Anatomia', 'Piso 2');
CALL Insertar_Departamento('Hospital Universitario Puerto Real', 'Anatomia', 'Piso 5');


CALL Insertar_Paciente('Pablo', 'Cortes Lora', 678625565, STR_TO_DATE('2002-08-20', '%Y-%m-%d'), 'San Fernando', 'C. Albina, 31', 'pablocorteslora@alum.uca.es', 12345678);
CALL Insertar_Paciente('Carlos', 'Cortes Lora', 644326265, STR_TO_DATE('2001-05-10', '%Y-%m-%d'), 'San Fernando', 'C. Albina, 31', 'carlosantoniocorteslora@alum.uca.es', 12345);
CALL Insertar_Paciente('Roberto', 'Rivero Diaz', 644326265, STR_TO_DATE('2002-04-12', '%Y-%m-%d'), 'Cadiz', 'C. Obrdor, 5', 'robertoriverodiaz@alum.uca.es', 12345);
CALL Insertar_Paciente('Lucas', 'Gomez Coello', 642346263, STR_TO_DATE('2002-03-08', '%Y-%m-%d'), 'Jerez', 'C. General, 21', 'lucasgomezcoello@alum.uca.es', 12345);


CALL Insertar_Medico('Hospital Universitario Puerta del Mar', 'Cardiologia', 'Pedro', 'Lopez Rueda', 987654321, STR_TO_DATE('1985-03-20', '%Y-%m-%d'), 'Jerez', 'Calle Rojo, 5', 'pedro@example.com', 5678);
CALL Insertar_Medico('Hospital Universitario Puerta del Mar', 'Dermatologia', 'Maria', 'Dominguez Rivera', 987665321, STR_TO_DATE('1986-04-21', '%Y-%m-%d'), 'San Fernando', 'Calle Amapola, 10', 'maria@example.com', 5867);
CALL Insertar_Medico('Hospital Universitario Puerta del Mar', 'Anatomia', 'Idelfonsio', 'Hernandez Gomez', 687645321, STR_TO_DATE('1986-04-21', '%Y-%m-%d'), 'San Fernando', 'Calle Girasol, 7', 'idelfonsio@example.com', 5867);

CALL Insertar_Medico('Hospital Universitario Puerto Real', 'Cardiologia', 'Carlos', 'Lopez Rueda', 987654321, STR_TO_DATE('1985-03-20', '%Y-%m-%d'), 'Jerez', 'Calle Azul, 4', 'carlos@example.com', 5678);
CALL Insertar_Medico('Hospital Universitario Puerto Real', 'Dermatologia', 'Dani', 'Dominguez Rivera', 987665321, STR_TO_DATE('1986-04-21', '%Y-%m-%d'), 'San Fernando', 'Calle Clavel, 9', 'dani@example.com', 5867);
CALL Insertar_Medico('Hospital Universitario Puerto Real', 'Anatomia', 'Ivan', 'Hernandez Gomez', 687645321, STR_TO_DATE('1986-04-21', '%Y-%m-%d'), 'San Fernando', 'Calle Alemania, 8', 'ivan@example.com', 5867);

CALL Insertar_Medico('Carlos III', 'Cardiologia', 'Alejandro', 'Lopez Rueda', 987654321, STR_TO_DATE('1985-03-20', '%Y-%m-%d'), 'Jerez', 'Calle Amarillo, 2', 'alejandro@example.com', 5678);
CALL Insertar_Medico('Carlos III', 'Dermatologia', 'Daniela', 'Dominguez Rivera', 987665321, STR_TO_DATE('1986-04-21', '%Y-%m-%d'), 'San Fernando', 'Calle Avenida Verde, 3', 'daniela@example.com', 5867);
