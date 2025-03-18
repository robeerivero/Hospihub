DELIMITER $$


-- Procedimiento para insertar un paciente
CREATE PROCEDURE Insertar_Paciente(
    IN nombre VARCHAR(50),
    IN apellidos VARCHAR(50),
    IN telefono INT,
    IN fecha_nacimiento DATE,
    IN ciudad VARCHAR(50),
    IN calle VARCHAR(50),
    IN email VARCHAR(50),
    IN pin INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el paciente';
    END;

    START TRANSACTION;

    -- Insertar la dirección
    INSERT INTO Direccion (Ciudad, Calle) VALUES (ciudad, calle);
    SET @id_direccion = LAST_INSERT_ID();

    -- Insertar el paciente
    INSERT INTO Paciente (Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN)
    VALUES (nombre, apellidos, telefono, fecha_nacimiento, @id_direccion, email, pin);

    COMMIT;
    SELECT 'Paciente insertado correctamente' AS Mensaje;
END$$

-- Procedimiento para insertar un médico
CREATE PROCEDURE Insertar_Medico(
    IN nombre_hospital VARCHAR(50),
    IN nombre_departamento VARCHAR(50),
    IN nombre VARCHAR(50),
    IN apellidos VARCHAR(50),
    IN telefono INT,
    IN fecha_nacimiento DATE,
    IN ciudad VARCHAR(50),
    IN calle VARCHAR(50),
    IN email VARCHAR(50),
    IN pin INT
)
BEGIN
    DECLARE v_id_hospital INT;
    DECLARE v_id_departamento INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el médico';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;

    -- Obtener el ID del departamento
    SELECT Id_departamento INTO v_id_departamento FROM Departamento WHERE Nombre = nombre_departamento AND Id_hospital = v_id_hospital;

    -- Insertar la dirección
    INSERT INTO Direccion (Ciudad, Calle) VALUES (ciudad, calle);
    SET @id_direccion = LAST_INSERT_ID();

    -- Insertar el médico
    INSERT INTO Medico (Id_departamento, Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN)
    VALUES (v_id_departamento, nombre, apellidos, telefono, fecha_nacimiento, @id_direccion, email, pin);

    COMMIT;
    SELECT 'Médico insertado correctamente' AS Mensaje;
END$$

-- Procedimiento para insertar un departamento
CREATE PROCEDURE Insertar_Departamento(
    IN nombre_hospital VARCHAR(50),
    IN nombre VARCHAR(50),
    IN ubicacion VARCHAR(50)
)
BEGIN
    DECLARE v_id_hospital INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el departamento';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;

    -- Insertar el departamento
    INSERT INTO Departamento (Id_hospital, Nombre, Ubicacion) VALUES (v_id_hospital, nombre, ubicacion);

    COMMIT;
    SELECT 'Departamento insertado correctamente' AS Mensaje;
END$$

-- Procedimiento para insertar un hospital
CREATE PROCEDURE Insertar_Hospital(
    IN nombre VARCHAR(50),
    IN ciudad VARCHAR(50),
    IN calle VARCHAR(50)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el hospital';
    END;

    START TRANSACTION;

    -- Insertar la dirección
    INSERT INTO Direccion (Ciudad, Calle) VALUES (ciudad, calle);
    SET @id_direccion = LAST_INSERT_ID();

    -- Insertar el hospital
    INSERT INTO Hospital (Nombre, Id_direccion) VALUES (nombre, @id_direccion);

    COMMIT;
    SELECT 'Hospital insertado correctamente' AS Mensaje;
END$$

-- Procedimiento para insertar un diagnóstico
CREATE PROCEDURE Insertar_Diagnostico(
    IN cita_id INT,
    IN descripcion VARCHAR(100),
    IN recomendacion VARCHAR(100)
)
BEGIN
    DECLARE v_diagnostico_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el diagnóstico';
    END;

    START TRANSACTION;

    -- Insertar el diagnóstico
    INSERT INTO Diagnostico (Descripcion, Recomendacion) VALUES (descripcion, recomendacion);
    SET v_diagnostico_id = LAST_INSERT_ID();

    -- Actualizar la cita con el ID del diagnóstico
    UPDATE Cita SET Id_diagnostico = v_diagnostico_id, Estado = 'Diagnostico Completo' WHERE Id_cita = cita_id;

    COMMIT;
    SELECT 'Diagnóstico insertado correctamente' AS Mensaje;
END$$

-- Procedimiento para insertar un medicamento
CREATE PROCEDURE Insertar_Medicamento(
    IN id_diagnostico INT,
    IN nombre_medicamento VARCHAR(50),
    IN frecuencia VARCHAR(100)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el medicamento';
    END;

    START TRANSACTION;

    -- Insertar el medicamento
    INSERT INTO Medicamento (Id_diagnostico, Nombre, Frecuencia) VALUES (id_diagnostico, nombre_medicamento, frecuencia);

    COMMIT;
    SELECT 'Medicamento insertado correctamente' AS Mensaje;
END$$


-- Procedimiento para eliminar un paciente
CREATE PROCEDURE Eliminar_Paciente(
    IN email_paciente VARCHAR(50)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el paciente';
    END;

    START TRANSACTION;

    -- Eliminar el paciente
    DELETE FROM Paciente WHERE Email = email_paciente;

    COMMIT;
    SELECT 'Paciente eliminado correctamente' AS Mensaje;
END$$

-- Procedimiento para eliminar un médico
CREATE PROCEDURE Eliminar_Medico(
    IN email_medico VARCHAR(50)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el médico';
    END;

    START TRANSACTION;

    -- Eliminar el médico
    DELETE FROM Medico WHERE Email = email_medico;

    COMMIT;
    SELECT 'Médico eliminado correctamente' AS Mensaje;
END$$

-- Procedimiento para eliminar un departamento
CREATE PROCEDURE Eliminar_Departamento(
    IN nombre_departamento VARCHAR(50),
    IN nombre_hospital VARCHAR(50)
)
BEGIN
    DECLARE v_id_hospital INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el departamento';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;

    -- Eliminar el departamento
    DELETE FROM Departamento WHERE Nombre = nombre_departamento AND Id_hospital = v_id_hospital;

    COMMIT;
    SELECT 'Departamento eliminado correctamente' AS Mensaje;
END$$

-- Procedimiento para eliminar un hospital
CREATE PROCEDURE Eliminar_Hospital(
    IN nombre_hospital VARCHAR(50)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el hospital';
    END;

    START TRANSACTION;

    -- Eliminar el hospital
    DELETE FROM Hospital WHERE Nombre = nombre_hospital;

    COMMIT;
    SELECT 'Hospital eliminado correctamente' AS Mensaje;
END$$


CREATE FUNCTION Obtener_Max_Id_Diagnostico() RETURNS INT  
READS SQL DATA  -- 📌 Indica que la función solo lee datos  
BEGIN  
    DECLARE max_id_diagnostico INT;  

    -- Obtener el máximo ID de diagnóstico (manejar nulos)  
    SELECT IFNULL(MAX(Id_diagnostico), 0) INTO max_id_diagnostico FROM Diagnostico;  

    RETURN max_id_diagnostico;  
END$$  

CREATE FUNCTION Verificar_Credenciales_Paciente(email_in VARCHAR(50), pin_in INT) RETURNS INT  
READS SQL DATA  
BEGIN  
    DECLARE paciente_id INT;  

    -- Verificar credenciales (manejar nulos)  
    SELECT Id_paciente INTO paciente_id FROM Paciente WHERE Email = email_in AND PIN = pin_in;  

    RETURN IFNULL(paciente_id, 0);  
END$$  


CREATE PROCEDURE Crear_Citas()
BEGIN
    -- Declaración de variables al inicio
    DECLARE v_fecha DATE;
    DECLARE v_hora DATETIME;
    DECLARE v_estado VARCHAR(50) DEFAULT 'Paciente sin asignar';
    DECLARE v_citas_existen INT;
    
    -- Variables para cursores
    DECLARE done INT DEFAULT FALSE;
    DECLARE hospital_id INT;
    DECLARE dept_done INT DEFAULT FALSE;
    DECLARE dept_id INT;
    DECLARE medico_done INT DEFAULT FALSE;
    DECLARE medico_id INT;

    -- Declarar cursores
    DECLARE cur_hospital CURSOR FOR SELECT Id_hospital FROM Tabla_Hospital;
    DECLARE cur_dept CURSOR FOR SELECT Id_departamento FROM Tabla_Departamento WHERE Id_hospital = hospital_id;
    DECLARE cur_medico CURSOR FOR SELECT Id_medico FROM Tabla_Medico WHERE Id_departamento = dept_id;

    -- Unificar manejo de excepciones para todos los cursores
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE, dept_done = TRUE, medico_done = TRUE;

    -- Obtener la fecha actual
    SET v_fecha = CURDATE();

    -- Verificar si ya existen citas para la fecha actual
    SELECT COUNT(*) INTO v_citas_existen FROM Tabla_Cita WHERE Fecha = v_fecha;
    IF v_citas_existen > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existen citas para la fecha actual.';
    END IF;

    -- Abrir el cursor de hospitales
    OPEN cur_hospital;
    read_hospital: LOOP
        FETCH cur_hospital INTO hospital_id;
        IF done THEN LEAVE read_hospital; END IF;

        -- Abrir el cursor de departamentos
        OPEN cur_dept;
        read_dept: LOOP
            FETCH cur_dept INTO dept_id;
            IF dept_done THEN LEAVE read_dept; END IF;

            -- Abrir el cursor de médicos
            OPEN cur_medico;
            read_medico: LOOP
                FETCH cur_medico INTO medico_id;
                IF medico_done THEN LEAVE read_medico; END IF;

                -- Iniciar la hora de las citas
                SET v_hora = CONCAT(v_fecha, ' 08:00:00');

                -- Crear citas hasta las 14:00
                WHILE HOUR(v_hora) < 14 DO
                    INSERT INTO Tabla_Cita (Id_medico, Id_paciente, Id_diagnostico, Fecha, Hora, Estado)
                    VALUES (medico_id, NULL, NULL, v_fecha, v_hora, v_estado);

                    -- Incrementar la hora en 1 hora
                    SET v_hora = v_hora + INTERVAL 1 HOUR;
                END WHILE;

            END LOOP;
            CLOSE cur_medico;
        END LOOP;
        CLOSE cur_dept;
    END LOOP;
    CLOSE cur_hospital;

    COMMIT;
END$$


   DECLARE v_estado VARCHAR(50) DEFAULT 'Paciente sin asignar';
    DECLARE v_citas_existen INT;
    
    -- Variables para cursores
    DECLARE done INT DEFAULT FALSE;
    DECLARE hospital_id INT;
    DECLARE dept_done INT DEFAULT FALSE;
    DECLARE dept_id INT;
    DECLARE medico_done INT DEFAULT FALSE;
    DECLARE medico_id INT;

    -- Declarar cursores
    DECLARE cur_hospital CURSOR FOR SELECT Id_hospital FROM Tabla_Hospital;
    DECLARE cur_dept CURSOR FOR SELECT Id_departamento FROM Tabla_Departamento WHERE Id_hospital = hospital_id;
    DECLARE cur_medico CURSOR FOR SELECT Id_medico FROM Tabla_Medico WHERE Id_departamento = dept_id;

    -- Manejo de excepciones
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET dept_done = TRUE;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET medico_done = TRUE;

    -- Obtener la fecha actual
    SET v_fecha = CURDATE();

    -- Verificar si ya existen citas para la fecha actual
    SELECT COUNT(*) INTO v_citas_existen FROM Tabla_Cita WHERE Fecha = v_fecha;
    IF v_citas_existen > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existen citas para la fecha actual.';
    END IF;

    -- Abrir el cursor de hospitales
    OPEN cur_hospital;
    read_hospital: LOOP
        FETCH cur_hospital INTO hospital_id;
        IF done THEN LEAVE read_hospital; END IF;

        -- Abrir el cursor de departamentos
        OPEN cur_dept;
        read_dept: LOOP
            FETCH cur_dept INTO dept_id;
            IF dept_done THEN LEAVE read_dept; END IF;

            -- Abrir el cursor de médicos
            OPEN cur_medico;
            read_medico: LOOP
                FETCH cur_medico INTO medico_id;
                IF medico_done THEN LEAVE read_medico; END IF;

                -- Iniciar la hora de las citas
                SET v_hora = CONCAT(v_fecha, ' 08:00:00');

                -- Crear citas hasta las 14:00
                WHILE HOUR(v_hora) < 14 DO
                    INSERT INTO Tabla_Cita (Id_medico, Id_paciente, Id_diagnostico, Fecha, Hora, Estado)
                    VALUES (medico_id, NULL, NULL, v_fecha, v_hora, v_estado);

                    -- Incrementar la hora en 1 hora
                    SET v_hora = v_hora + INTERVAL 1 HOUR;
                END WHILE;

            END LOOP;
            CLOSE cur_medico;
        END LOOP;
        CLOSE cur_dept;
    END LOOP;
    CLOSE cur_hospital;

    COMMIT;
END$$

CREATE PROCEDURE Asignar_Cita(IN id_paciente_param INT, IN id_cita_param INT)
BEGIN
    -- Actualizar el ID del paciente y el estado de la cita
    UPDATE Tabla_Cita
    SET Id_paciente = id_paciente_param,
        Estado = 'Paciente Asignado'
    WHERE Id_cita = id_cita_param;

    -- Verificar si se realizó la actualización
    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La cita especificada no existe o ya ha sido asignada.';
    END IF;
END$$
CREATE FUNCTION Verificar_Credenciales_Paciente(email_in VARCHAR(50), pin_in VARCHAR(50)) 
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE paciente_id INT;

    -- Buscar paciente por email y PIN
    SELECT Id_paciente INTO paciente_id
    FROM Tabla_Paciente
    WHERE Email = email_in AND PIN = pin_in;

    RETURN COALESCE(paciente_id, 0);
END$$
CREATE FUNCTION Verificar_Credenciales_Medico(email_in VARCHAR(50), pin_in VARCHAR(50)) 
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE id_medico INT;

    -- Buscar médico por email y PIN
    SELECT Id_Medico INTO id_medico
    FROM Tabla_Medico
    WHERE Email = email_in AND PIN = pin_in;

    RETURN COALESCE(id_medico, 0);
END$$

DELIMITER ;
