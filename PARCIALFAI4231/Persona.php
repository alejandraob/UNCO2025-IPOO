<?php

class Persona{
 /*
En la clase Persona se registra la siguiente información: nombre, apellido, dirección, mail y teléfono.  */  
private $nombre;
private $apellido;
private $direccion;
private $mail;
private $telefono;

// Constructor de la clase Persona
public function __construct($nombre, $apellido, $direccion, $mail, $telefono) {
    $this->setNombre($nombre);
    $this->setApellido($apellido);
    $this->setDireccion($direccion);
    $this->setMail($mail);
    $this->setTelefono($telefono);
}


// Métodos de acceso (getters y setters)
public function getNombre() {
    return $this->nombre;
}
public function setNombre($nombre) {
    $this->nombre = $nombre;
}
public function getApellido() {
    return $this->apellido;
}
public function setApellido($apellido) {
    $this->apellido = $apellido;
}
public function getDireccion() {
    return $this->direccion;
}
public function setDireccion($direccion) {
    $this->direccion = $direccion;
}
public function getMail() {
    return $this->mail;
}
public function setMail($mail) {
    $this->mail = $mail;
}
public function getTelefono() {
    return $this->telefono;
}
public function setTelefono($telefono) {
    $this->telefono = $telefono;
}

//Metodo toString
public function __toString() {
    return "Nombre: " . $this->getNombre() . "\n" .
           "Apellido: " . $this->getApellido() . "\n" .
           "Dirección: " . $this->getDireccion() . "\n" .
           "Mail: " . $this->getMail() . "\n" .
           "Teléfono: " . $this->getTelefono() . "\n";
}
}