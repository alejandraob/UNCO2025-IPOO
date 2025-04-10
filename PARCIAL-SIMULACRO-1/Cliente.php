<?php
require_once "funcionesGenerales.php";
class Cliente{
    /*
     1. Se registra la siguiente información: nombre, apellido, si está o no dado de baja, el tipo y el número de documento. 
    Si un cliente está dado de baja, no puede registrar compras desde el momento de su baja.
    2. Método constructor que recibe como parámetros los valores iniciales para los atributos.
    3. Los métodos de acceso de cada uno de los atributos de la clase.
    4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
     */

    private $nombre;
    private $apellido;
    private $baja;
    private $tipoDoc;
    private $numDoc;

//Método constructor que recibe como parámetros los valores iniciales para los atributos.
public function __construct($nombre, $apellido, $tipoDoc, $numDoc, $baja){
    $this->setNombre($nombre);
    $this->setApellido($apellido);
    $this->setTipoDoc($tipoDoc);
    $this->setNumDoc($numDoc);
    $this->setBaja($baja);
}
//Los métodos de acceso de cada uno de los atributos de la clase.
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getBaja(){
        return $this->baja;
    }
    public function getTipoDoc(){
        return $this->tipoDoc;
    }
    public function getNumDoc(){
        return $this->numDoc;
    }
    public function setNombre($nombre){
        validarIdentificacion($nombre);
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        validarIdentificacion($apellido);
        $this->apellido = $apellido;
    }
    public function setBaja($baja){
        $this->baja = $baja;
    }
    public function setTipoDoc($tipoDoc){
        $this->tipoDoc = $tipoDoc;
    }
    public function setNumDoc($numDoc){
        $this->numDoc = $numDoc;
    }
//Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString(){
        return "INFORMACION CLIENTE:\nNombre: ".$this->getNombre()." Apellido: ".$this->getApellido()."\n ACTIVO:
         ".$baja=($this->getBaja()==0)?'SI':'NO'."\nTipo de Documento: ".$this->getTipoDoc()." Número de Documento: ".$this->getNumDoc();
    }
}

