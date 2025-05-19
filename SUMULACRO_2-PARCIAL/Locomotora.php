<?php
class Locomotora{
    /*
    Se registra la información de su peso y velocidad máxima
     */
    private $peso;
    private $velocidadMaxima;
    // Constructor con gettesters y setters
    public function __construct($peso, $velocidadMaxima){
        $this->setPeso($peso);
        $this->setVelocidadMaxima($velocidadMaxima);
    }
    // Getters y setters
    public function getPeso(){
        return $this->peso;
    }
    public function setPeso($peso){
        if(is_numeric($peso) && $peso > 0){
            $this->peso = $peso;
        }else{
            throw new Exception("El peso debe ser un número positivo.");
        }
    }
    public function getVelocidadMaxima(){
        return $this->velocidadMaxima;
    }
    public function setVelocidadMaxima($velocidadMaxima){
        if(is_numeric($velocidadMaxima) && $velocidadMaxima > 0){
            $this->velocidadMaxima = $velocidadMaxima;
        }else{
            throw new Exception("La velocidad máxima debe ser un número positivo.");
        }
    }
    // toString
    public function __toString(){
        return "Peso: " . $this->getPeso() . " - Velocidad máxima: " . $this->getVelocidadMaxima();
    }
}