<?php

/**
 * Validar el nombre y apellido del cliente.
 * @param string $nombre Nombre o apellido del cliente.
 * @throws Exception Si el nombre o apellido no es válido.
 * 
 */
 function validarIdentificacion($idCliente) {
    if (empty($idCliente)) {
        throw new Exception("El campo no puede estar vacío.");
    }
    if (!is_string($idCliente)) {
        throw new Exception("El campo debe ser una cadena de texto.");
    }
    if (strlen($idCliente) < 2) {
        throw new Exception("El campo debe tener al menos 2 caracteres.");
    }
    if (strlen($idCliente) > 50) {
        throw new Exception("El campo no puede tener más de 50 caracteres.");
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $idCliente)) {
        throw new Exception("El campo solo puede contener letras y espacios.");
    }
    if (preg_match("/\d/", $idCliente)) {
        throw new Exception("El campo no puede contener números.");
    }
    if (preg_match("/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/", $idCliente)) {
        throw new Exception("El campo no puede contener caracteres especiales.");
    }
};

/**
 * Validar si es array
 * @param array $array Colección a validar.
 */
function validarArray($array) {
    if (!is_array($array)) {
        throw new Exception("El parámetro debe ser un array.");
    }

};

/**
 * Validar fecha
 */
function validarFecha($fecha) {
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!$fechaObj || $fechaObj->format('Y-m-d') !== $fecha) {
        throw new Exception("La fecha debe estar en el formato YYYY-MM-DD.");
    }
    // Verifica si la fecha no es futura
    $fechaActual = new DateTime();
    if ($fechaObj > $fechaActual) {
        throw new Exception("La fecha no puede ser futura.");
    }
}