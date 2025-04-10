<?php
class Moto{
/*
1. Se registra la siguiente información: código, costo, año fabricación, descripción, porcentaje
 incremento anual, activa (atributo que va a contener un valor true, si la moto está disponible para la
 venta y false en caso contrario).
 2. Método constructor que recibe como parámetros los valores iniciales para los atributos definidos en la
 clase.
 3. Los métodos de acceso de cada uno de los atributos de la clase.
 4. Redefinir el método toString para que retorne la información de los atributos de la clase.
 5. Implementar el método darPrecioVenta el cual calcula el valor por el cual puede ser vendida una moto.
 Si la moto no se encuentra disponible para la venta retorna un valor < 0. Si la moto está disponible para
 la venta, el método realiza el siguiente cálculo:
 $_venta = $_compra + $_compra * (anio * por_inc_anual)
 donde $_compra: es el costo de la moto.
 anio: cantidad de años transcurridos desde que se fabricó la moto.
 por_inc_anual: porcentaje de incremento anual de la moto.
*/
private $codigo;
private $costo;
private $anioFabricacion;
private $descripcion;
private $porcentajeIncrementoAnual;
private $activa;
//Método constructor que recibe como parámetros los valores iniciales para los atributos definidos en la clase.
 public function __construct($codigo, $costo, $anioFabricacion, $descripcion, $porcentajeIncrementoAnual, $activa){
    $this->setCodigo($codigo);
    $this->setCosto($costo);
    $this->setAnioFabricacion($anioFabricacion);
    $this->setDescripcion($descripcion);
    $this->setPorcentajeIncrementoAnual($porcentajeIncrementoAnual);
    $this->setActiva($activa);
}

//Los métodos de acceso de cada uno de los atributos de la clase.
public function getCodigo(){
    return $this->codigo;
}
public function getCosto(){
    return $this->costo;
}
public function getAnioFabricacion(){
    return $this->anioFabricacion;
}
public function getDescripcion(){
    return $this->descripcion;
}
public function getPorcentajeIncrementoAnual(){
    return $this->porcentajeIncrementoAnual;
}
public function getActiva(){
    return $this->activa;
}
public function setCodigo($codigo){
    if (!is_numeric($codigo) || $codigo <= 0) {
        throw new Exception("El código debe ser un número positivo.");
    }
    $this->codigo = $codigo;
}
public function setCosto($costo){
    if (!is_numeric($costo) || $costo < 0) {
        throw new Exception("El costo debe ser un número mayor o igual a cero.");
    }
    $this->costo = $costo;
}
public function setAnioFabricacion($anioFabricacion){
    $anioActual = date("Y");
    if (!is_numeric($anioFabricacion) || $anioFabricacion < 1900 || $anioFabricacion > $anioActual) {
        throw new Exception("El año de fabricación debe estar entre 1900 y $anioActual.");
    }
    $this->anioFabricacion = $anioFabricacion;
}
public function setDescripcion($descripcion){
    if (!is_string($descripcion) || trim($descripcion) === '') {
        throw new Exception("La descripción no puede estar vacía.");
    }
    $this->descripcion = $descripcion;
}
public function setPorcentajeIncrementoAnual($porcentajeIncrementoAnual){
    if (!is_numeric($porcentajeIncrementoAnual) || $porcentajeIncrementoAnual <= 0) {
        throw new Exception("El porcentaje de incremento debe ser un número positivo.");
    }

    // Si viene como número entero mayor a 1, lo interpreto como "85%" en lugar de "0.85"
    if ($porcentajeIncrementoAnual > 1) {
        $porcentajeIncrementoAnual = $porcentajeIncrementoAnual / 100;
    }

    if ($porcentajeIncrementoAnual > 1) {
        throw new Exception("El porcentaje de incremento debe estar entre 0 y 1 luego de conversión.");
    }

    $this->porcentajeIncrementoAnual = $porcentajeIncrementoAnual;
}
public function setActiva($activa){
    if (!is_bool($activa) && $activa !== 0 && $activa !== 1) {
        throw new Exception("El valor de 'activa' debe ser booleano (true/false) o 0/1.");
    }
    $this->activa = $activa;
}
//Redefinir el método toString para que retorne la información de los atributos de la clase.
public function __toString(){
    return "Código: ".$this->getCodigo()."\nCosto: ".$this->getCosto()."\nAño de Fabricación: ".$this->getAnioFabricacion()."\nDescripción: ".$this->getDescripcion()."\nPorcentaje de Incremento Anual: ".$this->getPorcentajeIncrementoAnual()."\nActiva: ".($this->getActiva() ? 'SI' : 'NO');

}

/**
 * Implementar el método darPrecioVenta el cual calcula el valor por el cual puede ser vendida una moto.
 *Si la moto no se encuentra disponible para la venta retorna un valor < 0. Si la moto está disponible para la venta, el método realiza el siguiente cálculo:
*$_venta = $_compra + $_compra * (anio * por_inc_anual)
*donde $_compra: es el costo de la moto.
* anio: cantidad de años transcurridos desde que se fabricó la moto.
* por_inc_anual: porcentaje de incremento anual de la moto.
*Sumary:
* @return float
*/
public function darPrecioVenta(){

    $respuesta=-1;
    if($this->getActiva()){
        $anioActual = date("Y");
        $anioTranscurrido = $anioActual - $this->getAnioFabricacion();
        $respuesta = $this->getCosto() + ($this->getCosto() * ($anioTranscurrido * $this->getPorcentajeIncrementoAnual()));
    }else{
        throw new Exception("La moto no está activa para la venta.");
    }
    return $respuesta;
}















}