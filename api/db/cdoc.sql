-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2024 a las 20:52:09
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cdoc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_sistema`
--

CREATE TABLE `bitacora_sistema` (
  `id` int(11) NOT NULL,
  `motodo_solicitud` text NOT NULL,
  `ip_cliente` text NOT NULL,
  `nombre_servidor` text NOT NULL,
  `ruta_script` text NOT NULL,
  `user_agent` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora_sistema`
--

INSERT INTO `bitacora_sistema` (`id`, `motodo_solicitud`, `ip_cliente`, `nombre_servidor`, `ruta_script`, `user_agent`, `fecha`, `id_usuario`) VALUES
(4, 'POST', '::1', 'localhost', '/CDoc/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-02 18:30:40', 11),
(5, 'POST', '::1', 'localhost', '/CDoc/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-02 18:30:47', 11),
(6, 'POST', '::1', 'localhost', '/CDoc/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-02 18:31:10', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinatarios`
--

CREATE TABLE `destinatarios` (
  `id_destinatario` int(11) NOT NULL,
  `nombre_des` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `destinatarios`
--

INSERT INTO `destinatarios` (`id_destinatario`, `nombre_des`) VALUES
(1, 'SECTOR CABUDARE'),
(2, 'INFRAESTRUCTURA Y SERVICIOS INTERNOS'),
(3, 'ALMACEN'),
(4, 'PRESUPUESTO'),
(5, 'TESORERIA'),
(6, 'CONTABILIDAD'),
(7, 'SERVICIO MEDICO'),
(8, 'VIATICOS Y PASAJES'),
(9, 'SEGURIDAD'),
(10, 'INFORMATICA'),
(11, 'SECCION BENEFICIOS SOCIO-ECONOMICOS'),
(12, 'BIENES NACIONALES'),
(13, 'COORDINACION RECURSOS HUMANOS'),
(14, 'DIVISION DE RECAUDACION'),
(15, 'DIVISION JURIDICA TRIBUTARIA'),
(16, 'DIVISION SUMARIO ADMINISTRATIVO'),
(17, 'DIVISION DE FISCALIZACION'),
(18, 'DIVISION DE  CONTRIBUYENTES ESPECIALES'),
(19, 'DIVISION DE TRAMITACIONES'),
(20, 'DIVISION ASISTENCIA AL CONTRIBUYENTE'),
(21, 'GERENCIA REGIONAL DE TRIBUTOS INTERNOS'),
(22, 'DIVISION DE TESORERIA'),
(23, 'DIVULGACION TRIBUTARIA'),
(24, 'DIVISION DE ADMINISTRACION'),
(25, 'SECCION DE DEPORTES Y CULTURA'),
(26, 'CAJUFINANZAS'),
(27, 'RESGUARDO NACIONAL TRIBUTARIO'),
(28, 'SEGUROS LA PREVISORA'),
(29, 'SEGUROS CARABOBO'),
(30, 'BANCO INDUSTRIAL DE VENEZUELA'),
(31, 'JUZGADO DE MENORES'),
(32, 'INTENDENCIA NACIONAL DE TRIBUTOS INTERNOS'),
(33, 'JEFE COORD DE RRHH RCO'),
(34, 'CORAL'),
(35, 'CONCULTURA'),
(36, 'SEGURO SOCIAL OBLIGATORIO IVSS'),
(37, 'GERENCIA FINANCIERA ADMINISTRATIVA'),
(38, 'GERENCIA DE RECURSOS HUMANOS / ORH CARACAS'),
(39, 'COLEGIO CONTADORES'),
(40, 'COLEGIO DE ADMINISTRADORES'),
(41, 'CATARCO HACIENDA'),
(42, 'SUNEP HACIENDA'),
(43, 'ASOCIACION DE PROF. Y TECNICOS'),
(44, 'SECTOR PUNTO FIJO'),
(45, 'SECTOR SAN FELIPE'),
(46, 'SECTOR CORO'),
(47, 'SECTOR ACARIGUA'),
(48, 'SECTOR CARORA'),
(49, 'SECTOR TUCACAS'),
(50, 'SECTOR QUIBOR'),
(51, 'UNIDAD CHIVACOA'),
(52, 'UNIDAD CHURUGUARA'),
(53, 'UNIDAD EL TOCUYO'),
(54, 'UNIDAD GUANARE'),
(55, 'UNIDAD NIRGUA'),
(56, 'UNIDAD DE SUJETOS PASIVOS ESPECIALES PUNTO FIJO'),
(57, 'EXPEDIENTE FUNCIONARIO'),
(58, 'EXPEDIENTE CONTRATADO'),
(59, 'DIVISION DE RELACIONES LABORALES'),
(60, 'DIRECTOR OFIC. NAC. SEGURIDAD PROTEC. Y CUSTODIA'),
(61, 'ARCHIVO'),
(62, 'PASANTE'),
(63, 'FUNCIONARIO'),
(64, 'CONTRATADO'),
(65, 'CENTRO DE ESTUDIOS FISCALES'),
(66, 'MINISTERIO DE FINANZAS'),
(67, 'GERENCIA REGION CAPITAL'),
(68, 'GERENTE GENERAL DE ADMINISTRACION'),
(69, 'EXTERNO'),
(70, 'EXPEDIENTE OBRERO'),
(71, 'OBRERO'),
(72, 'GERENTE DE LEGISLACION Y SUPERVISION'),
(73, 'TODO EL PERSONAL RCO'),
(74, 'SALON DE USOS MULTIPLES'),
(75, 'COMPRAS Y CONTRATACION'),
(76, 'SEGUROS HORIZONTE'),
(77, 'SECCION SEGURO SOCIAL'),
(78, 'SECCION PERSONAL OBRERO'),
(79, 'GERENCIA REGIONAL GUAYANA'),
(80, 'GERENCIA REGIONAL NOR ORIENTAL'),
(81, 'GERENCIA ADUANA LAS PIEDRAS PARAGUANA'),
(82, 'GERENCIA GENERAL SERVICIOS JURIDICOS'),
(83, 'GERENCIA REGIONAL LOS ANDES'),
(84, 'SECCION REGISTRO Y CONTROL'),
(85, 'GERENCIA REGION CENTRAL'),
(86, 'GERENCIA ADUANA PRINCIPAL AEREA DE MAIQUETIA'),
(87, 'GERENCIA DE TELECOMUNICACIONES'),
(88, 'GERENCIA DE INFRAESTRUCTURA TECNOLOGICA DE DATOS'),
(89, 'SUPERINTENDENCIA NACIONAL ADUANERA Y TRIBUTARIA'),
(90, 'GERENCIA DE REGIMENES ADUANEROS'),
(91, 'OFICINA NAC  INVESTIGACION PROTECCION Y CUSTODIA'),
(92, 'ADUANA PRINCIPAL REGION CENTRO OCCIDENTAL'),
(93, 'INPSASEL'),
(94, 'IVSS (SEGURO SOCIAL)'),
(95, 'ASISTENCIA A USUARIOS INTERNOS Y EXTERNOS'),
(96, 'CORREOS ELECTRÓNICOS'),
(97, 'GERENCIA REGIONAL DE CONTRIBUYENTES ESPECIALES'),
(98, 'BANESCO BANCO UNIVERSAL C.A'),
(99, 'SECCION DE INPSASEL RCO'),
(100, 'SEGUROS CONSTITUCIÓN'),
(101, 'DIV. COBRO EJECUTIVO Y MEDIDAS CAUTELARES'),
(102, 'VILMA RIVAS FONDO ADMINISTRATIVO SAAS- HCM'),
(103, 'SECCION VACACIONES'),
(104, 'GERENCIA GRTI RCO'),
(105, 'GERENCIA GENERAL DE GESTION HUMANA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` int(11) NOT NULL,
  `fecha_entrada` date DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `numero_doc` varchar(15) NOT NULL,
  `estatus` varchar(1) DEFAULT NULL,
  `id_remitente` int(11) DEFAULT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documento`, `fecha_entrada`, `fecha_registro`, `descripcion`, `numero_doc`, `estatus`, `id_remitente`, `id_tipo_documento`, `id_usuario`) VALUES
(48, '2024-10-02', '2024-10-02 18:31:10', 'asdsadsa', '32432432', '1', 10, 8, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `accion` text NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_historial`, `accion`, `id_usuario`) VALUES
(28, '02-10-2024 14:31:10 - Registró el documento de entrada con el número de documento: 32432432 / 02-10-2024 14:30:47 - Registró la meta general del mes 10 con un valor: 850 / 02-10-2024 14:30:40 -  Inició sesión en el sistema.', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meta`
--

CREATE TABLE `meta` (
  `id_meta` int(11) NOT NULL,
  `meta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `meta`
--

INSERT INTO `meta` (`id_meta`, `meta`) VALUES
(29, '850');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitentes`
--

CREATE TABLE `remitentes` (
  `id_remitente` int(11) NOT NULL,
  `nombre_rem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `remitentes`
--

INSERT INTO `remitentes` (`id_remitente`, `nombre_rem`) VALUES
(1, 'STI CORO'),
(2, 'SERVICIOS INTERNOS'),
(3, 'ALMACEN'),
(4, 'PRESUPUESTO'),
(5, 'TESORERIA'),
(6, 'CONTABILIDAD'),
(7, 'SECCION DE SERVICIO MEDICO'),
(8, 'RECURSOS HUMANOS'),
(9, 'SEGURIDAD'),
(10, 'INFORMATICA'),
(11, 'GUARDERIA LOS GUARITOS'),
(12, 'DIVISION DE ASISTENCIA AL CONTRIBUYENTE'),
(13, 'DIVISION DE TRAMITACIONES'),
(14, 'DIVISION DE RECAUDACION'),
(15, 'DIVISION JURIDICA TRIBUTARIA'),
(16, 'DIVISION SUMARIO ADMINISTRATIVO'),
(17, 'DIVISION DE FISCALIZACION'),
(18, 'DIVISION DE CONTRIBUYENTES ESPECIALES'),
(19, 'GERENCIA REGIONAL DE TRIBUTOS INTERNOS'),
(20, 'DIVISION DE TESORERIA'),
(21, 'COORDINACION DE DEPORTES'),
(22, 'DIVULGACION TRIBUTARIA'),
(23, 'STI PUNTO FIJO'),
(24, 'DIVISION DE ADMINISTRACION'),
(25, 'DIVISION DE COMPRAS Y CONTRATOS'),
(26, 'STI SAN FELIPE'),
(27, 'GERENCIA JURIDICA TRIBUTARIA'),
(28, 'OFICINA DE AUDITORIA INTERNA'),
(29, 'EXTERNO'),
(30, 'CENTRO DE ESTUDIOS FISCALES'),
(31, 'STI ACARIGUA'),
(32, 'RESGUARDO NACIONAL'),
(33, 'COMPRAS Y CONTRATACIONES'),
(34, 'UTI EL TOCUYO'),
(35, 'COORDINADOR CONTROL DE GESTIÒN'),
(36, 'UTI CHURUGUARA'),
(37, 'UTI GUANARE'),
(38, 'COORDINADOR DE PROYECTO DE MODERNIZACIÒN SENIAT'),
(39, 'SECTOR SAN FELIPE'),
(40, 'STI CARORA'),
(41, 'UTI NIRGUA'),
(42, 'SUNEP -HACIENDA'),
(43, 'INFRAESTRUCTURA Y SERVICIOS INTERNOS'),
(44, 'DIRECTORA GENERAL  DE RECURSOS HUMANOS'),
(45, 'UTI CHIVACOA'),
(46, 'INTENDENTE NACIONAL DE TRIBUTOS INTERNOS'),
(47, 'RESPONSABLE DE REMISIÓN DE PROPUESTAS'),
(48, 'GERENTE GENERAL DE ADMINISTRACIÒN'),
(49, 'DIVISIÒN DE BIENES ADJUDICADOS'),
(50, 'GRTI REGION CAPITAL'),
(51, 'JEFE DIVISIÓN DE TESORERÍA'),
(52, 'VIATICOS Y PASAJES'),
(53, 'JUZGADO DE MENORES'),
(54, 'CATARCO HACIENDA'),
(55, 'BANCO INDUSTRIAL DE VENEZUELA'),
(56, 'SPDEXHO PASS'),
(57, 'GERENCIA DE RECURSOS HUMANOS'),
(58, 'JUBILADO'),
(59, 'ORDEN DE SERVICIO'),
(60, 'AREA DE TECNICA'),
(61, 'SECCION DE REMUNERACIONES'),
(62, 'UTI CHIVACOA'),
(63, 'SECTOR DE TRIBUTOS INTERNOS CORO'),
(64, 'UNIDAD CONTRIB. ESP. PUNTO FIJO'),
(65, 'UNIDAD DE TRIBUTOS INTERNOS  TOCUYO'),
(66, 'CIRCULAR'),
(67, 'AREA DE TESORERIA'),
(68, 'BLINDADOS RCO'),
(69, 'FUNCIONARIO'),
(70, 'PASANTE'),
(71, 'DIVISION DE OPERACIONES ADUANA R.C.O.'),
(72, 'ADUANA REGION CENTRO OCCIDENTAL'),
(73, 'SUPERINTENDENTE TRIBUTOS INTERNOS'),
(74, 'CONTRATADO'),
(75, 'FEDE-UNEP'),
(76, 'DIRECTORA OFIC. DE RELACIONES INSTITUCIONALES'),
(77, 'MINISTERIO DE FINANZAS'),
(78, 'GERENCIA GENERAL DE SERVICIOS JURIDICOS'),
(79, 'GERENTE ADUANA PRINCIPAL DE PUERTO CABELLO'),
(80, 'JUZGADO PRIMERO DE LOS MUNICIPIOS PALAVECINO Y SIM'),
(81, 'CORRESPONDENCIA'),
(82, 'CONCULTURA'),
(83, 'GERENTE DE LEGISLACION Y SUPERVISION'),
(84, 'GERENTE REGION CENTRAL'),
(85, 'GERENTE DE ORGANIZACIÓN'),
(86, 'GOBIERNO DE LARA PROTOCOLO'),
(87, 'SINEP-FINSET'),
(88, 'IVSS'),
(89, 'GERENTE REGION LOS ANDES'),
(90, 'DIRECTOR OFICINA DE PLANIFICACION'),
(91, 'ALCALDIA DE IRIBARREN'),
(92, 'MINISTERIO DEL INTERIOR Y JUSTICIA'),
(93, 'INST. LATINOAMERICANO DE ESTUDIOS GERENCIALES'),
(94, 'GERENTE ADUANA PRINCIPAL LAS PIEDRAS'),
(95, 'COORDINACION DE OBREROS'),
(96, 'UNESR'),
(97, 'MINISTERIO DE LA DEFENSA EJERCITO'),
(98, 'SECCION REGISTRO Y CONTROL'),
(99, 'GERENCIA GENERAL DE INFORMATICA'),
(100, 'DIV. EDUC. TRIBUTARIA Y ASIST. AL CONTRIBUYENTE'),
(101, 'GERENTE FINANCIERO ADMINISTRATIVO'),
(102, 'GERENTE DE RECAUDACION'),
(103, 'BIENES NACIONALES'),
(104, 'GERENCIA DE ADMINISTRACION GENERAL'),
(105, 'DIVISION DE ESPECIES FISCALES'),
(106, 'STI TUCACAS'),
(107, 'OFICINA DE PLANIFICACION Y ORGANIZACIÓN'),
(108, 'SECCION DE BIENESTAR SOCIAL'),
(109, 'GERENCIA DE FISCALIZACION'),
(110, 'GERENCIA  ADUANA PRINCIPAL CENTRO OCCIDENTAL'),
(111, 'SECCION SEGURO SOCIAL'),
(112, 'FISCALIA DECIMASEPTIMA JUDICIAL EDO LARA'),
(113, 'ESCRITO'),
(114, 'STI QUIBOR'),
(115, 'GRTI REGION NOR-ORIENTAL'),
(116, 'AREA DE ARCHIVO GENERAL'),
(117, 'CONTROL DE ASISTENCIA BECA TRABAJO'),
(118, 'STI TUCACAS'),
(119, 'DIVISION DE REGISTRO Y NORMATIVA LEGAL'),
(120, 'ALCALDIA DEL MUNICIPIO PALAVECINO'),
(121, 'SECCION CARRERA TRIBUTARIA'),
(122, 'SINAOP - MF'),
(123, 'MINISTERIO DE RELACIONES EXTERIORES'),
(124, 'SECCION DE PERMISOS Y REPOSOS'),
(125, 'COSERCA'),
(126, 'PASANTE'),
(127, 'ESCUELA NACIONAL DE HACIENDA PUBLICA'),
(128, 'SECCION DE CAPACITACION Y PASANTIAS'),
(129, 'PODER JUDICIAL'),
(130, 'DIRECTOR DE LA OFICINA NAC DE INV,PROTECC Y CUST'),
(131, 'PRODEINCO'),
(132, 'RENAT'),
(133, 'GRTI REGION GUAYANA'),
(134, 'GRTI REGION CENTRAL'),
(135, 'STI CABUDARE'),
(136, 'GERENCIA DE TELECOMUNICACIONES'),
(137, 'UCLA'),
(138, 'UNEFA'),
(139, 'INSTITUTO TEGNOLOGICO ANTONIO JOSE DE SUCRE'),
(140, 'UFT'),
(141, 'OFICIO'),
(142, 'CUFT'),
(143, 'IUJO'),
(144, 'CUAM'),
(145, 'IUTEP'),
(146, 'IUTIRLA'),
(147, 'IUETAEB'),
(148, 'UNIVERSIDAD YACAMBU'),
(149, 'UBV'),
(150, 'GERE'),
(151, 'ADUANA PRINCIPAL LAS PIEDRAS - PARAGUANA.'),
(152, 'CIVEA'),
(153, 'OFICINA DE RELACIONES INSTITUCIONALES'),
(154, 'COORDINADOR DE RECURSOS HUMANOS'),
(155, 'FUNCIONARIO JUBILADO'),
(156, 'PERSONAL EGRESADO'),
(157, 'CORTE SEGUNDA DE LO CONTENCIOSO ADMINISTRATIVO'),
(158, 'OFICINA DE INVESTIGACION, PROTECCION CUSTODIA'),
(159, 'SECCION DE INPSASEL RCO'),
(160, 'PERSONAL OBRERO R.C.O'),
(161, 'DIV. COBRO EJECUTIVO Y MEDIDAS CAUTELARES'),
(162, 'COORDINACION DE RRHH'),
(163, 'COORDINACION DE CULTURA Y DEPORTE'),
(164, 'COORDINACION DE LIQUIDACIONES'),
(165, 'GERENCIA DE TRIBUTOS INTERNOS RCO'),
(166, 'GERENCIA GENERAL DE GESTION HUMANA'),
(167, 'NUCLEOS ALIADAS EN TECNOLOGIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `id_documento` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id_seccion` int(11) NOT NULL,
  `nombre_seccion` text NOT NULL,
  `cantidad_documentos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id_seccion`, `nombre_seccion`, `cantidad_documentos`) VALUES
(2, 'Recursos Humanos', '200'),
(4, 'Bienes Nacionales', '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccionesxmeta`
--

CREATE TABLE `seccionesxmeta` (
  `id_seccionesXmeta` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `id_meta` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seccionesxmeta`
--

INSERT INTO `seccionesxmeta` (`id_seccionesXmeta`, `id_seccion`, `id_meta`, `fecha`) VALUES
(48, 2, 29, '2024-10-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentos`
--

CREATE TABLE `tipos_documentos` (
  `id_tipo_documento` int(11) NOT NULL,
  `nombre_doc` varchar(45) NOT NULL,
  `descripcion_doc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`id_tipo_documento`, `nombre_doc`, `descripcion_doc`) VALUES
(1, 'PERMISOS', ''),
(2, 'REQUERIMIENTO', ''),
(3, 'SINTESIS CURRICULAR', ''),
(4, 'CIRCULAR', ''),
(5, 'MEMORANDUM', ''),
(6, 'SOLICITUD DE PASAJE Y ALOJAMIENTO', ''),
(7, 'SOLICITUD DE PAGO', ''),
(8, 'SOLICITUD DE INGRESO CAJUFINANZAS', ''),
(9, 'COMPROBANTE DE PAGO', ''),
(10, 'ACTA', ''),
(11, 'SINIESTROS SEGURO CONSTITUCIÓN', ''),
(12, 'CHEQUE', ''),
(13, 'RECIBO', ''),
(14, 'RELACION DE VIATICOS', ''),
(15, 'SOLICITUD  Y AUTORIZACION DE PERMISO', ''),
(16, 'MODELO', ''),
(17, 'ESCRITO', ''),
(18, 'SOLICITUD DE CONSTANCIAS DE TRABAJO', ''),
(19, 'GACETA OFICIAL', ''),
(20, 'JUSTIFICACION DE PAGO', ''),
(21, 'INFORME', ''),
(22, 'JUSTIFICACIÓN DE VIÁTICOS', ''),
(23, 'RELACION DE RECIBOS DE PAGOS', ''),
(24, 'JUZGADO DE MENORES', ''),
(25, 'DEPOSITO EN CUENTA', ''),
(26, 'AVISO DE DEBITO', ''),
(27, 'AVISO DE CREDITO', ''),
(28, 'COMPROBANTE DE SERVICIO', ''),
(29, 'COMPROBANTE ALMACEN', ''),
(30, 'NOTIFICACION DISFRUTE DE VACACIONES', ''),
(31, 'RELACION CHEQUES EN CUSTODIA', ''),
(32, 'FACTURA', ''),
(33, 'ORDEN DE SERVICIO', ''),
(34, 'CAJA CHICA', ''),
(35, 'SINTESIS CURRICULAR', ''),
(36, 'COMPROBANTE DE SERVICIO', ''),
(37, 'FORMATO', ''),
(38, 'CONSTANCIAS', ''),
(39, 'TITULOS, CERTIFICADOS, DIPLOMAS', ''),
(40, 'SOBRE CERRADO', ''),
(41, 'RELACION DE CARGOS', ''),
(42, 'NOTIFICACION SUSPENSION DE VACACIONES', ''),
(43, 'LEY PROGRAMA ALIMENTACION', ''),
(44, 'CORREO', ''),
(45, 'CONTROL DE ASISTENCIA BECA TRABAJO', ''),
(46, 'FORMATO DE INCLUSION', ''),
(47, 'FORMATO DE EXCLUSION', ''),
(48, 'SOLICITUD DE CARTA AVAL SEGUROS PREVISORA', ''),
(49, 'SINIESTROS SEGUROS PREVISORA', ''),
(50, 'SINIESTRO SEGUROS CARABOBO', ''),
(51, 'SOLICITUD FASE MATERNAL', ''),
(52, 'SOLICITUD DE BECAS, UTILES ESCOLARES', ''),
(53, 'SOLICITUD DE UTILES ESCOLARES', ''),
(54, 'SOLICITUD CARTA AVAL SEGUROS CARABOBO', ''),
(55, 'FE DE VIDA MPPPFE', ''),
(56, 'FE DE VIDA SENIAT', ''),
(57, 'POLIZA DE VIDA', ''),
(58, 'EXPEDIENTE', ''),
(59, 'DOCUMENTO', ''),
(60, 'PROVIDENCIA ADMINISTRATIVA', ''),
(61, 'SOLICITUD DE AYUDA POR FALLECIMIENTO', ''),
(62, 'SOLCITUD DE AYUDA POR NACIMIENTO Y/O MATRIMON', ''),
(63, 'INGRESO', ''),
(64, 'CONSTANCIAS  DE TRABAJO', ''),
(65, 'CONTROL DE ASISTENCIA', ''),
(66, 'SINIESTROS SEGUROS HORIZONTE', ''),
(67, 'SOLICITUD DE CARTA AVAL SEGUROS HORIZONTE', ''),
(68, 'CONSULTA MEDICA', ''),
(69, 'REPOSO MEDICO', ''),
(70, 'CESE DE FUNCIONES', ''),
(71, 'TRASLADO', ''),
(72, 'DESIGNACION', ''),
(73, 'SEDI', ''),
(74, 'CARTA POSTULACION PASANTIAS', ''),
(75, 'OFICIO', ''),
(76, 'RESUMEN MENSUAL DE ASISTENCIA', ''),
(77, 'SOLICITUD ANTICIPO DE PRESTACION DE ANTIGÜEDA', ''),
(78, 'CERTIFICADO', ''),
(79, 'CUENTA INDIVIDUAL IVSS', ''),
(80, 'DOCUMENTO IVSS', ''),
(81, 'CORREO IMPRESO', ''),
(82, 'EVALUACION DE EFICIENCIA PERSONAL OBRERO', ''),
(83, 'CARNET INSTITUCIONAL', ''),
(84, 'CONSTANCIA  CULMINACION  PASANTIAS', ''),
(85, 'ACEPTACION DE PASANTIAS', ''),
(86, 'SOLICITUD DE CARTA AVAL ORH CARACAS', ''),
(87, 'SOLICITUD DE REEMBOLSO ORH CARACAS', ''),
(88, 'CORREO ELECTRONICO', ''),
(89, 'LLAMADAS TELEFONICA', ''),
(90, 'ASISTENCIA Y TRAMITE PERSONAL', ''),
(91, 'SOLICITUD DE VACACIONES', ''),
(92, 'EGRESADO', ''),
(93, 'ACTIVIDAD CULTURAL', ''),
(94, 'ACTIVIDAD DEPORTIVA', ''),
(95, 'SISVAC', ''),
(96, 'INFORME', ''),
(97, 'LIQUIDACION DE PRESTACIONES SOCIALES', ''),
(98, 'DECLARACION JURADA DE PATRIMONIO', ''),
(99, 'SOLICITUD DE CARNÉ INSTITUCIONAL', ''),
(100, 'PRIMA PROFESIONAL', ''),
(101, 'SISTEMA CAPTA HUELLA', ''),
(102, 'FIDEICOMISO', ''),
(103, 'ANTECEDENTES DE SERVICIOS', ''),
(104, 'NOTIFICACION DE VACACIONES', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_login`
--

CREATE TABLE `tokens_login` (
  `id` int(11) NOT NULL,
  `has` text NOT NULL,
  `fecha` datetime NOT NULL,
  `vence` datetime NOT NULL,
  `rol` text NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tokens_login`
--

INSERT INTO `tokens_login` (`id`, `has`, `fecha`, `vence`, `rol`, `id_usuario`) VALUES
(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjZWR1bGEiOiIyODA1NTY1NSIsImNsYXZlIjoiMTIzNDU2IiwiaWRfdXN1YXJpbyI6IjExIiwiaWF0IjoxNzI3ODkzNzgwLCJleHAiOjE3Mjc5ODAxODB9.6j1sMxksuB8OsHEy3_wEh74Ugm9toeRVptQkigO05Vc', '2024-10-02 20:29:40', '2024-10-03 20:29:40', 'Administrador', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` varchar(12) NOT NULL,
  `nombres` text NOT NULL,
  `apellidos` text NOT NULL,
  `rol` varchar(20) NOT NULL,
  `sexo` varchar(9) NOT NULL,
  `contrasena` text NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `estatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `rol`, `sexo`, `contrasena`, `id_seccion`, `estatus`) VALUES
(11, '28055655', 'Cesar', 'Vides', 'Administrador', 'Masculino', '$2y$10$QpXksD1NBxJlbRCWiMnxmOoAjzkqnyOg1IpmWQEVQjSQo493X3Da2', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora_sistema`
--
ALTER TABLE `bitacora_sistema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `destinatarios`
--
ALTER TABLE `destinatarios`
  ADD PRIMARY KEY (`id_destinatario`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_tipo_documento` (`id_tipo_documento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id_meta`);

--
-- Indices de la tabla `remitentes`
--
ALTER TABLE `remitentes`
  ADD PRIMARY KEY (`id_remitente`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_destinatario` (`id_destinatario`),
  ADD KEY `id_documento` (`id_documento`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id_seccion`);

--
-- Indices de la tabla `seccionesxmeta`
--
ALTER TABLE `seccionesxmeta`
  ADD PRIMARY KEY (`id_seccionesXmeta`),
  ADD KEY `id_seccion` (`id_seccion`),
  ADD KEY `id_meta` (`id_meta`);

--
-- Indices de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `tokens_login`
--
ALTER TABLE `tokens_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora_sistema`
--
ALTER TABLE `bitacora_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `destinatarios`
--
ALTER TABLE `destinatarios`
  MODIFY `id_destinatario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `meta`
--
ALTER TABLE `meta`
  MODIFY `id_meta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `remitentes`
--
ALTER TABLE `remitentes`
  MODIFY `id_remitente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `seccionesxmeta`
--
ALTER TABLE `seccionesxmeta`
  MODIFY `id_seccionesXmeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `tokens_login`
--
ALTER TABLE `tokens_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora_sistema`
--
ALTER TABLE `bitacora_sistema`
  ADD CONSTRAINT `bitacora_sistema_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `remitentes` (`id_remitente`),
  ADD CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipos_documentos` (`id_tipo_documento`),
  ADD CONSTRAINT `documentos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id_documento`),
  ADD CONSTRAINT `salidas_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `destinatarios` (`id_destinatario`);

--
-- Filtros para la tabla `seccionesxmeta`
--
ALTER TABLE `seccionesxmeta`
  ADD CONSTRAINT `seccionesxmeta_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones` (`id_seccion`),
  ADD CONSTRAINT `seccionesxmeta_ibfk_2` FOREIGN KEY (`id_meta`) REFERENCES `meta` (`id_meta`);

--
-- Filtros para la tabla `tokens_login`
--
ALTER TABLE `tokens_login`
  ADD CONSTRAINT `tokens_login_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones` (`id_seccion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
