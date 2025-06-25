
--
-- Base de datos: `bdviajes`
--
CREATE DATABASE IF NOT EXISTS `bdviajes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bdviajes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` bigint(20) NOT NULL,
  `enombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edireccion` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `enombre`, `edireccion`) VALUES
(1, 'AltoViaje', 'Calle Falsa 123'),
(2, 'Rueda por el Mundo', 'Flores 123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajero`
--

CREATE TABLE `pasajero` (
  `idpasajero` bigint(20) NOT NULL,
  `pdocumento` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pnombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `papellido` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ptelefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pasajero`
--

INSERT INTO `pasajero` (`idpasajero`, `pdocumento`, `pnombre`, `papellido`, `ptelefono`) VALUES
(1, '36123456', 'Leandro', 'Perez', 2147483647),
(2, '47899666', 'Lucifer', 'Mu\0oz', 266147852),
(3, '36159987', 'Monuel', 'Llamas', 2998756),
(4, '35159413', 'Lucia', 'Menendez', 299487445),
(5, '35852741', 'Lurdes', 'Godinez', 199456321),
(6, '26147852', 'Mirtha', 'Liniers', 366147852);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `rnumeroempleado` bigint(20) NOT NULL,
  `rnumerolicencia` bigint(20) DEFAULT NULL,
  `rnombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rapellido` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`rnumeroempleado`, `rnumerolicencia`, `rnombre`, `rapellido`) VALUES
(1, 789, 'Raul', 'Rey'),
(2, 369, 'Facundo', 'Espinoza'),
(3, 159, 'Roxana', 'Alvarez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idviaje` bigint(20) NOT NULL,
  `vdestino` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vcantmaxpasajeros` int(11) DEFAULT NULL,
  `idempresa` bigint(20) DEFAULT NULL,
  `rnumeroempleado` bigint(20) DEFAULT NULL,
  `vimporte` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idviaje`, `vdestino`, `vcantmaxpasajeros`, `idempresa`, `rnumeroempleado`, `vimporte`) VALUES
(1, 'Bariloche', 20, 1, 2, 85000),
(2, 'Bariloche', 20, 2, 3, 9500),
(3, 'San Martin', 15, 1, 2, 98500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje_pasajero`
--

CREATE TABLE `viaje_pasajero` (
  `idviaje` bigint(20) NOT NULL,
  `idpasajero` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `viaje_pasajero`
--

INSERT INTO `viaje_pasajero` (`idviaje`, `idpasajero`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD PRIMARY KEY (`idpasajero`),
  ADD UNIQUE KEY `pdocumento` (`pdocumento`),
  ADD KEY `documento` (`pdocumento`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`rnumeroempleado`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`idviaje`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `numeroempleado` (`rnumeroempleado`);

--
-- Indices de la tabla `viaje_pasajero`
--
ALTER TABLE `viaje_pasajero`
  ADD PRIMARY KEY (`idviaje`,`idpasajero`),
  ADD UNIQUE KEY `idviaje` (`idviaje`,`idpasajero`),
  ADD KEY `idpasajero` (`idpasajero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  MODIFY `idpasajero` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `rnumeroempleado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idviaje` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `viaje_ibfk_2` FOREIGN KEY (`rnumeroempleado`) REFERENCES `responsable` (`rnumeroempleado`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `viaje_pasajero`
--
ALTER TABLE `viaje_pasajero`
  ADD CONSTRAINT `viaje_pasajero_ibfk_1` FOREIGN KEY (`idviaje`) REFERENCES `viaje` (`idviaje`) ON DELETE CASCADE,
  ADD CONSTRAINT `viaje_pasajero_ibfk_2` FOREIGN KEY (`idpasajero`) REFERENCES `pasajero` (`idpasajero`) ON DELETE CASCADE;
COMMIT;
