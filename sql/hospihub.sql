-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 09:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospihub`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Asignar_Cita` (IN `id_paciente_param` INT, IN `id_cita_param` INT)   BEGIN
    UPDATE Cita SET  -- Nombre de tabla corregido
        Id_paciente = id_paciente_param,
        Estado = 'Paciente Asignado'
    WHERE Id_cita = id_cita_param;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La cita especificada no existe o ya ha sido asignada.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Cancelar_Cita` (IN `cita_id` INT, IN `paciente_id` INT, OUT `resultado` VARCHAR(100))   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Crear_Citas` ()   BEGIN
    DECLARE v_fecha_inicio DATE;
    DECLARE v_fecha_fin DATE;
    DECLARE v_fecha_actual DATE;
    DECLARE v_hora TIME;
    DECLARE v_estado VARCHAR(50) DEFAULT 'Paciente sin asignar';
    DECLARE v_citas_existen INT;
    
    DECLARE done INT DEFAULT FALSE;
    DECLARE hospital_id INT;
    DECLARE dept_id INT;
    DECLARE medico_id INT;

    -- Cursores para hospitales, departamentos y médicos
    DECLARE cur_hospital CURSOR FOR SELECT Id_hospital FROM Hospital;
    DECLARE cur_dept CURSOR FOR SELECT Id_departamento FROM Departamento WHERE Id_hospital = hospital_id;
    DECLARE cur_medico CURSOR FOR SELECT Id_medico FROM Medico WHERE Id_departamento = dept_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Configurar rango de fechas (1 año desde hoy)
    SET v_fecha_inicio = CURDATE();
    SET v_fecha_fin = DATE_ADD(v_fecha_inicio, INTERVAL 1 YEAR);
    SET v_fecha_actual = v_fecha_inicio;

    -- Crear citas para cada día del año
    WHILE v_fecha_actual <= v_fecha_fin DO
        -- Solo días laborables (de lunes a viernes)
        IF DAYOFWEEK(v_fecha_actual) BETWEEN 2 AND 6 THEN
            -- Verificar si ya existen citas para esta fecha
            SELECT COUNT(*) INTO v_citas_existen FROM Cita WHERE Fecha = v_fecha_actual;
            
            IF v_citas_existen = 0 THEN
                -- Reiniciar cursores para cada fecha
                SET done = FALSE;
                
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

                            -- Crear citas cada hora desde las 8:00 hasta las 13:00
                            SET v_hora = TIME('08:00:00');
                            
                            WHILE v_hora <= TIME('13:00:00') DO
                                INSERT INTO Cita (
                                    Id_medico, 
                                    Fecha, 
                                    Hora, 
                                    Estado
                                ) VALUES (
                                    medico_id, 
                                    v_fecha_actual, 
                                    CONCAT(v_fecha_actual, ' ', v_hora), 
                                    v_estado
                                );

                                SET v_hora = ADDTIME(v_hora, '01:00:00');
                            END WHILE;

                        END LOOP;
                        CLOSE cur_medico;
                        SET done = FALSE;
                    END LOOP;
                    CLOSE cur_dept;
                    SET done = FALSE;
                END LOOP;
                CLOSE cur_hospital;
            END IF;
        END IF;
        
        SET v_fecha_actual = DATE_ADD(v_fecha_actual, INTERVAL 1 DAY);
    END WHILE;
    
    SELECT CONCAT('Citas creadas desde ', v_fecha_inicio, ' hasta ', v_fecha_fin) AS Resultado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Editar_Departamento` (IN `p_id_departamento` INT, IN `p_nombre_hospital` VARCHAR(255), IN `p_nombre_departamento` VARCHAR(255), IN `p_ubicacion` VARCHAR(255))   BEGIN
    DECLARE v_id_hospital INT;

    -- Verificar si el hospital existe en la base de datos
    SELECT Id_hospital INTO v_id_hospital
    FROM Hospital
    WHERE Nombre = p_nombre_hospital
    LIMIT 1;

    -- Si el hospital no existe, lanzar un error
    IF v_id_hospital IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hospital no encontrado';
    END IF;

    -- Actualizar los datos del departamento si el hospital existe
    UPDATE Departamento
    SET
        nombre = p_nombre_departamento,  -- Asegúrate de que 'nombre' sea el nombre correcto de la columna en tu tabla
        ubicacion = p_ubicacion,         -- Asegúrate de que 'ubicacion' sea el nombre correcto de la columna en tu tabla
        Id_hospital = v_id_hospital
    WHERE Id_departamento = p_id_departamento;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Editar_Hospital` (IN `p_Id_hospital` INT, IN `p_Nombre` VARCHAR(255), IN `p_Ciudad` VARCHAR(255), IN `p_Calle` VARCHAR(255))   BEGIN
    DECLARE v_Id_direccion INT;
    
    -- Verificar si la dirección ya existe
    SELECT Id_direccion INTO v_Id_direccion 
    FROM direccion 
    WHERE Ciudad = p_Ciudad AND Calle = p_Calle
    LIMIT 1;
    
    -- Si no existe, insertar nueva dirección
    IF v_Id_direccion IS NULL THEN
        INSERT INTO direccion (Ciudad, Calle) VALUES (p_Ciudad, p_Calle);
        SET v_Id_direccion = LAST_INSERT_ID();
    END IF;
    
    -- Actualizar el hospital con el nuevo nombre y la dirección
    UPDATE hospital 
    SET Nombre = p_Nombre, Id_direccion = v_Id_direccion
    WHERE Id_hospital = p_Id_hospital;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Editar_Medico` (IN `id_medico_param` INT, IN `nombre_param` VARCHAR(100), IN `apellidos_param` VARCHAR(100), IN `telefono_param` VARCHAR(20), IN `fecha_nacimiento_param` DATE, IN `ciudad_param` VARCHAR(100), IN `calle_param` VARCHAR(100), IN `email_param` VARCHAR(255), IN `pin_param` VARCHAR(255), IN `departamento_param` VARCHAR(100), IN `hospital_param` VARCHAR(100))   BEGIN
    DECLARE id_direccion_existente INT;
    DECLARE id_departamento_existente INT;
    DECLARE id_hospital_existente INT;

    -- Verificar si la dirección ya existe
    SELECT Id_direccion INTO id_direccion_existente
    FROM Direccion
    WHERE Ciudad = ciudad_param AND Calle = calle_param
    LIMIT 1;

    -- Si no existe, insertamos una nueva dirección
    IF id_direccion_existente IS NULL THEN
        INSERT INTO Direccion (Ciudad, Calle)
        VALUES (ciudad_param, calle_param);
        
        -- Obtener el ID de la nueva dirección
        SET id_direccion_existente = LAST_INSERT_ID();
    END IF;

    -- Verificar si el hospital existe
    SELECT Id_hospital INTO id_hospital_existente
    FROM Hospital
    WHERE Nombre = hospital_param
    LIMIT 1;

    IF id_hospital_existente IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El hospital no existe.';
    END IF;

    -- Verificar si el departamento existe y pertenece al hospital correspondiente
    SELECT Id_departamento INTO id_departamento_existente
    FROM Departamento
    WHERE Nombre = departamento_param AND Id_hospital = id_hospital_existente
    LIMIT 1;

    IF id_departamento_existente IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El departamento no existe o no corresponde al hospital especificado.';
    END IF;

    -- Actualizar los datos del médico con la dirección correcta y el departamento correspondiente
    UPDATE Medico 
    SET 
        Nombre = nombre_param,
        Apellidos = apellidos_param,
        Telefono = telefono_param,
        Fecha_nacimiento = fecha_nacimiento_param,
        Id_direccion = id_direccion_existente,
        Email = email_param,
        PIN = pin_param,
        Id_departamento = id_departamento_existente
    WHERE Id_medico = id_medico_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Editar_Paciente` (IN `id_paciente_param` INT, IN `nombre_param` VARCHAR(100), IN `apellidos_param` VARCHAR(100), IN `telefono_param` VARCHAR(20), IN `fecha_nacimiento_param` DATE, IN `ciudad_param` VARCHAR(100), IN `calle_param` VARCHAR(255), IN `email_param` VARCHAR(100), IN `pin_param` VARCHAR(255))   BEGIN
    DECLARE id_direccion_existente INT;

    -- Verificar si la dirección ya existe
    SELECT Id_direccion INTO id_direccion_existente
    FROM Direccion
    WHERE Ciudad = ciudad_param AND Calle = calle_param
    LIMIT 1;

    -- Si no existe, insertamos una nueva dirección
    IF id_direccion_existente IS NULL THEN
        INSERT INTO Direccion (Ciudad, Calle)
        VALUES (ciudad_param, calle_param);
        
        -- Obtener el ID de la nueva dirección
        SET id_direccion_existente = LAST_INSERT_ID();
    END IF;

    -- Actualizar los datos del paciente con la dirección correcta
    UPDATE Paciente 
    SET 
        Nombre = nombre_param,
        Apellidos = apellidos_param,
        Telefono = telefono_param,
        Fecha_nacimiento = fecha_nacimiento_param,
        Id_direccion = id_direccion_existente,
        Email = email_param,
        PIN = pin_param
    WHERE Id_paciente = id_paciente_param;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Departamento` (IN `p_id_departamento` INT)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Hospital` (IN `nombre_hospital` VARCHAR(50))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Medico` (IN `email_medico` VARCHAR(50))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Paciente` (IN `email_paciente` VARCHAR(50))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Departamento` (IN `nombre_hospital` VARCHAR(50), IN `nombre` VARCHAR(50), IN `ubicacion` VARCHAR(50))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Diagnostico` (IN `cita_id` INT, IN `descripcion` VARCHAR(100), IN `recomendacion` VARCHAR(100))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Hospital` (IN `nombre_param` VARCHAR(50), IN `ciudad_param` VARCHAR(50), IN `calle_param` VARCHAR(50))   BEGIN
    DECLARE id_direccion_existente INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el hospital';
    END;

    START TRANSACTION;

    -- Verificar si la dirección ya existe
    SELECT Id_direccion INTO id_direccion_existente
    FROM Direccion
    WHERE Ciudad = ciudad_param AND Calle = calle_param
    LIMIT 1;

    -- Si no existe, insertamos una nueva dirección
    IF id_direccion_existente IS NULL THEN
        INSERT INTO Direccion (Ciudad, Calle)
        VALUES (ciudad_param, calle_param);
        
        -- Obtener el ID de la nueva dirección
        SET id_direccion_existente = LAST_INSERT_ID();
    END IF;

    -- Insertar el hospital si no existe
    IF NOT EXISTS (SELECT 1 FROM Hospital WHERE Nombre = nombre_param) THEN
        INSERT INTO Hospital (Nombre, Id_direccion) 
        VALUES (nombre_param, id_direccion_existente);
    END IF;

    COMMIT;
    SELECT 'Hospital insertado correctamente' AS Mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Medicamento` (IN `id_diagnostico` INT, IN `nombre_medicamento` VARCHAR(255), IN `frecuencia` VARCHAR(255))   BEGIN
    DECLARE exit handler for SQLEXCEPTION
    BEGIN
        ROLLBACK;
        -- Usar GET DIAGNOSTICS para MySQL en lugar de ERROR_MESSAGE()
        GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
        @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SELECT CONCAT('Error al insertar el medicamento: ', @text) AS mensaje_error;
    END;

    START TRANSACTION;
    INSERT INTO Tabla_Medicamento (Id_diagnostico, Nombre, Frecuencia)
    VALUES (id_diagnostico, nombre_medicamento, frecuencia);
    COMMIT;

    SELECT 'Medicamento insertado correctamente' AS mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Medico` (IN `nombre_hospital` VARCHAR(50), IN `nombre_departamento` VARCHAR(50), IN `nombre` VARCHAR(50), IN `apellidos` VARCHAR(50), IN `telefono` INT, IN `fecha_nacimiento` DATE, IN `ciudad` VARCHAR(50), IN `calle` VARCHAR(50), IN `email` VARCHAR(50), IN `pin` VARCHAR(255))   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Paciente` (IN `nombre_param` VARCHAR(100), IN `apellidos_param` VARCHAR(100), IN `telefono_param` VARCHAR(20), IN `fecha_nacimiento_param` DATE, IN `ciudad_param` VARCHAR(100), IN `calle_param` VARCHAR(255), IN `email_param` VARCHAR(100), IN `pin_param` VARCHAR(255))   BEGIN
    DECLARE id_direccion_existente INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el paciente';
    END;

    START TRANSACTION;

    -- Verificar si la dirección ya existe
    SELECT Id_direccion INTO id_direccion_existente
    FROM Direccion
    WHERE Ciudad = ciudad_param AND Calle = calle_param
    LIMIT 1;

    -- Si no existe, insertamos una nueva dirección
    IF id_direccion_existente IS NULL THEN
        INSERT INTO Direccion (Ciudad, Calle)
        VALUES (ciudad_param, calle_param);
        
        -- Obtener el ID de la nueva dirección
        SET id_direccion_existente = LAST_INSERT_ID();
    END IF;

    -- Insertar el paciente con la dirección correcta
    INSERT INTO Paciente (Nombre, Apellidos, Telefono, Fecha_nacimiento, Id_direccion, Email, PIN)
    VALUES (nombre_param, apellidos_param, telefono_param, fecha_nacimiento_param, id_direccion_existente, email_param, pin_param);

    COMMIT;
    SELECT 'Paciente insertado correctamente' AS Mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerCitasMedico` (IN `medico_id` INT)   BEGIN
    SELECT 
        c.Id_Cita,
        c.Fecha, 
        DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita,
        c.Estado,
        p.Nombre AS Nombre_Paciente,
        p.Apellidos AS Apellidos_Paciente
    FROM 
        Cita c
        JOIN Paciente p ON c.Id_Paciente = p.Id_Paciente
    WHERE 
        c.Id_Medico = medico_id 
        AND c.Estado IN ('Paciente Asignado')
    ORDER BY 
        c.Fecha, c.Hora;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerCitasPacienteAsignado` (IN `medico_id` INT)   BEGIN
    SELECT 
        c.Id_Cita, 
        c.Fecha, 
        DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita,
        p.Nombre AS Nombre_Paciente, 
        p.Apellidos AS Apellidos_Paciente
    FROM 
        Cita c
        JOIN Paciente p ON c.Id_Paciente = p.Id_Paciente
    WHERE 
        c.Id_Medico = medico_id 
        AND c.Estado = 'Paciente Asignado';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDiagnosticoPorCita` (IN `cita_id` INT)   BEGIN
    SELECT 
        diag.Descripcion, 
        diag.Recomendacion
    FROM 
        Cita c
        JOIN Diagnostico diag ON c.Id_diagnostico = diag.Id_diagnostico
    WHERE 
        c.Id_cita = cita_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerMedicamentosPorCita` (IN `cita_id` INT)   BEGIN
    SELECT 
        med.Nombre, 
        med.Frecuencia
    FROM 
        Cita c
        JOIN Diagnostico diag ON c.Id_diagnostico = diag.Id_diagnostico
        JOIN Medicamento med ON diag.Id_diagnostico = med.Id_diagnostico
    WHERE 
        c.Id_cita = cita_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Citas` ()   BEGIN
    SELECT 
        c.Id_Cita,
        c.Fecha,
        TIME_FORMAT(c.Hora, '%H:%i:%s') AS Hora,
        m.Nombre AS Nombre_Medico,
        m.Apellidos AS Apellidos_Medico,
        p.Nombre AS Nombre_Paciente,
        p.Apellidos AS Apellido_Paciente,
        d.Nombre AS Nombre_Departamento,
        h.Nombre AS Nombre_Hospital,
        c.Estado
    FROM 
        Cita c
        JOIN Medico m ON c.Id_medico = m.Id_medico
        JOIN Departamento d ON m.Id_departamento = d.Id_departamento
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital
        JOIN Paciente p ON c.Id_paciente = p.Id_paciente
    ORDER BY 
        c.Fecha DESC, c.Hora DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Citas_Paciente` (IN `paciente_id` INT)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Citas_Pendientes_Cursor` (IN `p_hospital` VARCHAR(255), IN `p_departamento` VARCHAR(255), IN `p_fecha` DATE)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Departamentos_Hospitales` ()   BEGIN
    SELECT 
        d.Id_departamento,
        d.Nombre AS Nombre_departamento,
        d.Ubicacion AS Ubicacion_departamento,
        h.Id_hospital,
        h.Nombre AS Nombre_hospital,
        dir.Ciudad AS Ciudad_hospital,
        dir.Calle AS Calle_hospital
    FROM 
        Departamento d
        JOIN Hospital h ON d.Id_hospital = h.Id_hospital
        JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Departamentos_Hospitales_Cursor` (IN `id_departamento_param` INT)   BEGIN
    IF id_departamento_param IS NULL OR id_departamento_param = 0 THEN
        -- Si no se proporciona un ID, devolver todos los departamentos
        SELECT 
            d.Id_departamento,
            d.Nombre AS Nombre_departamento,
            d.Ubicacion AS Ubicacion_departamento,
            h.Id_hospital,
            h.Nombre AS Nombre_hospital,
            dir.Ciudad AS Ciudad_hospital,  
            dir.Calle AS Calle_hospital     
        FROM 
            Departamento d
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital
            JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;
    ELSE
        -- Si se proporciona un ID, devolver solo ese departamento
        SELECT 
            d.Id_departamento,
            d.Nombre AS Nombre_departamento,
            d.Ubicacion AS Ubicacion_departamento,
            h.Id_hospital,
            h.Nombre AS Nombre_hospital,
            dir.Ciudad AS Ciudad_hospital,  
            dir.Calle AS Calle_hospital     
        FROM 
            Departamento d
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital
            JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion
        WHERE 
            d.Id_departamento = id_departamento_param;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Hospitales_Cursor` (IN `p_Id_hospital` INT)   BEGIN
    IF p_Id_hospital IS NULL OR p_Id_hospital = 0 THEN
        -- Si no se recibe un ID o es 0, devuelve todos los hospitales
        SELECT 
            h.Id_hospital,
            h.Nombre AS Nombre_hospital,
            dir.Ciudad AS Ciudad_hospital,
            dir.Calle AS Calle_hospital
        FROM 
            Hospital h
            JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;
    ELSE
        -- Si se recibe un ID válido, devuelve solo ese hospital
        SELECT 
            h.Id_hospital,
            h.Nombre AS Nombre_hospital,
            dir.Ciudad AS Ciudad_hospital,
            dir.Calle AS Calle_hospital
        FROM 
            Hospital h
            JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion
        WHERE 
            h.Id_hospital = p_Id_hospital;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Medicos_Cursor` (IN `id_medico_param` INT)   BEGIN
    IF id_medico_param IS NULL OR id_medico_param = 0 THEN
        -- Si no se proporciona un ID, devuelve todos los médicos
        SELECT 
            m.Id_medico,
            m.Nombre,
            m.Apellidos,
            m.Telefono,
            m.Fecha_nacimiento,
            dir.Ciudad,  
            dir.Calle,   
            m.Email,
            m.PIN,
            d.Id_departamento,
            d.Nombre AS Nombre_departamento,
            h.Id_hospital,
            h.Nombre AS Nombre_hospital
        FROM 
            Medico m
            JOIN Direccion dir ON m.Id_direccion = dir.Id_direccion  
            JOIN Departamento d ON m.Id_departamento = d.Id_departamento
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital;
    ELSE
        -- Si se proporciona un ID, devuelve solo ese médico
        SELECT 
            m.Id_medico,
            m.Nombre,
            m.Apellidos,
            m.Telefono,
            m.Fecha_nacimiento,
            dir.Ciudad,  
            dir.Calle,   
            m.Email,
            m.PIN,
            d.Id_departamento,
            d.Nombre AS Nombre_departamento,
            h.Id_hospital,
            h.Nombre AS Nombre_hospital
        FROM 
            Medico m
            JOIN Direccion dir ON m.Id_direccion = dir.Id_direccion  
            JOIN Departamento d ON m.Id_departamento = d.Id_departamento
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital
        WHERE 
            m.Id_medico = id_medico_param;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Pacientes_Cursor` (IN `id_paciente_param` INT)   BEGIN
    IF id_paciente_param IS NULL THEN
        -- Si no se recibe un ID, devolver todos los pacientes
        SELECT 
            p.Id_paciente,
            p.Nombre,
            p.Apellidos,
            p.Telefono,
            p.Fecha_nacimiento,
            dir.Ciudad,
            dir.Calle,
            p.Email,
            p.PIN
        FROM 
            Paciente p
        JOIN Direccion dir ON p.Id_direccion = dir.Id_direccion;
    ELSE
        -- Si se recibe un ID, devolver solo ese paciente
        SELECT 
            p.Id_paciente,
            p.Nombre,
            p.Apellidos,
            p.Telefono,
            p.Fecha_nacimiento,
            dir.Ciudad,
            dir.Calle,
            p.Email,
            p.PIN
        FROM 
            Paciente p
        JOIN Direccion dir ON p.Id_direccion = dir.Id_direccion
        WHERE p.Id_paciente = id_paciente_param;
    END IF;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Obtener_Max_Id_Diagnostico` () RETURNS INT(11) READS SQL DATA BEGIN  
    DECLARE max_id_diagnostico INT;  

    -- Obtener el máximo ID de diagnóstico (manejar nulos)  
    SELECT IFNULL(MAX(Id_diagnostico), 0) INTO max_id_diagnostico FROM Diagnostico;  

    RETURN max_id_diagnostico;  
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Verificar_Cita_Paciente` (`cita_id` INT, `paciente_id` INT) RETURNS TINYINT(1) DETERMINISTIC READS SQL DATA BEGIN
    DECLARE existe BOOLEAN;
    
    SELECT COUNT(*) > 0 INTO existe
    FROM Cita
    WHERE Id_Cita = cita_id AND Id_paciente = paciente_id;
    
    RETURN existe;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `Id_cita` int(11) NOT NULL,
  `Id_medico` int(11) DEFAULT NULL,
  `Id_paciente` int(11) DEFAULT NULL,
  `Id_diagnostico` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `Id_departamento` int(11) NOT NULL,
  `Id_hospital` int(11) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Ubicacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`Id_departamento`, `Id_hospital`, `Nombre`, `Ubicacion`) VALUES
(1, 1, 'Neurología', 'Piso 1'),
(2, 2, 'Oncología', 'Piso 2'),
(3, 3, 'Dermatología', 'Piso 3'),
(4, 4, 'Ginecología', 'Piso 4');

-- --------------------------------------------------------

--
-- Table structure for table `diagnostico`
--

CREATE TABLE `diagnostico` (
  `Id_diagnostico` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Recomendacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `Id_direccion` int(11) NOT NULL,
  `Ciudad` varchar(50) DEFAULT NULL,
  `Calle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `direccion`
--

INSERT INTO `direccion` (`Id_direccion`, `Ciudad`, `Calle`) VALUES
(1, 'Sevilla', 'Calle Sierpes 12'),
(2, 'Bilbao', 'Gran Vía 45'),
(3, 'Zaragoza', 'Paseo Independencia 33'),
(4, 'Málaga', 'Avenida de Andalucía 20');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `Id_hospital` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Id_direccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`Id_hospital`, `Nombre`, `Id_direccion`) VALUES
(1, 'Hospital de Sevilla', 1),
(2, 'Hospital de Bilbao', 2),
(3, 'Hospital de Zaragoza', 3),
(4, 'Hospital de Málaga', 4);

-- --------------------------------------------------------

--
-- Table structure for table `medicamento`
--

CREATE TABLE `medicamento` (
  `Id_medicamento` int(11) NOT NULL,
  `Id_diagnostico` int(11) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Frecuencia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `Id_medico` int(11) NOT NULL,
  `Id_departamento` int(11) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Id_direccion` int(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `PIN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medico`
--

INSERT INTO `medico` (`Id_medico`, `Id_departamento`, `Nombre`, `Apellidos`, `Telefono`, `Fecha_nacimiento`, `Id_direccion`, `Email`, `PIN`) VALUES
(1, 1, 'Carmen', 'Herrera', 695678915, '1970-08-21', 1, 'carmen.herrera@mail.com', '$2y$10$3Q45m/iiDDprF38l8fZAEOg2fdt483iaLrywBUYp1hyHYe5QNcEGm'),
(2, 2, 'José', 'Navarro', 705678916, '1982-04-10', 2, 'jose.navarro@mail.com', '$2y$10$xkkf6Ayc/vlrxa0yi83xMuE2PqVxIiUM..GX6SULyVoGPOh1cw2mO'),
(3, 3, 'Patricia', 'Ortega', 715678917, '1991-01-15', 3, 'patricia.ortega@mail.com', ' $2y$10$IvfthNOLDWTVAfNZ9LzrAOGFe35ChWSjK.nRa0bBqDO2L3SWkNAsq'),
(4, 4, 'Alejandro', 'Jiménez', 725678918, '1975-07-09', 4, 'alejandro.jimenez@mail.com', '$2y$10$WWghxpLpOxwEVCOGHJUTi.kT.PRoz1q5msK5zkm0R1JFr07zPr5Le');

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `Id_paciente` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Id_direccion` int(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `PIN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`Id_paciente`, `Nombre`, `Apellidos`, `Telefono`, `Fecha_nacimiento`, `Id_direccion`, `Email`, `PIN`) VALUES
(1, 'Luis', 'Ramírez', 645678910, '1995-09-12', 1, 'luis.ramirez@mail.com', '$2y$10$TTEHVGLUepuj0lZzE5S28.30TdXRuDIvRgRSPRuV2QxmMNUDS58CG'),
(2, 'Marta', 'Sánchez', 655678911, '2000-12-05', 2, 'marta.sanchez@mail.com', '$2y$10$eP9UVL56/tpXZHIH5jvc7ezCjnwi0hOYpjI.sdOJ.knYcCbGUqZQ2'),
(3, 'Roberto', 'Díaz', 665678912, '1988-03-25', 3, 'roberto.diaz@mail.com', '$2y$10$jKhT7jcxdbIGzq7AKw5NP.TOv17hiPXDwy88/OAm2Fm5yta1NkKvi'),
(4, 'Elena', 'Torres', 675678913, '1993-06-17', 4, 'elena.torres@mail.com', '$2y$10$CY9BTAr3FGKNuUOus.FBYu6OMsO5oSW0quOhJojg2lMuOBrZMEg3.'),
(5, 'admin', 'admin', 0, '0000-00-00', 4, 'admin@mail.com', '$2y$10$hCfnOOlCoNX1lO1gkDrGfu6OnCMYVWmik1KhvyAbxZEUdGdoWd4oC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`Id_cita`),
  ADD KEY `Id_medico` (`Id_medico`),
  ADD KEY `Id_paciente` (`Id_paciente`),
  ADD KEY `Id_diagnostico` (`Id_diagnostico`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`Id_departamento`),
  ADD UNIQUE KEY `ak_departamento` (`Nombre`,`Id_hospital`),
  ADD KEY `Id_hospital` (`Id_hospital`);

--
-- Indexes for table `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD PRIMARY KEY (`Id_diagnostico`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`Id_direccion`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`Id_hospital`),
  ADD UNIQUE KEY `Nombre` (`Nombre`),
  ADD KEY `Id_direccion` (`Id_direccion`);

--
-- Indexes for table `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`Id_medicamento`),
  ADD KEY `Id_diagnostico` (`Id_diagnostico`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`Id_medico`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Id_departamento` (`Id_departamento`),
  ADD KEY `Id_direccion` (`Id_direccion`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Id_paciente`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Id_direccion` (`Id_direccion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `Id_cita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `Id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `diagnostico`
--
ALTER TABLE `diagnostico`
  MODIFY `Id_diagnostico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direccion`
--
ALTER TABLE `direccion`
  MODIFY `Id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `Id_hospital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `Id_medicamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medico`
--
ALTER TABLE `medico`
  MODIFY `Id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `Id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`Id_medico`) REFERENCES `medico` (`Id_medico`),
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`Id_paciente`) REFERENCES `paciente` (`Id_paciente`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`Id_diagnostico`) REFERENCES `diagnostico` (`Id_diagnostico`);

--
-- Constraints for table `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`Id_hospital`) REFERENCES `hospital` (`Id_hospital`);

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`);

--
-- Constraints for table `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`Id_diagnostico`) REFERENCES `diagnostico` (`Id_diagnostico`);

--
-- Constraints for table `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`Id_departamento`) REFERENCES `departamento` (`Id_departamento`),
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`);

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
