<?php
require_once "funcionesGenerales.php";
class Venta{
    /*
        1. Se registra la siguiente información: número, fecha, referencia al cliente, referencia a una colección de
    motos y el precio final.
    2. Método constructor que recibe como parámetros cada uno de los valores a ser asignados a cada
    atributo de la clase.
    3. Los métodos de acceso de cada uno de los atributos de la clase.
    4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
    5. Implementar el método incorporarMoto($objMoto) que recibe por parámetro un objeto moto y lo
    incorpora a la colección de motos de la venta, siempre y cuando sea posible la venta. El método cada
    vez que incorpora una moto a la venta, debe actualizar la variable instancia precio final de la venta.
    Utilizar el método que calcula el precio de venta de la moto donde crea necesario
    
    */

    private $numero;
    private $fecha;
    private $cliente;// Referencia al cliente
    private $motos; // Colección de motos
    private $precioFinal;

    // Método constructor que recibe como parámetros cada uno de los valores a ser asignados a cada atributo de la clase.
    public function __construct($numero, $fecha, $cliente){
        $this->setNumero( $numero);
        $this->setFecha($fecha);
        $this->setCliente($cliente);
        $this->motos = array(); // Inicializa la colección de motos como un array vacío
        $this->precioFinal = 0; // Inicializa el precio final a 0
    }
    // Los métodos de acceso de cada uno de los atributos de la clase.
    public function getNumero(){
        return $this->numero;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getCliente(){
        return $this->cliente;
    }
    public function getMotos(){
        return $this->motos;
    }
    public function getPrecioFinal(){
        return $this->precioFinal;
    }
    public function setNumero($numero){
   
        $this->numero = $numero;
    }
    public function setFecha($fecha){

        validarFecha($fecha); // Verifica si la fecha es válida
        $this->fecha = $fecha; 
        
    }
    public function setCliente($cliente){
        if (!($cliente instanceof Cliente)) {
            throw new Exception("El cliente debe ser una instancia de la clase Cliente.");
        }
        if ($cliente->getBaja() == 1) {
            throw new Exception("El cliente está dado de baja y no puede realizar compras.");
        }
        $this->cliente = $cliente;
    }
    public function setMotos($motos){
        validarArray($motos);
        $this->motos = $motos;
    }
    public function setPrecioFinal($precioFinal){
     
        $this->precioFinal = $precioFinal;
    }
    // Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString(){
        $motosString = implode(", ", $this->motos); // Convierte la colección de motos a una cadena
        return "VENTA\nNúmero: ".$this->getNumero()."\nFecha: ".$this->getFecha()."\nCliente: ".$this->getCliente()."\nMotos: ".$motosString."\nPrecio Final: ".$this->getPrecioFinal();
    }
    
/**
 * * Implementar el método incorporarMoto($objMoto) que recibe por parámetro un objeto moto y lo
 * incorpora a la colección de motos de la venta, siempre y cuando sea posible la venta. El método cada
 * vez que incorpora una moto a la venta, debe actualizar la variable instancia precio final de la venta.
 * Utilizar el método que calcula el precio de venta de la moto donde crea necesario
 * 
 */
public function incorporarMoto($objMoto){
    if (!$objMoto->getActiva()) {
        throw new Exception("No se puede agregar la moto con código " . $objMoto->getCodigo() . ": la moto no está activa.");
    }

    $this->motos[] = $objMoto;
    $this->precioFinal += $objMoto->darPrecioVenta();
    return 1;
}

}