<?php
require_once "funcionesGenerales.php";
class Empresa  {
/*
 1. Se registra la siguiente información: denominación, dirección, la colección de clientes, colección de
 motos y la colección de ventas realizadas.
 2. Método constructor que recibe como parámetros los valores iniciales para los atributos de la clase.
 3. Los métodos de acceso para cada una de las variables instancias de la clase.
 4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
 5. Implementar el método retornarMoto($codigoMoto) que recorre la colección de motos de la Empresa y
 retorna la referencia al objeto moto cuyo código coincide con el recibido por parámetro.
 6. Implementar el método registrarVenta($colCodigosMoto, $objCliente) método que recibe por
 parámetro una colección de códigos de motos, la cual es recorrida, y por cada elemento de la colección
 se busca el objeto moto correspondiente al código y se incorpora a la colección de motos de la instancia
 Venta que debe ser creada. Recordar que no todos los clientes ni todas las motos, están disponibles
 para registrar una venta en un momento determinado.
 El método debe setear los variables instancias de venta que corresponda y retornar el importe final de la
 venta.
 7. Implementar el método retornarVentasXCliente($tipo,$numDoc) que recibe por parámetro el tipo y
 número de documento de un Cliente y retorna una colección con las ventas realizadas al cliente.

*/
private $denominacion;
private $direccion;
private $clientes; // Colección de clientes
private $motos; // Colección de motos
private $ventas; // Colección de ventas realizadas

// Método constructor que recibe como parámetros los valores iniciales para los atributos de la clase.
public function __construct($denominacion, $direccion){
    $this->setDenominacion($denominacion);
    $this->setDireccion($direccion);
    $this->clientes = array(); // Inicializa la colección de clientes como un array vacío
    $this->motos = array(); // Inicializa la colección de motos como un array vacío
    $this->ventas = array(); // Inicializa la colección de ventas como un array vacío
}
// Los métodos de acceso para cada una de las variables instancias de la clase.
public function getDenominacion(){
    return $this->denominacion;
}
public function getDireccion(){
    return $this->direccion;
}
public function getClientes(){
    return $this->clientes;
}
public function getMotos(){
    return $this->motos;
}
public function getVentas(){
    return $this->ventas;
}
public function setDenominacion($denominacion){
    validarIdentificacion($denominacion);
    $this->denominacion = $denominacion;
}
public function setDireccion($direccion){
    if (!is_string($direccion) || empty($direccion)) {
        throw new Exception("La dirección debe ser una cadena no vacía.");
    }
    $this->direccion = $direccion;
}
public function setClientes($clientes){
    validarArray($clientes);
    $this->clientes = $clientes;
}
public function setMotos($motos){
    validarArray($motos);
    $this->motos = $motos;
}
public function setVentas($ventas){
    validarArray($ventas);
    $this->ventas = $ventas;
}
// Redefinir el método _toString para que retorne la información de los atributos de la clase.

public function __toString(){
    $info = "Denominación: ".$this->getDenominacion()."\nDirección: ".$this->getDireccion()."\nClientes:\n";
    foreach ($this->clientes as $cliente) {
        $info .= $cliente->__toString()."\n";
    }
    $info .= "Motos:\n";
    foreach ($this->motos as $moto) {
        $info .= $moto->__toString()."\n";
    }
    $info .= "Ventas:\n";
    foreach ($this->ventas as $venta) {
        $info .= $venta->__toString()."\n";
    }
    return $info;
}

/**
 * Implementar el método retornarMoto($codigoMoto) 
 * Recorre la colección de motos de la Empresa y retorna la referencia al objeto moto cuyo código coincide con el recibido por parámetro.
 * @param string $codigoMoto Código de la moto a buscar.
 */
public function retornarMoto($codigoMoto){

    $respuesta = null;
    foreach ($this->motos as $moto) {
        if ($moto->getCodigo() == $codigoMoto) {
            $respuesta = $moto;

        }
    }
    return $respuesta;
}
/**
 * * Implementar el método registrarVenta($colCodigosMoto, $objCliente)
 * método que recibe por parámetro una colección de códigos de motos, la cual es recorrida, y por cada elemento de la colección se busca el objeto moto correspondiente al código y se incorpora a la colección de motos de la instancia Venta que debe ser creada.
 * Recordar que no todos los clientes ni todas las motos, están disponibles para registrar una venta en un momento determinado.
 * El método debe setear los variables instancias de venta que corresponda y retornar el importe final de la venta.
 * @param array $colCodigosMoto Colección de códigos de motos a vender.
 * @param object $objCliente Objeto cliente que realiza la compra.
 * @return float Importe final de la venta.
 * 
 */
public function registrarVenta($colCodigosMoto, $objCliente){
    $importeFinal = 0;

    if ($objCliente->getBaja() == 1) {
        throw new Exception("El cliente está dado de baja y no puede realizar compras.");
    }

    $venta = new Venta(0, date("Y-m-d"), $objCliente);

    foreach ($colCodigosMoto as $codigoMoto) {
        try {
            $moto = $this->retornarMoto($codigoMoto);
            if ($moto && $moto->getActiva()) {
                $venta->incorporarMoto($moto);
                $importeFinal += $moto->darPrecioVenta();
            } else {
                throw new Exception("Moto con código $codigoMoto no disponible para venta.");
            }
        } catch (Exception $e) {
            echo "⚠️ Advertencia: " . $e->getMessage() . "\n";
        }
    }

    if ($importeFinal > 0) {
        $this->ventas[] = $venta;
    } else {
        throw new Exception("No se pudo registrar la venta: importe final es 0.");
    }

    return $importeFinal;
}
/**
 * Implementar el método retornarVentasXCliente($tipo,$numDoc) 
 * que recibe por parámetro el tipo y número de documento de un Cliente y retorna una colección con las ventas realizadas al cliente.
 * @param string $tipo Tipo de documento del cliente.
 * @param string $numDoc Número de documento del cliente.
 * @return array Colección de ventas realizadas al cliente.
 */
public function retornarVentasXCliente($tipo, $numDoc){
    $ventasCliente = array();

    foreach ($this->ventas as $venta) {
        if ($venta->getCliente()->getTipoDoc() == $tipo && $venta->getCliente()->getNumDoc() == $numDoc) {
            $ventasCliente[] = $venta;
        }
    }

    if (count($ventasCliente) == 0) {
        throw new Exception("No se encontraron ventas para el cliente con tipo de documento: $tipo y número de documento: $numDoc");
    }

    return $ventasCliente;
}

}