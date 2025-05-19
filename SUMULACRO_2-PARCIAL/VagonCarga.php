<?php
class VagonCarga extends Vagon{
    /*Si se trata de un vagón de carga se almacena el peso máximo que puede transportar y el peso de su carga
    transportada. El peso del vagón va a depender del peso de su carga más un índice que coincide con un 20 % del
    peso de la carga, dicho índice se guarda en cada vagón de carga. */
    private $pesoMaximoCarga;
    private $pesoCarga;
    private $indiceCarga=0.2; // 20% del peso de la carga
    // Constructor con gettesters y setters
    public function __construct($anioInstalacion, $largo, $ancho, $pesoVacio, $pesoMaximoCarga, $pesoCarga){
        parent::__construct($anioInstalacion, $largo, $ancho, $pesoVacio);
        $this->setPesoMaximoCarga($pesoMaximoCarga);
        $this->setPesoCarga($pesoCarga);
    }
    // Getters y setters
    public function getPesoMaximoCarga(){
        return $this->pesoMaximoCarga;
    }
    public function setPesoMaximoCarga($pesoMaximoCarga){
        if(is_numeric($pesoMaximoCarga) && $pesoMaximoCarga > 0){
            $this->pesoMaximoCarga = $pesoMaximoCarga;
        }else{
            throw new Exception("El peso máximo de carga debe ser un número positivo.");
        }
    }
    public function getPesoCarga(){
        return $this->pesoCarga;
    }
    public function setPesoCarga($pesoCarga){
        if(is_numeric($pesoCarga) && $pesoCarga >= 0){
            $this->pesoCarga = $pesoCarga;
        }else{
            throw new Exception("El peso de la carga debe ser un número no negativo.");
        }
    }
    public function getIndiceCarga(){
        return $this->indiceCarga;
    }
    public function setIndiceCarga($indiceCarga){
        if(is_numeric($indiceCarga) && $indiceCarga > 0){
            $this->indiceCarga = $indiceCarga;
        }else{
            throw new Exception("El índice de carga debe ser un número positivo.");
        }
    }
    // toString
    public function __toString(){
        return parent::__toString() . " - Peso máximo de carga: " . $this->getPesoMaximoCarga() . " - Peso de la carga: " . $this->getPesoCarga() . " - Indice de carga: " . $this->getIndiceCarga();
    }
    /*Implementar el método incorporarCargaVagon que recibe por parámetro la cantidad de carga que va
        a transportar el vagón y tiene la responsabilidad de actualizar las variables instancias que representan
        el peso y la carga actual. El método debe devolver verdadero o falso según si se pudo o no agregar la
        carga al vagón. */
    public function incorporarCargaVagon($pesoCarga){
        $retorno=false;
        // Verifico que el peso de la carga sea un número positivo
        if($this->getPesoCarga() + $pesoCarga <= $this->getPesoMaximoCarga()){
            $this->setPesoCarga($this->getPesoCarga() + $pesoCarga);
            $retorno=true;
        }
        return $retorno;
    }
    /*Implementar el método calcularPesoVagon que devuelve el peso total del vagón, es decir, el peso
        vacío más el peso de la carga y el índice de carga. */

      public function calcularPesoVagon() {
       $indiceExtra = $this->getPesoCarga() * 0.2;
       return parent::calcularPesoVagon() + $this->getPesoCarga() + $indiceExtra;
          }
            
}