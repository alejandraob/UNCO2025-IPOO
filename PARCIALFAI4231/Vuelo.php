<?php

/*En la clase Vuelo:

Se registra la siguiente información: número, importe, fecha, destino, hora arribo, hora partida, cantidad asientos totales y disponibles, y una referencia a la persona responsable del vuelo. 

Se cuenta con la implementación de:

 un Método constructor que recibe como parámetros los valores iniciales para los atributos definidos en la clase.
los métodos de acceso de cada uno de los atributos de la clase. */

class Vuelo{
    private $numero;
    private $importe;
    private $fecha;
    private $destino;
    private $horaArribo;
    private $horaPartida;
    private $cantAsientosTotales;
    private $cantAsientosDisponibles;
    private $responsable; // Referencia a la persona responsable del vuelo

    // Constructor de la clase Vuelo
    public function __construct($numero, $importe, $fecha, $destino, $horaArribo, $horaPartida, $cantAsientosTotales, $cantAsientosDisponibles, $responsable) {
        $this->setNumero($numero);
        $this->setImporte($importe);
        $this->setFecha($fecha);
        $this->setDestino($destino);
        $this->setHoraArribo($horaArribo);
        $this->setHoraPartida($horaPartida);
        $this->setCantAsientosTotales($cantAsientosTotales);
        $this->setCantAsientosDisponibles($cantAsientosDisponibles);
        $this->setResponsable($responsable);
    }

    // Métodos de acceso (getters y setters)
    public function getNumero() {
        return $this->numero;
    }
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    public function getImporte() {
        return $this->importe;
    }
    public function setImporte($importe) {
        $this->importe = $importe;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function getDestino() {
        return $this->destino;
    }
    public function setDestino($destino) {
        $this->destino = $destino;
    }
    public function getHoraArribo() {
        return $this->horaArribo;
    }
    public function setHoraArribo($horaArribo) {
        $this->horaArribo = $horaArribo;
    }
    public function getHoraPartida() {
        return $this->horaPartida;
    }
    public function setHoraPartida($horaPartida) {
        $this->horaPartida = $horaPartida;
    }
    public function getCantAsientosTotales() {
        return $this->cantAsientosTotales;
    }
    public function setCantAsientosTotales($cantAsientosTotales) {
        $this->cantAsientosTotales = $cantAsientosTotales;
    }
    public function getCantAsientosDisponibles() {
        return $this->cantAsientosDisponibles;
    }
    public function setCantAsientosDisponibles($cantAsientosDisponibles) {
        $this->cantAsientosDisponibles = $cantAsientosDisponibles;
    }
    public function getResponsable() {
        return $this->responsable;
    }
    public function setResponsable($responsable) {
        $this->responsable = $responsable;
    }


    //metodo toString
    public function __toString() {
        return "Número: " . $this->getNumero() . "\n" .
               "Importe: " . $this->getImporte() . "\n" .
               "Fecha: " . $this->getFecha() . "\n" .
               "Destino: " . $this->getDestino() . "\n" .
               "Hora Arribo: " . $this->getHoraArribo() . "\n" .
               "Hora Partida: " . $this->getHoraPartida() . "\n" .
               "Cantidad Asientos Totales: " . $this->getCantAsientosTotales() . "\n" .
               "Cantidad Asientos Disponibles: " . $this->getCantAsientosDisponibles() . "\n" .
               "Responsable: " . $this->responsable->__toString() . "\n";
    }
    //Metodo asignarAsientosdisponibles
    function asignarAsientosDisponibles($cantPasajeros){
        $asignado = false;
        $disponibles = $this->getCantAsientosDisponibles();

        if ($disponibles >= $cantPasajeros && $cantPasajeros > 0) {
            $this->setCantAsientosDisponibles($disponibles - $cantPasajeros);
            $asignado = true;
        }

        return $asignado;
    }

}