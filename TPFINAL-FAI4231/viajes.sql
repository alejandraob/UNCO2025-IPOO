
--
-- Base de datos: `bdviajes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` bigint(20) NOT NULL,
  `enombre` varchar(150) DEFAULT NULL,
  `edireccion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `enombre`, `edireccion`) VALUES
(1, 'ALTOviaje', 'Calle Falsa 123'),
(2, 'LaTreveling', 'Dos Lunas 123'),
(3, 'Porque Me lo Merezco', 'dios proveera 123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajero`
--

CREATE TABLE `pasajero` (
  `pdocumento` varchar(15) NOT NULL,
  `pnombre` varchar(150) DEFAULT NULL,
  `papellido` varchar(150) DEFAULT NULL,
  `ptelefono` varchar(20) DEFAULT NULL,
  `idviaje` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pasajero`
--

INSERT INTO `pasajero` (`pdocumento`, `pnombre`, `papellido`, `ptelefono`, `idviaje`) VALUES
('29999608', 'Maria', 'Lorenzo', '011258741', 1),
('36147896', 'Loreto', 'Gimenez', '299306999', 1),
('45123789', 'Pedro', 'Stefanini', '360147852', 1),
('45888111', 'Sofia', 'Menedez', '255258963', 1),
('48741200', 'Leandro', 'Lopez', '011789456', 2),
('50147236', 'Carlos', 'Sosa', '299666852', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `rnumeroempleado` bigint(20) NOT NULL,
  `rnumerolicencia` bigint(20) DEFAULT NULL,
  `rnombre` varchar(150) DEFAULT NULL,
  `rapellido` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`rnumeroempleado`, `rnumerolicencia`, `rnombre`, `rapellido`) VALUES
(1, 365, 'Raul', 'Romero'),
(2, 1489, 'Lisa', 'Lamora'),
(3, 78963, 'Libesio', 'Lore'),
(4, 888, 'Pedro', 'Ramirez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idviaje` bigint(20) NOT NULL,
  `vdestino` varchar(150) DEFAULT NULL,
  `vcantmaxpasajeros` int(11) DEFAULT NULL,
  `idempresa` bigint(20) DEFAULT NULL,
  `rnumeroempleado` bigint(20) DEFAULT NULL,
  `vimporte` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idviaje`, `vdestino`, `vcantmaxpasajeros`, `idempresa`, `rnumeroempleado`, `vimporte`) VALUES
(1, 'Bariloche', 20, 1, 1, 9500),
(2, 'San MArtin', 10, 1, 3, 8500),
(3, 'San Rafael', 5, 2, 2, 75000);

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
  ADD PRIMARY KEY (`pdocumento`),
  ADD KEY `idviaje` (`idviaje`);

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
  ADD KEY `rnumeroempleado` (`rnumeroempleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `rnumeroempleado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idviaje` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD CONSTRAINT `pasajero_ibfk_1` FOREIGN KEY (`idviaje`) REFERENCES `viaje` (`idviaje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viaje_ibfk_2` FOREIGN KEY (`rnumeroempleado`) REFERENCES `responsable` (`rnumeroempleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
