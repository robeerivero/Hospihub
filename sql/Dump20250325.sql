-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: hospihub
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cita` (
  `Id_cita` int NOT NULL AUTO_INCREMENT,
  `Id_medico` int DEFAULT NULL,
  `Id_paciente` int DEFAULT NULL,
  `Id_diagnostico` int DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` timestamp NULL DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_cita`),
  KEY `Id_medico` (`Id_medico`),
  KEY `Id_paciente` (`Id_paciente`),
  KEY `Id_diagnostico` (`Id_diagnostico`),
  CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`Id_medico`) REFERENCES `medico` (`Id_medico`),
  CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`Id_paciente`) REFERENCES `paciente` (`Id_paciente`),
  CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`Id_diagnostico`) REFERENCES `diagnostico` (`Id_diagnostico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `Id_departamento` int NOT NULL AUTO_INCREMENT,
  `Id_hospital` int DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Ubicacion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_departamento`),
  UNIQUE KEY `ak_departamento` (`Nombre`,`Id_hospital`),
  KEY `Id_hospital` (`Id_hospital`),
  CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`Id_hospital`) REFERENCES `hospital` (`Id_hospital`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,1,'Cardiología','Piso 1'),(2,1,'Pediatría','Piso 2'),(3,2,'Traumatología','Piso 3');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostico`
--

DROP TABLE IF EXISTS `diagnostico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostico` (
  `Id_diagnostico` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Recomendacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_diagnostico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostico`
--

LOCK TABLES `diagnostico` WRITE;
/*!40000 ALTER TABLE `diagnostico` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion` (
  `Id_direccion` int NOT NULL AUTO_INCREMENT,
  `Ciudad` varchar(50) DEFAULT NULL,
  `Calle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES (1,'Madrid','Gran Vía 1'),(2,'Barcelona','Diagonal 100'),(3,'Valencia','Avenida del Puerto 45');
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospital`
--

DROP TABLE IF EXISTS `hospital`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospital` (
  `Id_hospital` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Id_direccion` int DEFAULT NULL,
  PRIMARY KEY (`Id_hospital`),
  UNIQUE KEY `Nombre` (`Nombre`),
  KEY `Id_direccion` (`Id_direccion`),
  CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospital`
--

LOCK TABLES `hospital` WRITE;
/*!40000 ALTER TABLE `hospital` DISABLE KEYS */;
INSERT INTO `hospital` VALUES (1,'Hospital Central',1),(2,'Clínica Barcelona',2),(3,'Hospital Valencia',3);
/*!40000 ALTER TABLE `hospital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento`
--

DROP TABLE IF EXISTS `medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicamento` (
  `Id_medicamento` int NOT NULL AUTO_INCREMENT,
  `Id_diagnostico` int DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Frecuencia` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_medicamento`),
  KEY `Id_diagnostico` (`Id_diagnostico`),
  CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`Id_diagnostico`) REFERENCES `diagnostico` (`Id_diagnostico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento`
--

LOCK TABLES `medicamento` WRITE;
/*!40000 ALTER TABLE `medicamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medico` (
  `Id_medico` int NOT NULL AUTO_INCREMENT,
  `Id_departamento` int DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Id_direccion` int DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `PIN` int DEFAULT NULL,
  PRIMARY KEY (`Id_medico`),
  UNIQUE KEY `Email` (`Email`),
  KEY `Id_departamento` (`Id_departamento`),
  KEY `Id_direccion` (`Id_direccion`),
  CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`Id_departamento`) REFERENCES `departamento` (`Id_departamento`),
  CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (1,1,'Laura','Fernández',642345678,'1975-03-21',1,'laura.fernandez@mail.com',4321),(2,2,'David','Martínez',652345678,'1983-11-10',2,'david.martinez@mail.com',8765),(3,3,'Sofía','Ruiz',662345678,'1990-06-15',3,'sofia.ruiz@mail.com',1112);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `Id_paciente` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Id_direccion` int DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `PIN` int DEFAULT NULL,
  PRIMARY KEY (`Id_paciente`),
  UNIQUE KEY `Email` (`Email`),
  KEY `Id_direccion` (`Id_direccion`),
  CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`Id_direccion`) REFERENCES `direccion` (`Id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,'Juan','Pérez',612345678,'1980-05-14',1,'juan.perez@mail.com',1234),(2,'Ana','López',622345678,'1992-07-22',2,'ana.lopez@mail.com',5678),(3,'Carlos','Gómez',632345678,'1985-10-30',3,'carlos.gomez@mail.com',9101);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'hospihub'
--

--
-- Dumping routines for database 'hospihub'
--
/*!50003 DROP FUNCTION IF EXISTS `Obtener_Max_Id_Diagnostico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `Obtener_Max_Id_Diagnostico`() RETURNS int
    READS SQL DATA
BEGIN  
    DECLARE max_id_diagnostico INT;  

    -- Obtener el máximo ID de diagnóstico (manejar nulos)  
    SELECT IFNULL(MAX(Id_diagnostico), 0) INTO max_id_diagnostico FROM Diagnostico;  

    RETURN max_id_diagnostico;  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `Verificar_Credenciales_Medico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `Verificar_Credenciales_Medico`(
    email_in VARCHAR(50), 
    pin_in INT  -- Cambiado a INT para coincidir con el tipo de la tabla
) RETURNS int
    READS SQL DATA
BEGIN
    DECLARE id_medico INT;

    SELECT Id_Medico INTO id_medico
    FROM Medico  -- Nombre de tabla corregido
    WHERE Email = email_in AND PIN = pin_in;

    RETURN COALESCE(id_medico, 0);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `Verificar_Credenciales_Paciente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `Verificar_Credenciales_Paciente`(email_in VARCHAR(50), pin_in INT) RETURNS int
    READS SQL DATA
BEGIN  
    DECLARE paciente_id INT;  

    -- Verificar credenciales (manejar nulos)  
    SELECT Id_paciente INTO paciente_id FROM Paciente WHERE Email = email_in AND PIN = pin_in;  

    RETURN IFNULL(paciente_id, 0);  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Asignar_Cita` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Asignar_Cita`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Crear_Citas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Crear_Citas`()
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Eliminar_Departamento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Departamento`(
    IN nombre_departamento VARCHAR(50),
    IN nombre_hospital VARCHAR(50)
)
BEGIN
    DECLARE v_id_hospital INT;
    DECLARE v_id_departamento INT;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al eliminar el departamento';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;
    
    -- Obtener el ID del departamento
    SELECT Id_departamento INTO v_id_departamento FROM Departamento 
    WHERE Nombre = nombre_departamento AND Id_hospital = v_id_hospital;
    
    -- Eliminar médicos asociados al departamento
    DELETE FROM Medico WHERE Id_departamento = v_id_departamento;
    
    -- Eliminar el departamento
    DELETE FROM Departamento WHERE Id_departamento = v_id_departamento;

    COMMIT;
    SELECT 'Departamento eliminado correctamente' AS Mensaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Eliminar_Hospital` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Hospital`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Eliminar_Medico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Medico`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Eliminar_Paciente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Paciente`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insertar_Departamento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Departamento`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insertar_Diagnostico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Diagnostico`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insertar_Hospital` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Hospital`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insertar_Medico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Medico`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insertar_Paciente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Paciente`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Obtener_Citas_Pendientes_Cursor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Citas_Pendientes_Cursor`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Obtener_Departamentos_Hospitales_Cursor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Departamentos_Hospitales_Cursor`()
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Obtener_Hospitales_Cursor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Hospitales_Cursor`()
BEGIN
    SELECT 
        h.Id_hospital,
        h.Nombre AS Nombre_hospital,
        dir.Ciudad AS Ciudad_hospital,  -- Desde Direccion
        dir.Calle AS Calle_hospital      -- Desde Direccion
    FROM 
        Hospital h
        JOIN Direccion dir ON h.Id_direccion = dir.Id_direccion;  -- JOIN añadido
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Obtener_Medicos_Cursor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Medicos_Cursor`()
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Obtener_Pacientes_Cursor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Obtener_Pacientes_Cursor`()
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-25 13:18:25
