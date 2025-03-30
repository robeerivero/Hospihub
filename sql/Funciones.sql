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

    -- Insertar la dirección si no existe
    INSERT INTO Direccion (Ciudad, Calle) 
    SELECT ciudad, calle FROM DUAL
    WHERE NOT EXISTS (SELECT 1 FROM Direccion WHERE Ciudad = ciudad AND Calle = calle);
    
    SET @id_direccion = (SELECT Id_direccion FROM Direccion WHERE Ciudad = ciudad AND Calle = calle LIMIT 1);

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

    -- Insertar la dirección si no existe
    INSERT INTO Direccion (Ciudad, Calle) 
    SELECT ciudad, calle FROM DUAL
    WHERE NOT EXISTS (SELECT 1 FROM Direccion WHERE Ciudad = ciudad AND Calle = calle);
    
    SET @id_direccion = (SELECT Id_direccion FROM Direccion WHERE Ciudad = ciudad AND Calle = calle LIMIT 1);

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

    -- Insertar el departamento si no existe
    INSERT INTO Departamento (Id_hospital, Nombre, Ubicacion) 
    SELECT v_id_hospital, nombre, ubicacion FROM DUAL
    WHERE NOT EXISTS (SELECT 1 FROM Departamento WHERE Nombre = nombre AND Id_hospital = v_id_hospital);

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

    -- Insertar la dirección si no existe
    INSERT INTO Direccion (Ciudad, Calle) 
    SELECT ciudad, calle FROM DUAL
    WHERE NOT EXISTS (SELECT 1 FROM Direccion WHERE Ciudad = ciudad AND Calle = calle);
    
    SET @id_direccion = (SELECT Id_direccion FROM Direccion WHERE Ciudad = ciudad AND Calle = calle LIMIT 1);

    -- Insertar el hospital si no existe
    INSERT INTO Hospital (Nombre, Id_direccion) 
    SELECT nombre, @id_direccion FROM DUAL
    WHERE NOT EXISTS (SELECT 1 FROM Hospital WHERE Nombre = nombre);

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

DELIMITER ;



DELIMITER $$

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

    -- Eliminar citas asociadas al paciente
    DELETE FROM Cita WHERE Id_paciente = (SELECT Id_paciente FROM Paciente WHERE Email = email_paciente);
    
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

    -- Eliminar citas asociadas al médico
    DELETE FROM Cita WHERE Id_medico = (SELECT Id_medico FROM Medico WHERE Email = email_medico);
    
    -- Eliminar el médico
    DELETE FROM Medico WHERE Email = email_medico;

    COMMIT;
    SELECT 'Médico eliminado correctamente' AS Mensaje;
END$$

-- Procedimiento para eliminar un departamento
DELIMITER //

CREATE PROCEDURE Eliminar_Departamento(
    IN p_id_departamento INT
)
BEGIN
    DECLARE v_tiene_medicos INT DEFAULT 0;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error al eliminar el departamento' AS resultado;
    END;

    START TRANSACTION;

    -- Verificar si el departamento tiene médicos asignados
    SELECT COUNT(*) INTO v_tiene_medicos
    FROM Medico
    WHERE Id_departamento = p_id_departamento;
    
    IF v_tiene_medicos > 0 THEN
        SELECT 'No se puede eliminar el departamento porque tiene médicos asignados' AS resultado;
    ELSE
        -- Eliminar el departamento
        DELETE FROM Departamento 
        WHERE Id_departamento = p_id_departamento;
        
        SELECT 'Departamento eliminado correctamente' AS resultado;
    END IF;

    COMMIT;
END //

DELIMITER ;

-- Procedimiento para eliminar un hospital
CREATE PROCEDURE Eliminar_Hospital(
    IN nombre_hospital VARCHAR(50)
)
BEGIN
    DECLARE v_id_hospital INT;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el hospital';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;
    
    -- Eliminar departamentos asociados al hospital
    DELETE FROM Departamento WHERE Id_hospital = v_id_hospital;
    
    -- Eliminar el hospital
    DELETE FROM Hospital WHERE Id_hospital = v_id_hospital;

    COMMIT;
    SELECT 'Hospital eliminado correctamente' AS Mensaje;
END$$

-- Función para obtener el máximo ID de diagnóstico
CREATE FUNCTION Obtener_Max_Id_Diagnostico() RETURNS INT  
READS SQL DATA  
BEGIN  
    DECLARE max_id_diagnostico INT;  

    -- Obtener el máximo ID de diagnóstico (manejar nulos)  
    SELECT IFNULL(MAX(Id_diagnostico), 0) INTO max_id_diagnostico FROM Diagnostico;  

    RETURN max_id_diagnostico;  
END$$  

DELIMITER ;

DELIMITER //
CREATE PROCEDURE Crear_Citas()
BEGIN
    DECLARE v_fecha DATE;
    DECLARE v_hora DATETIME;
    DECLARE v_estado VARCHAR(50) DEFAULT 'Paciente sin asignar';
    DECLARE v_citas_existen INT;
    
    DECLARE done INT DEFAULT FALSE;
    DECLARE hospital_id INT;
    DECLARE dept_id INT;
    DECLARE medico_id INT;

    -- Cursores con nombres de tablas corregidos
    DECLARE cur_hospital CURSOR FOR SELECT Id_hospital FROM Hospital;
    DECLARE cur_dept CURSOR FOR SELECT Id_departamento FROM Departamento WHERE Id_hospital = hospital_id;
    DECLARE cur_medico CURSOR FOR SELECT Id_medico FROM Medico WHERE Id_departamento = dept_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET v_fecha = CURDATE();

    -- Verificar citas existentes con nombre de tabla corregido
    SELECT COUNT(*) INTO v_citas_existen FROM Cita WHERE Fecha = v_fecha;
    IF v_citas_existen > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existen citas para la fecha actual.';
    END IF;

    OPEN cur_hospital;
    hospital_loop: LOOP
        FETCH cur_hospital INTO hospital_id;
        IF done THEN LEAVE hospital_loop; END IF;

        OPEN cur_dept;
        dept_loop: LOOP
            FETCH cur_dept INTO dept_id;
            IF done THEN LEAVE dept_loop; END IF;

            OPEN cur_medico;
            medico_loop: LOOP
                FETCH cur_medico INTO medico_id;
                IF done THEN LEAVE medico_loop; END IF;

                SET v_hora = CONCAT(v_fecha, ' 08:00:00');

                WHILE HOUR(v_hora) < 14 DO
                    INSERT INTO Cita (  -- Nombre de tabla corregido
                        Id_medico, 
                        Fecha, 
                        Hora, 
                        Estado
                    ) VALUES (
                        medico_id, 
                        v_fecha, 
                        v_hora, 
                        v_estado
                    );

                    SET v_hora = ADDTIME(v_hora, '01:00:00');
                END WHILE;

            END LOOP;
            CLOSE cur_medico;
            SET done = FALSE;  -- Reset para próximo cursor
        END LOOP;
        CLOSE cur_dept;
        SET done = FALSE;  -- Reset para próximo cursor
    END LOOP;
    CLOSE cur_hospital;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE Asignar_Cita(
    IN id_paciente_param INT, 
    IN id_cita_param INT
)
BEGIN
    UPDATE Cita SET  -- Nombre de tabla corregido
        Id_paciente = id_paciente_param,
        Estado = 'Paciente Asignado'
    WHERE Id_cita = id_cita_param;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La cita especificada no existe o ya ha sido asignada.';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION Verificar_Credenciales_Medico(
    email_in VARCHAR(50), 
    pin_in INT  -- Cambiado a INT para coincidir con el tipo de la tabla
) RETURNS INT
READS SQL DATA
BEGIN
    DECLARE id_medico INT;

    SELECT Id_Medico INTO id_medico
    FROM Medico  -- Nombre de tabla corregido
    WHERE Email = email_in AND PIN = pin_in;

    RETURN COALESCE(id_medico, 0);
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION Verificar_Credenciales_Paciente(
    email_in VARCHAR(50), 
    pin_in INT  -- Cambiado a INT para coincidir con el tipo de la tabla
) RETURNS INT
READS SQL DATA
BEGIN
    DECLARE paciente_id INT;

    SELECT Id_paciente INTO paciente_id
    FROM Paciente  -- Nombre de tabla corregido
    WHERE Email = email_in AND PIN = pin_in;

    RETURN COALESCE(paciente_id, 0);
END //
DELIMITER ;


-- -------------------------------
-- OBTENER DEPARTAMENTOS HOSPITALES
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Departamentos_Hospitales_Cursor()
BEGIN
    SELECT 
        d.Id_departamento,
        d.Nombre AS Nombre_departamento,
        d.Ubicacion AS Ubicacion_departamento,
        h.Id_hospital,
        h.Nombre AS Nombre_hospital,
        dir.Ciudad AS Ciudad_hospital,  -- Desde Direccion
        dir.Calle AS Calle_hospital     -- Desde Direccion
    FROM 
        Departamento d
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital
        JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;  -- JOIN añadido
END //
DELIMITER ;

-- -------------------------------
-- OBTENER HOSPITALES
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Hospitales_Cursor()
BEGIN
    SELECT 
        h.Id_hospital,
        h.Nombre AS Nombre_hospital,
        dir.Ciudad AS Ciudad_hospital,  -- Desde Direccion
        dir.Calle AS Calle_hospital      -- Desde Direccion
    FROM 
        Hospital h
        JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;  -- JOIN añadido
END //
DELIMITER ;

-- -------------------------------
-- OBTENER MEDICOS
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Medicos_Cursor()
BEGIN
    SELECT 
        m.Id_medico,
        m.Nombre,
        m.Apellidos,
        m.Telefono,
        m.Fecha_nacimiento,
        dir.Ciudad,  -- Desde Direccion
        dir.Calle,   -- Desde Direccion
        m.Email,
        m.PIN,
        d.Id_departamento,
        d.Nombre AS Nombre_departamento,
        h.Id_hospital,
        h.Nombre AS Nombre_hospital
    FROM 
        Medico m
        JOIN Direccion dir ON m.Id_direccion = dir.Id_direccion  -- JOIN añadido
        JOIN Departamento d ON m.Id_departamento = d.Id_departamento
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital;
END //
DELIMITER ;

-- -------------------------------
-- OBTENER PACIENTES
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Pacientes_Cursor()
BEGIN
    SELECT 
        p.Id_paciente,
        p.Nombre,
        p.Apellidos,
        p.Telefono,
        p.Fecha_nacimiento,
        dir.Ciudad,  -- Desde Direccion
        dir.Calle,   -- Desde Direccion
        p.Email,
        p.PIN
    FROM 
        Paciente p
        JOIN Direccion dir ON p.Id_direccion = dir.Id_direccion;  -- JOIN añadido
END //
DELIMITER ;

-- -------------------------------
-- OBTENER CITAS
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Citas_Pendientes_Cursor(
    IN p_hospital VARCHAR(255),
    IN p_departamento VARCHAR(255),
    IN p_fecha DATE  -- Cambiado a tipo DATE
)
BEGIN
    SELECT 
        c.Id_Cita, 
        c.Fecha, 
        DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita,  -- Formato para TIMESTAMP
        c.Id_Medico, 
        m.Nombre AS Nombre_Medico
    FROM 
        Cita c
        JOIN Medico m ON c.Id_medico = m.Id_medico
        JOIN Departamento d ON m.Id_departamento = d.Id_departamento
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital
    WHERE 
        h.Nombre = p_hospital 
        AND d.Nombre = p_departamento 
        AND c.Estado = 'Paciente sin asignar'
        AND c.Fecha = p_fecha;  -- Usamos fecha directamente
END //
DELIMITER ;

-- -------------------------------
-- OBTENER CITAS
-- -------------------------------
DELIMITER //
CREATE PROCEDURE Obtener_Citas_Paciente(IN paciente_id INT)
BEGIN
    SELECT 
        c.Id_Cita,
        c.Fecha,
        TIME_FORMAT(c.Hora, '%H:%i:%s') AS Hora,
        m.Nombre AS Nombre_Medico,
        m.Apellidos AS Apellidos_Medico,
        d.Nombre AS Nombre_Departamento,
        h.Nombre AS Nombre_Hospital,
        c.Estado
    FROM 
        Cita c
        JOIN Medico m ON c.Id_medico = m.Id_medico
        JOIN Departamento d ON m.Id_departamento = d.Id_departamento
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital
    WHERE 
        c.Id_paciente = paciente_id
    ORDER BY 
        c.Fecha DESC, c.Hora DESC;
END //
DELIMITER ;

DELIMITER //

-- -------------------------------
-- Verificar si una cita pertenece a un paciente
-- -------------------------------

CREATE FUNCTION Verificar_Cita_Paciente(
    cita_id INT,
    paciente_id INT
) RETURNS BOOLEAN
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE existe BOOLEAN;
    
    SELECT COUNT(*) > 0 INTO existe
    FROM Cita
    WHERE Id_Cita = cita_id AND Id_paciente = paciente_id;
    
    RETURN existe;
END //

-- -------------------------------
-- Cancelar una cita
-- -------------------------------

CREATE PROCEDURE Cancelar_Cita(
    IN cita_id INT,
    IN paciente_id INT,
    OUT resultado VARCHAR(100)
)
BEGIN
    DECLARE cita_valida BOOLEAN;
    
    -- Verificar si la cita pertenece al paciente
    SET cita_valida = Verificar_Cita_Paciente(cita_id, paciente_id);
    
    IF NOT cita_valida THEN
        SET resultado = 'La cita no existe o no pertenece a este paciente';
    ELSE
        -- Actualizar el estado de la cita
        UPDATE Cita 
        SET Id_paciente = NULL, 
            Estado = 'Paciente sin asignar' 
        WHERE Id_Cita = cita_id;
        
        IF ROW_COUNT() > 0 THEN
            SET resultado = 'Cita cancelada correctamente';
        ELSE
            SET resultado = 'Error al cancelar la cita';
        END IF;
    END IF;
END //

DELIMITER ;