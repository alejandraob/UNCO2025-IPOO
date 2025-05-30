<?php
class Cliente {
    private $nroCliente;
    private $nombre;
    private $apellido;
    private $tipoDni;
    private $dni;
    private $telefono;

    // Constructor
    public function __construct($nroCliente, $nombre, $apellido,$tipoDni, $dni, $telefono) {
        $this->nroCliente = $nroCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->tipoDni = $tipoDni;
        $this->dni = $dni;
        $this->telefono = $telefono;
    }
    // Getters
    public function getNroCliente() {
        return $this->nroCliente;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getTipoDni() {
        return $this->tipoDni;
    }
    public function getDni() {
        return $this->dni;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    // Setters
    public function setNroCliente($nroCliente) {
        $this->nroCliente = $nroCliente;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setTipoDni($tipoDni) {
        $this->tipoDni = $tipoDni;
    }
    public function setDni($dni) {
        $this->dni = $dni;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    // ToString usando los getters
    public function __toString() {
        return "Cliente: " . $this->getNroCliente() . ", Nombre: " . $this->getNombre() . 
               ", Apellido: " . $this->getApellido() . ", DNI: " . $this->getDni() . 
               ", Teléfono: " . $this->getTelefono();
    }
}