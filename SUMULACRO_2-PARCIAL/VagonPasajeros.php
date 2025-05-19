<?php
class VagonPasajeros extends Vagon{
    /*
    Si se trata de un vagón de pasajeros también se almacena la cantidad máxima de pasajeros que puede
    transportar, la cantidad de pasajeros que está transportando y el peso promedio de los pasajeros. Es importante
    tener en cuenta que la variable de instancia que representa el peso del vagón se calcula de acuerdo a la
    cantidad de pasajeros que se está transportando y considerando un peso promedio por pasajero de 50 Kilos..

     */
    private $cantidadMaximaPasajeros;
    private $cantidadPasajeros;
    private $pesoPromedioPasajeros=50; //considerando un peso promedio por pasajero de 50 Kilos
    // Constructor con gettesters y setters
    public function __construct($anioInstalacion, $largo, $ancho, $pesoVacio, $cantidadMaximaPasajeros, $cantidadPasajeros, $pesoPromedioPasajeros){
        parent::__construct($anioInstalacion, $largo, $ancho, $pesoVacio);
        $this->setCantidadMaximaPasajeros($cantidadMaximaPasajeros);
        $this->setCantidadPasajeros($cantidadPasajeros);
        $this->setPesoPromedioPasajeros($pesoPromedioPasajeros);
    }
    // Getters y setters
    public function getCantidadMaximaPasajeros(){
        return $this->cantidadMaximaPasajeros;
    }
    public function setCantidadMaximaPasajeros($cantidadMaximaPasajeros){
        if(is_numeric($cantidadMaximaPasajeros) && $cantidadMaximaPasajeros > 0){
            $this->cantidadMaximaPasajeros = $cantidadMaximaPasajeros;
        }else{
            throw new Exception("La cantidad máxima de pasajeros debe ser un número positivo.");
        }
    }
    public function getCantidadPasajeros(){
        return $this->cantidadPasajeros;
    }
    public function setCantidadPasajeros($cantidadPasajeros){
        if(is_numeric($cantidadPasajeros) && $cantidadPasajeros >= 0){
            $this->cantidadPasajeros = $cantidadPasajeros;
        }else{
            throw new Exception("La cantidad de pasajeros debe ser un número no negativo.");
        }
    }
    public function getPesoPromedioPasajeros(){
        return $this->pesoPromedioPasajeros;
    }
    public function setPesoPromedioPasajeros($pesoPromedioPasajeros){
        if(is_numeric($pesoPromedioPasajeros) && $pesoPromedioPasajeros > 0){
            $this->pesoPromedioPasajeros = $pesoPromedioPasajeros;
        }else{
            throw new Exception("El peso promedio de los pasajeros debe ser un número positivo.");
        }
    }
    // toString
    public function __toString(){
        return parent::__toString() . " - Cantidad máxima de pasajeros: " . $this->getCantidadMaximaPasajeros() . " - Cantidad de pasajeros: " . $this->getCantidadPasajeros() . " - Peso promedio de los pasajeros: " . $this->getPesoPromedioPasajeros();
    }
    /*
        Implementar el método incorporarPasajeroVagon que recibe por parámetro la cantidad de pasajeros
        que ingresan al vagón y tiene la responsabilidad de actualizar las variables instancias que representan el
        peso y la cantidad actual de pasajeros.El método debe devolver verdadero o falso según si se pudo o no
        agregar los pasajeros al vagón.
    */
    public function incorporarPasajeroVagon($cantidadPasajeros){
        $retorno = false;
        if($this->getCantidadPasajeros() + $cantidadPasajeros <= $this->getCantidadMaximaPasajeros()){
            $this->setCantidadPasajeros($this->getCantidadPasajeros() + $cantidadPasajeros);
            $retorno = true;
        }
       return $retorno;
    }
    /*
        Implementar el método calcularPesoVagon que devuelve el peso total del vagón considerando el peso
        vacío del vagón y el peso de los pasajeros que transporta.
    */
    public function calcularPesoVagon(){
        $pesoTotal = parent::calcularPesoVagon();
        $pesoTotal += $this->getCantidadPasajeros() * $this->getPesoPromedioPasajeros();
        return $pesoTotal;
    }


}