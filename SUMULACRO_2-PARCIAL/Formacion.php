<?php
class Formacion{
    /*
        1. Se almacena la referencia a un objeto de la clase Locomotora , la colección de objetos de la clase Vagón
        y el máximo de vagones que puede contener. Se tiene una única colección de vagones
        2. Implementar el método incorporarPasajeroFormacion que recibe la cantidad de pasajeros que se
        desea incorporar a la formación y busca dentro de la colección de vagones aquel vagón capaz de
        incorporar esa cantidad de pasajeros. Si no hay ningún vagón en la formación que pueda ingresar la
        cantidad de pasajeros, el método debe retornar un valor falso y verdadero en caso contrario. Puede
        utilizar la función is_a para saber si se trata de un vagón de carga o de pasajeros.
        3. Implementar el método incorporarVagonFormacionque recibe por parámetro un objeto vagón y lo
        incorpora a la formación. El método retorna verdadero si la incorporación se realizó con éxito y falso en
        caso contrario.
        4. Implementar el método promedioPasajeroFormacion el cual recorre la colección de vagones y retorna
        un valor que represente el promedio de pasajeros por vagón que se encuentran en la formación. Puede
        utilizar la función is_a para saber si se trata de un vagón de carga o de pasajeros.
        5. Implementar el método pesoFormacion el cual retorna el peso de la formación completa.
        6. Implementar el método retornarVagonSinCompletar el cual retorna el primer vagón de la formación que
        aún no se encuentra completo.
    */
    private $locomotora;
    private $vagones; // Colección de objetos de la clase Vagon
    private $maximoVagones;
    // Constructor
    public function __construct($locomotora, $maximoVagones){
        $this->setLocomotora($locomotora);
        $this->setMaximoVagones($maximoVagones);
        $this->vagones = array();
    }
    // Getters y setters
    public function getLocomotora(){
        return $this->locomotora;
    }
    public function setLocomotora($locomotora){
        if(is_a($locomotora, 'Locomotora')){
            $this->locomotora = $locomotora;
        }else{
            throw new Exception("La locomotora debe ser un objeto de la clase Locomotora.");
        }
    }
    public function getVagones(){
        return $this->vagones;
    }
    public function setVagones($vagones){
        if(is_array($vagones)){
            $this->vagones = $vagones;
        }else{
            throw new Exception("Los vagones deben ser una colección de objetos de la clase Vagon.");
        }
    }
    public function getMaximoVagones(){
        return $this->maximoVagones;
    }
    public function setMaximoVagones($maximoVagones){
        if(is_numeric($maximoVagones) && $maximoVagones > 0){
            $this->maximoVagones = $maximoVagones;
        }else{
            throw new Exception("El máximo de vagones debe ser un número positivo.");
        }
    }
    // toString
    public function __toString(){
        $vagonesString = "";
        foreach($this->getVagones() as $vagon){
            $vagonesString .= $vagon->__toString() . "\n";
        }
        return "Locomotora: " . $this->getLocomotora()->__toString() . "\nVagones:\n" . $vagonesString;
    }
    // Método para incorporar pasajeros a la formación
    public function incorporarPasajeroFormacion($cantidadPasajeros){
        $retorno = false;
        $corte = false;
        $i=0;
        while(!$corte && $i < count($this->getVagones())){
            //is_a es una función que verifica si un objeto es de una clase específica
            // En este caso, verificamos si el vagón es de pasajeros
            if(is_a($this->getVagones()[$i], 'VagonPasajeros')){
                if($this->getVagones()[$i]->incorporarPasajeroVagon($cantidadPasajeros)){
                    $retorno = true;
                    $corte = true;
                }
            }
            $i++;
        }
        return $retorno;
    }
    // Método para incorporar un vagón a la formación
    public function incorporarVagonFormacion($vagon){
        $retorno = false;
        if(count($this->getVagones()) < $this->getMaximoVagones()){
            $this->vagones[] = $vagon;
            $retorno = true;
        }
        return $retorno;
    }
    // Método para calcular el promedio de pasajeros por vagón
    public function promedioPasajeroFormacion(){
        $retorno = 0;
        $sumaPasajeros = 0;
        $cantidadVagones = 0;
        foreach($this->getVagones() as $vagon){
            //is_a es una función que verifica si un objeto es de una clase específica
            // En este caso, verificamos si el vagón es de pasajeros
            if(is_a($vagon, 'VagonPasajeros')){
                $sumaPasajeros += $vagon->getCantidadPasajeros();
                $cantidadVagones++;
            }
        }
        if($cantidadVagones > 0){
            $retorno = $sumaPasajeros / $cantidadVagones;
        }
        return $retorno;
    }
    // Método para calcular el peso de la formación
    public function pesoFormacion(){
        $pesoTotal = $this->getLocomotora()->getPeso();
        foreach($this->getVagones() as $vagon){
            $pesoTotal += $vagon->calcularPesoVagon();
        }
        return $pesoTotal;
    }
    // Método para retornar el primer vagón sin completar
    public function retornarVagonSinCompletar(){
        $retorno = null;
        $corte = false;
        $i=0;
        while(!$corte && $i < count($this->getVagones())){
            //is_a es una función que verifica si un objeto es de una clase específica
            // En este caso, verificamos si el vagón es de pasajeros
            if(is_a($this->getVagones()[$i], 'VagonPasajeros')){
                if($this->getVagones()[$i]->getCantidadPasajeros() < $this->getVagones()[$i]->getCantidadMaximaPasajeros()){
                    $retorno = $this->getVagones()[$i];
                    $corte = true;
                }
            }
            $i++;
        }
        return $retorno;
    }
}