<?php

/*

De los planes se almacena un código, los canales que ofrece, el importe y si incluye MG de datos o no. 
Por defecto se asume que el plan incluye 100 MG.

 */
class Plan{
    private $codigo;
    private $canales;
    private $importe;
    private $mgDatos;
    // Constructor
    public function __construct($codigo, $canales, $importe, $mgDatos = 100) {
        $this->codigo = $codigo;
        $this->canales = $canales;
        $this->importe = $importe;
        $this->mgDatos = $mgDatos;
    }
    // Getters
    public function getCodigo() {
        return $this->codigo;
    }
    public function getCanales() {
        return $this->canales;
    }
    public function getImporte() {
        return $this->importe;
    }
    public function getMgDatos() {
        return $this->mgDatos;
    }
    // Setters
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    public function setCanales(array $canales) {
        $this->canales = $canales;
    }
    public function setImporte($importe) {
        $this->importe = $importe;
    }
    public function setMgDatos($mgDatos) {
        $this->mgDatos = $mgDatos;
    }

    //ToString usando los getters
    public function __toString() {
        $canalesStr = array_map(fn($c) => $c->getTipo(), $this->getCanales());
        return "Código: " . $this->getCodigo() . 
               ", Canales: " . implode(", ", $canalesStr) . 
               ", Importe: $" . $this->getImporte() . 
               ", MG Datos: " . $this->getMgDatos() . "MB";
    }

}