<?php 
/*
De los canales se conoce el tipo de canal, importe y si es HD o no. Algunos ejemplos de tipos de canal son: noticias, 
interés general, musical, deportivo, películas, educativo, infantil, educativo infantil, aventura.
*/
class Canal{

    private $tipo;
    private $importe;
    private $esHD;

    // Constructor
    public function __construct($tipo, $importe, $esHD = false) {
        $this->tipo = $tipo;
        $this->importe = $importe;
        $this->esHD = $esHD;
    }

    // Getters
    public function getTipo() {
        return $this->tipo;
    }

    public function getImporte() {
        return $this->importe;
    }

    public function isEsHD() {
        return $this->esHD;
    }

    // Setters
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
    }

    public function setEsHD($esHD) {
        $this->esHD = $esHD;
    }

    // ToString usando los getters
    public function __toString() {
        return "Tipo: " . $this->getTipo() . 
               " | Importe: $" . $this->getImporte() . 
               " | HD: " . ($this->isEsHD() ? "Sí" : "No");
    }
}