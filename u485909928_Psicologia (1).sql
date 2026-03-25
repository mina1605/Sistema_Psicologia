-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-03-2026 a las 21:32:28
-- Versión del servidor: 11.8.6-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u485909928_Psicologia`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_alumnos_listar` ()  DETERMINISTIC BEGIN
    SELECT 
        u.idUsuario_a, u.Matricula, u.Nombre, u.Sexo, u.Edad, u.Carrera, 
        u.Cuatrimestre, u.Grupo, u.Turno, u.Correo, u.Num_Tel, u.Fecha_Registro,
        COUNT(s.Folio) AS total_sesiones
    FROM usuarios u
    LEFT JOIN sesiones s ON s.idUsuario = u.idUsuario_a
    WHERE u.Rol = 'usuario'
    GROUP BY u.idUsuario_a
    ORDER BY u.Nombre ASC;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_alumno_crear` (IN `p_matricula` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_sexo` ENUM('Masculino','Femenino','Otro'), IN `p_edad` INT, IN `p_carrera` VARCHAR(100), IN `p_cuatrimestre` INT, IN `p_grupo` VARCHAR(10), IN `p_turno` ENUM('Matutino','Vespertino','Mixto'), IN `p_tel` VARCHAR(15), IN `p_correo` VARCHAR(100), IN `p_contrasena` VARCHAR(255), IN `p_estado_civil` VARCHAR(30), IN `p_num_familia` INT)  DETERMINISTIC BEGIN
    DECLARE v_id INT;
    INSERT INTO usuarios (Matricula, Nombre, Sexo, Edad, Carrera, Cuatrimestre, Grupo, Turno, Num_Tel, Correo, Contrasena, Rol)
    VALUES (p_matricula, p_nombre, p_sexo, p_edad, p_carrera, p_cuatrimestre, p_grupo, p_turno, p_tel, p_correo, p_contrasena, 'usuario');
    SET v_id = LAST_INSERT_ID();
    INSERT INTO expedientes (idUsuario, Estado_Civil, Ocupacion, Num_Integrantes_Familia, Fecha_Creacion)
    VALUES (v_id, p_estado_civil, 'Estudiante', p_num_familia, CURDATE());
    SELECT v_id AS idUsuario_a, 'Alumno y expediente creados' AS mensaje;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_canalizaciones_listar` ()  DETERMINISTIC BEGIN
    SELECT c.*, u.Nombre, u.Matricula FROM canalizados c 
    JOIN usuarios u ON u.idUsuario_a = c.idUsuario 
    ORDER BY c.Fecha DESC;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_citas_listar` (IN `p_estado` VARCHAR(20))  DETERMINISTIC BEGIN
    SELECT 
        c.Folio, c.Fecha, TIME_FORMAT(c.Hora, '%H:%i') AS Hora, c.Estado,
        u.idUsuario_a AS idUsuario, u.Nombre AS alumno_nombre, u.Matricula, 
        u.Carrera, u.Grupo, u.Turno, p.periodo AS cuatrimestre_nombre
    FROM citas c
    JOIN usuarios u ON u.idUsuario_a = c.idUsuario
    LEFT JOIN periodo_escolar p ON p.idCuatri = c.idCuatri
    WHERE (p_estado = '' OR p_estado IS NULL OR c.Estado = p_estado)
    ORDER BY c.Fecha ASC, c.Hora ASC;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_cita_crear` (IN `p_idUsuario` INT, IN `p_fecha` DATE, IN `p_hora` TIME, IN `p_idCuatri` INT, IN `p_estado` VARCHAR(20), OUT `p_folio` INT, OUT `p_error` VARCHAR(200))  DETERMINISTIC BEGIN
    DECLARE v_existe INT DEFAULT 0;
    SELECT COUNT(*) INTO v_existe FROM citas WHERE Fecha = p_fecha AND Hora = p_hora AND Estado != 'Cancelada';
    IF v_existe > 0 THEN
        SET p_error = 'Horario ocupado.'; SET p_folio = 0;
    ELSE
        INSERT INTO citas (idUsuario, idCuatri, Fecha, Hora, Estado)
        VALUES (p_idUsuario, p_idCuatri, p_fecha, p_hora, IFNULL(p_estado, 'Programada'));
        SET p_folio = LAST_INSERT_ID(); SET p_error = '';
    END IF;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_dashboard_citas_hoy` (IN `p_fecha` DATE)  DETERMINISTIC BEGIN
    SELECT 
        c.Folio, c.Fecha, TIME_FORMAT(c.Hora, '%H:%i') AS Hora, c.Estado,
        u.idUsuario_a  AS idUsuario, u.Nombre AS alumno_nombre,
        u.Matricula, u.Carrera, u.Grupo, u.Turno
    FROM citas c
    JOIN usuarios u ON u.idUsuario_a = c.idUsuario
    WHERE c.Fecha = p_fecha
    ORDER BY c.Hora ASC;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_dashboard_stats` (IN `p_fecha` DATE, IN `p_mes` CHAR(7))  DETERMINISTIC BEGIN
    SELECT COUNT(*) AS citas_hoy FROM citas WHERE Fecha = p_fecha AND Estado != 'Cancelada';
    SELECT COUNT(*) AS total_alumnos FROM usuarios WHERE Rol = 'usuario';
    SELECT COUNT(*) AS sesiones_mes FROM sesiones WHERE DATE_FORMAT(Fecha, '%Y-%m') = p_mes AND Estado = 'Asistió';
    SELECT COUNT(*) AS total_canalizaciones FROM canalizados;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_expedientes_listar` ()  DETERMINISTIC BEGIN
    SELECT 
        e.idExpediente, e.idUsuario, e.Estado_Civil, u.Matricula, u.Nombre, u.Carrera,
        COUNT(s.Folio) AS total_sesiones, MAX(s.Fecha) AS ultima_sesion
    FROM expedientes e
    JOIN usuarios u ON u.idUsuario_a = e.idUsuario
    LEFT JOIN sesiones s ON s.idUsuario = e.idUsuario
    GROUP BY e.idExpediente ORDER BY u.Nombre ASC;
END$$

CREATE DEFINER=`u485909928_judith`@`127.0.0.1` PROCEDURE `sp_sesiones_listar` (IN `p_mes` CHAR(7), IN `p_estado` VARCHAR(20), IN `p_idUsuario` INT)  DETERMINISTIC BEGIN
    SELECT 
        s.Folio, s.Numero_Sesion, s.Fecha, s.Estado, s.Diagnostico, s.Notas,
        u.idUsuario_a AS idUsuario, u.Nombre AS alumno_nombre, u.Matricula
    FROM sesiones s
    JOIN usuarios u ON u.idUsuario_a = s.idUsuario
    WHERE (p_mes IS NULL OR p_mes = '' OR DATE_FORMAT(s.Fecha, '%Y-%m') = p_mes)
      AND (p_estado IS NULL OR p_estado = '' OR s.Estado = p_estado)
      AND (p_idUsuario = 0 OR s.idUsuario = p_idUsuario)
    ORDER BY s.Fecha DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `idHorario` int(11) NOT NULL,
  `idCuatri` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`idHorario`, `idCuatri`, `fecha`, `hora`, `disponible`) VALUES
(3, 1, '2026-03-24', '10:00:00', 0),
(7, 1, '2026-03-25', '08:00:00', 1),
(8, 1, '2026-03-25', '09:00:00', 0),
(9, 1, '2026-03-25', '10:00:00', 1),
(12, 1, '2026-03-25', '15:00:00', 1),
(13, 1, '2026-03-26', '08:00:00', 0),
(14, 1, '2026-03-26', '09:00:00', 1),
(15, 1, '2026-03-26', '10:00:00', 1),
(16, 1, '2026-03-26', '14:00:00', 1),
(17, 1, '2026-03-26', '15:00:00', 0),
(19, 1, '2026-03-27', '09:00:00', 1),
(20, 1, '2026-03-27', '10:00:00', 1),
(21, 1, '2026-03-27', '11:00:00', 0),
(22, 1, '2026-03-27', '14:00:00', 1),
(23, 1, '2026-03-27', '15:00:00', 1),
(25, 1, '2026-03-28', '09:00:00', 1),
(26, 1, '2026-03-28', '10:00:00', 0),
(27, 1, '2026-03-28', '11:00:00', 1),
(28, 1, '2026-03-28', '14:00:00', 1),
(29, 1, '2026-03-28', '15:00:00', 1),
(35, NULL, '2026-03-23', '08:00:00', 1),
(38, NULL, '2026-03-24', '08:00:00', 1),
(40, NULL, '2026-03-24', '15:00:00', 1),
(41, NULL, '2026-03-25', '16:30:00', 1),
(42, NULL, '2026-03-25', '11:00:00', 1),
(43, NULL, '2026-03-24', '16:30:00', 1),
(44, NULL, '2026-03-24', '11:00:00', 1),
(45, NULL, '2026-03-24', '09:00:00', 1),
(46, NULL, '2026-03-23', '16:30:00', 1),
(47, NULL, '2026-03-23', '11:00:00', 1),
(48, NULL, '2026-03-23', '09:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canalizados`
--

CREATE TABLE `canalizados` (
  `idCanalizacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Institucion_Destino` enum('Instituto de la Mujer','Centro de Integración Juvenil (CIJ)','Fundación Daniela Guzmán','UNABIA','Otra') NOT NULL,
  `Motivo` text NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `canalizados`
--

INSERT INTO `canalizados` (`idCanalizacion`, `idUsuario`, `Institucion_Destino`, `Motivo`, `Fecha`) VALUES
(1, 6, 'Centro de Integración Juvenil (CIJ)', 'Consumo experimental de sustancias detectado durante evaluación psicológica.', '2026-02-20'),
(2, 7, 'Instituto de la Mujer', 'Situación de violencia en relación de pareja identificada.', '2026-03-05'),
(3, 13, 'Otra', 'Necesita ayuda urgente', '2026-03-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `Folio` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCuatri` int(11) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Estado` enum('Programada','Confirmada','Cancelada','Completada') NOT NULL DEFAULT 'Programada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`Folio`, `idUsuario`, `idCuatri`, `Fecha`, `Hora`, `Estado`) VALUES
(1, 13, NULL, '2026-03-22', '08:00:00', 'Completada'),
(2, 2, NULL, '2026-03-26', '14:00:00', 'Programada'),
(3, 7, NULL, '2026-03-23', '16:30:00', 'Programada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idCargo` int(11) NOT NULL,
  `Cargo` varchar(100) NOT NULL,
  `Tipo` enum('Administrativo','Educativo') NOT NULL,
  `Ubicacion` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`idCargo`, `Cargo`, `Tipo`, `Ubicacion`, `Descripcion`) VALUES
(1, 'Psicóloga CEPS', 'Educativo', 'Edificio D, Planta Baja', 'Atención psicológica a estudiantes'),
(2, 'Coordinador ISC', 'Educativo', 'Edificio A, Piso 1', 'Coordinación carrera ISC'),
(3, 'Coordinador LAE', 'Educativo', 'Edificio B, Planta Baja', 'Coordinación carrera LAE'),
(4, 'Directora Académica', 'Administrativo', 'Rectoría', 'Dirección académica institucional'),
(5, 'Tutor Grupo', 'Educativo', 'Aula asignada', 'Seguimiento tutorial de grupo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `idExpediente` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado_Civil` enum('Soltero','Casado','Divorciado','Viudo','Unión Libre') DEFAULT NULL,
  `Ocupacion` varchar(100) DEFAULT NULL,
  `Num_Integrantes_Familia` int(11) DEFAULT NULL,
  `Fecha_Creacion` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `expedientes`
--

INSERT INTO `expedientes` (`idExpediente`, `idUsuario`, `Estado_Civil`, `Ocupacion`, `Num_Integrantes_Familia`, `Fecha_Creacion`) VALUES
(1, 1, 'Soltero', 'Estudiante', 4, '2026-01-15'),
(2, 2, 'Soltero', 'Estudiante', 4, '2026-01-18'),
(3, 3, 'Soltero', 'Estudiante', 3, '2026-01-20'),
(4, 4, 'Soltero', 'Estudiante', 3, '2026-02-03'),
(5, 5, 'Soltero', 'Estudiante', 3, '2026-01-10'),
(6, 6, 'Soltero', 'Estudiante', 5, '2026-02-10'),
(7, 7, 'Soltero', 'Estudiante', 6, '2026-02-12'),
(8, 8, 'Soltero', 'Estudiante', 6, '2025-09-05'),
(9, 9, 'Divorciado', 'Estudiante', 3, '2025-09-08'),
(10, 10, 'Soltero', 'Estudiante', 4, '2026-03-01'),
(11, 11, 'Soltero', 'Estudiante', 5, '2026-03-05'),
(12, 12, 'Soltero', 'Estudiante', 6, '2026-03-08'),
(13, 14, 'Unión Libre', 'Estudiante', 5, '2026-03-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros`
--

CREATE TABLE `maestros` (
  `idUsuario_m` int(11) NOT NULL,
  `No_Empleado` varchar(20) NOT NULL COMMENT 'Número de empleado — usado para login admin',
  `Nombre` varchar(100) NOT NULL,
  `Sexo` enum('Masculino','Femenino','Otro') NOT NULL,
  `Edad` int(11) DEFAULT NULL,
  `idCargo` int(11) DEFAULT NULL,
  `Direccion` text DEFAULT NULL,
  `Grupo_Tutor` varchar(10) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `maestros`
--

INSERT INTO `maestros` (`idUsuario_m`, `No_Empleado`, `Nombre`, `Sexo`, `Edad`, `idCargo`, `Direccion`, `Grupo_Tutor`, `Correo`, `Telefono`, `Contrasena`, `Rol`) VALUES
(1, 'EMP-001', 'Psic. Fanny Chimal', 'Femenino', 32, 1, NULL, NULL, 'f.chimal@utn.edu.mx', NULL, '123456', 'admin'),
(2, 'EMP-002', 'Ing. Roberto García Mendoza', 'Masculino', 38, 2, NULL, NULL, 'r.garcia@utn.edu.mx', NULL, '123456', 'admin'),
(3, 'EMP-003', 'Lic. Sandra Ríos Gutiérrez', 'Femenino', 45, 4, NULL, NULL, 's.rios@utn.edu.mx', NULL, '123456', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_escolar`
--

CREATE TABLE `periodo_escolar` (
  `idCuatri` int(11) NOT NULL,
  `periodo` varchar(50) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `año` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodo_escolar`
--

INSERT INTO `periodo_escolar` (`idCuatri`, `periodo`, `FechaInicio`, `FechaFin`, `año`) VALUES
(1, 'Enero - Abril', '2026-01-13', '2026-04-30', '2026'),
(2, 'Mayo - Agosto', '2026-05-04', '2026-08-21', '2026'),
(3, 'Septiembre - Diciembre', '2025-09-08', '2025-12-19', '2025');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `Folio` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` enum('Asistió','Faltó','Reprogramada') NOT NULL DEFAULT 'Asistió',
  `Diagnostico` varchar(255) DEFAULT NULL,
  `Notas` text DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Numero_Sesion` int(11) NOT NULL DEFAULT 1,
  `idCita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`Folio`, `idUsuario`, `Estado`, `Diagnostico`, `Notas`, `Fecha`, `Numero_Sesion`, `idCita`) VALUES
(1, 1, 'Asistió', 'Ansiedad generalizada (F41.1)', 'Primera sesión. Motivo: ansiedad ante exámenes. Se aplica psicoeducación.', '2026-01-20', 1, NULL),
(2, 1, 'Asistió', 'Ansiedad generalizada (F41.1)', 'Se trabajan técnicas de respiración. GAD-7: 12.', '2026-02-03', 2, NULL),
(3, 1, 'Asistió', 'Ansiedad generalizada (F41.1)', 'Mejora significativa. GAD-7: 8. Incorpora mindfulness.', '2026-02-17', 3, NULL),
(4, 2, 'Asistió', 'Episodio depresivo leve (F32.0)', 'Primera sesión. Bajo rendimiento y anhedonia.', '2026-01-22', 1, NULL),
(5, 2, 'Asistió', 'Episodio depresivo leve (F32.0)', 'PHQ-9: 9. Activación conductual iniciada.', '2026-02-05', 2, NULL),
(6, 2, 'Asistió', 'Episodio depresivo leve (F32.0)', 'PHQ-9: 6. Mejora notable.', '2026-03-05', 3, NULL),
(7, 3, 'Asistió', 'Estrés académico (Z73.3)', 'Primera sesión. Carga académica elevada.', '2026-01-28', 1, NULL),
(8, 3, 'Asistió', 'Estrés académico (Z73.3)', 'Se trabajan técnicas de estudio y agenda.', '2026-02-11', 2, NULL),
(9, 4, 'Asistió', 'Trastorno adaptativo (F43.2)', 'Primera sesión. Dificultad de adaptación universitaria.', '2026-01-14', 1, NULL),
(10, 4, 'Asistió', 'Trastorno adaptativo (F43.2)', 'Mejora en relaciones sociales.', '2026-01-28', 2, NULL),
(11, 4, 'Faltó', 'Trastorno adaptativo (F43.2)', 'No se presentó sin aviso.', '2026-02-11', 3, NULL),
(12, 4, 'Asistió', 'Trastorno adaptativo (F43.2)', 'Retoma proceso. Estable.', '2026-03-10', 4, NULL),
(13, 9, 'Asistió', 'Trastorno de ansiedad (F41.9)', 'Ansiedad ante exposiciones orales.', '2025-09-10', 1, NULL),
(14, 9, 'Asistió', 'Trastorno de ansiedad (F41.9)', 'Técnicas de relajación. Exposición gradual.', '2025-09-24', 2, NULL),
(15, 13, 'Asistió', 'Estres', 'Demaciados proyectos finales', '2026-03-22', 1, NULL),
(16, 13, 'Asistió', 'Estres', 'Demaciados Proyectos', '2026-03-22', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario_a` int(11) NOT NULL,
  `Matricula` varchar(20) NOT NULL COMMENT 'Matrícula universitaria — usada para login',
  `Nombre` varchar(100) NOT NULL,
  `Sexo` enum('Masculino','Femenino','Otro') NOT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Carrera` varchar(100) DEFAULT NULL,
  `Turno` enum('Matutino','Vespertino','Mixto') DEFAULT NULL,
  `Cuatrimestre` int(11) DEFAULT NULL,
  `Grupo` varchar(10) DEFAULT NULL,
  `Num_Tel` varchar(15) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario_a`, `Matricula`, `Nombre`, `Sexo`, `Edad`, `Carrera`, `Turno`, `Cuatrimestre`, `Grupo`, `Num_Tel`, `Correo`, `Contrasena`, `Rol`, `Fecha_Registro`) VALUES
(1, '2024-ISC-001', 'Ana Sofía Morales García', 'Femenino', 20, 'ISC', 'Matutino', 3, '3A', '4771001001', 'ana.morales@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(2, '2024-LAE-002', 'Carlos Iván Ruiz Pérez', 'Masculino', 22, 'LAE', 'Vespertino', 5, '5B', '4771001002', 'carlos.ruiz@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(3, '2024-ENF-003', 'Laura Valentina Vega Torres', 'Femenino', 19, 'ENF', 'Matutino', 2, '2C', '4771001003', 'laura.vega@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(4, '2025-GAS-004', 'José Manuel Hernández Luna', 'Masculino', 21, 'GAS', 'Vespertino', 1, '1D', '4771001004', 'jose.hernandez@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(5, '2024-ISC-005', 'Patricia Elena Soto Reyes', 'Femenino', 23, 'ISC', 'Matutino', 6, '6A', '4771001005', 'patricia.soto@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(6, '2025-LAE-006', 'Miguel Ángel Torres Díaz', 'Masculino', 20, 'LAE', 'Matutino', 2, '2B', '4771001006', 'miguel.torres@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(7, '2025-DES-007', 'Daniela Fernández Ramos', 'Femenino', 18, 'DES', 'Vespertino', 1, '1A', '4771001007', 'daniela.fernandez@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(8, '2023-ISC-008', 'Roberto González Martínez', 'Masculino', 24, 'ISC', 'Vespertino', 7, '7B', '4771001008', 'roberto.gonzalez@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(9, '2023-ENF-009', '123456', 'Femenino', 28, 'ISC - Ing. en Sistemas Computacionales', 'Matutino', 5, '5A', '4771001009', 'alejandra.ramirez@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(10, '2026-GAS-010', 'Luis Eduardo Mendoza Silva', 'Masculino', 19, 'GAS', 'Matutino', 2, '2D', '4771001010', 'luis.mendoza@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(11, '2025-LAE-011', 'Gabriela Flores Jiménez', 'Femenino', 22, 'LAE', 'Vespertino', 5, '5A', '4771001011', 'gabriela.flores@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(12, '2024-ISC-012', 'Eduardo Vargas López', 'Masculino', 20, 'ISC', 'Matutino', 3, '3C', '4771001012', 'eduardo.vargas@utn.edu.mx', '123456', 'usuario', '2026-03-22 03:54:08'),
(13, '24605001', 'Andrea Chavez', 'Femenino', 18, 'Procesos industriales', 'Matutino', 4, '8', '63158988', 'andrea@gamil.com', '123456', 'usuario', '2026-03-22 06:25:08'),
(14, '', 'Ana Lopez', 'Femenino', 18, 'Mecatronica', 'Vespertino', 4, '5', '6311139739', 'anita@gmail.com', '$2y$10$RHv8SN5IhLljx3l79fob/OUoCy1qsRm4QHjSWnZKWpKm/DC3qVPqO', 'usuario', '2026-03-23 02:34:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculacion`
--

CREATE TABLE `vinculacion` (
  `Folio` int(11) NOT NULL,
  `idUsuario_m` int(11) NOT NULL,
  `idUsuario_a` int(11) NOT NULL,
  `motivo` text DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vinculacion`
--

INSERT INTO `vinculacion` (`Folio`, `idUsuario_m`, `idUsuario_a`, `motivo`, `fecha`) VALUES
(1, 2, 1, 'Alumno reportado por bajo rendimiento académico y ausentismo', '2026-02-01'),
(2, 3, 2, 'Canalización por tutor — detecta signos de estrés elevado', '2026-02-10'),
(3, 2, 3, 'Alumno referido por maestro — dificultades de adaptación', '2026-01-22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`idHorario`),
  ADD UNIQUE KEY `uk_horario` (`fecha`,`hora`),
  ADD KEY `fk_cal_cuatri` (`idCuatri`);

--
-- Indices de la tabla `canalizados`
--
ALTER TABLE `canalizados`
  ADD PRIMARY KEY (`idCanalizacion`),
  ADD KEY `fk_canal_usuario` (`idUsuario`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`Folio`),
  ADD KEY `fk_cita_usuario` (`idUsuario`),
  ADD KEY `fk_cita_cuatri` (`idCuatri`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idCargo`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`idExpediente`),
  ADD UNIQUE KEY `uk_exp_usuario` (`idUsuario`);

--
-- Indices de la tabla `maestros`
--
ALTER TABLE `maestros`
  ADD PRIMARY KEY (`idUsuario_m`),
  ADD UNIQUE KEY `No_Empleado` (`No_Empleado`),
  ADD UNIQUE KEY `uk_no_empleado` (`No_Empleado`);

--
-- Indices de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  ADD PRIMARY KEY (`idCuatri`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`Folio`),
  ADD KEY `fk_ses_usuario` (`idUsuario`),
  ADD KEY `fk_ses_cita` (`idCita`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario_a`),
  ADD UNIQUE KEY `Matricula` (`Matricula`),
  ADD UNIQUE KEY `uk_matricula` (`Matricula`);

--
-- Indices de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  ADD PRIMARY KEY (`Folio`),
  ADD KEY `fk_vinc_maestro` (`idUsuario_m`),
  ADD KEY `fk_vinc_alumno` (`idUsuario_a`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `idHorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `canalizados`
--
ALTER TABLE `canalizados`
  MODIFY `idCanalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idCargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `idExpediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `maestros`
--
ALTER TABLE `maestros`
  MODIFY `idUsuario_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  MODIFY `idCuatri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD CONSTRAINT `fk_cal_cuatri` FOREIGN KEY (`idCuatri`) REFERENCES `periodo_escolar` (`idCuatri`) ON DELETE SET NULL;

--
-- Filtros para la tabla `canalizados`
--
ALTER TABLE `canalizados`
  ADD CONSTRAINT `fk_canal_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario_a`) ON DELETE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_cita_cuatri` FOREIGN KEY (`idCuatri`) REFERENCES `periodo_escolar` (`idCuatri`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cita_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario_a`) ON DELETE CASCADE;

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `fk_exp_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario_a`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `fk_ses_cita` FOREIGN KEY (`idCita`) REFERENCES `citas` (`Folio`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_ses_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario_a`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  ADD CONSTRAINT `fk_vinc_alumno` FOREIGN KEY (`idUsuario_a`) REFERENCES `usuarios` (`idUsuario_a`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vinc_maestro` FOREIGN KEY (`idUsuario_m`) REFERENCES `maestros` (`idUsuario_m`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
