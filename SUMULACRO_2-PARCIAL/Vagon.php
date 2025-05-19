<?php 
class Vagon{
    /*
        1. Se registra la siguiente información: año de instalación, largo, ancho, peso del vagón vacío.
    
    */

    private $anioInstalacion;
    private $largo;
    private $ancho;
    private $pesoVacio;

    // Constructor con gettesters y setters
    public function __construct($anioInstalacion, $largo, $ancho, $pesoVacio){
        $this->setAnioInstalacion($anioInstalacion);
        $this->setLargo($largo);
        $this->setAncho($ancho);
        $this->setPesoVacio($pesoVacio);
    }
    // Getters y setters
    public function getAnioInstalacion(){
        return $this->anioInstalacion;
    }
    public function setAnioInstalacion($anioInstalacion){
        if(is_numeric($anioInstalacion) && $anioInstalacion > 0){
            $this->anioInstalacion = $anioInstalacion;
        }else{
            throw new Exception("El año de instalación debe ser un número positivo.");
        }
    }
    public function getLargo(){
        return $this->largo;
    }
    public function setLargo($largo){
        if(is_numeric($largo) && $largo > 0){
            $this->largo = $largo;
        }else{
            throw new Exception("El largo debe ser un número positivo.");
        }
    }
    public function getAncho(){
        return $this->ancho;
    }   
    public function setAncho($ancho){
        if(is_numeric($ancho) && $ancho > 0){
            $this->ancho = $ancho;
        }else{
            throw new Exception("El ancho debe ser un número positivo.");
        }
    }
    public function getPesoVacio(){
        return $this->pesoVacio;
    }
    public function setPesoVacio($pesoVacio){
        if(is_numeric($pesoVacio) && $pesoVacio > 0){
            $this->pesoVacio = $pesoVacio;
        }else{
            throw new Exception("El peso del vagón debe ser un número positivo.");
        }
    }
    //ToString
    public function __toString(){
        return "Año de instalación: ".$this->getAnioInstalacion()."\nLargo: ".$this->getLargo()."\nAncho: ".$this->getAncho()."\nPeso del vagón: ".$this->getPesoVacio();
    }
    // Método para calcular el volumen del vagón
    /**
     * Implementar el método calcularPesoVagon y redefinirlo según sea necesario. No olvidar agregar el peso que tiene el vagón vacío. 
     */
    public function calcularPesoVagon(){
            
                return $this->getPesoVacio();
        
            }

    
}