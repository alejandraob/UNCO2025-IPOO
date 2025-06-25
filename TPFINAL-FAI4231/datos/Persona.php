<?php
class Persona {
    protected $idpersona;
    protected $nombre;
    protected $apellido;

    public function __construct() {
        $this->idpersona = 0;
        $this->nombre = '';
        $this->apellido = '';
    }

    public function setIdPersona($id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID debe ser numérico");
        }
        $this->idpersona = $id;
    }

    public function getIdPersona() {
        return $this->idpersona;
    }

    public function setNombre($nombre) {
        if (empty($nombre)) {
            throw new InvalidArgumentException("El nombre no puede estar vacío");
        }
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setApellido($apellido) {
        if (empty($apellido)) {
            throw new InvalidArgumentException("El apellido no puede estar vacío");
        }
        $this->apellido = $apellido;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function cargarDatos($id, $nombre, $apellido) {
        $this->setIdPersona($id);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }
    public function __toString()
    {
        return "ID: " . $this->getIdPersona() . " - " . $this->getApellido() . ", " . $this->getNombre();
    }
}
