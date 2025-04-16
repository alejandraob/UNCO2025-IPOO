<?php
class Aeropuerto{
    /*En la clase Aeropuerto 

Se registra la siguiente información: denominación, dirección y la colección de aerolíneas que arriban a el.*/ 
    private $denominacion;
    private $direccion;
    private $coleccionAerolinas; // Colección de aerolíneas que arriban al aeropuerto
    //Metodo constructor que recibe como parámetros los valores iniciales para los atributos definidos en la clase.
    public function __construct($denominacion, $direccion,$coleccionAerolinas) {
        $this->setDenominacion($denominacion);
        $this->setDireccion($direccion);
        $this->setColeccionAerolinas($coleccionAerolinas); // Inicializa la colección de aerolíneas como un array vacío
    }

    // Métodos de acceso (getters y setters)
    public function getDenominacion() {
        return $this->denominacion;
    }
    public function setDenominacion($denominacion) {
        $this->denominacion = $denominacion;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function getColeccionAerolinas() {
        return $this->coleccionAerolinas;
    }
    public function setColeccionAerolinas($coleccionAerolinas) {
        $this->coleccionAerolinas = $coleccionAerolinas;
    }
    //Metodo toString
    public function __toString() {
        return "Denominación: " . $this->getDenominacion() . "\n" .
               "Dirección: " . $this->getDireccion() . "\n" .
               "Colección de Aerolíneas: " . implode(", ", $this->getColeccionAerolinas()) . "\n";
    }


    /**
     * Summary of retornarVuelosAerolinea
     * Implementar el método retornarVuelosAerolinea que recibe por parámetro una aerolínea y retorna todos los vuelos asignados a esa aerolínea.
     * @param mixed $aerolinea
     * @return array
     */
    public function retornarVuelosAerolinea($nombreAerolinea) {
        $vuelosEncontrados = [];
        foreach ($this->getColeccionAerolinas() as $aerolinea) {
            if ($aerolinea->getNombre() == $nombreAerolinea) {
                $vuelosEncontrados = array_merge($vuelosEncontrados, $aerolinea->getColeccionVuelos());
            }
        }
        return $vuelosEncontrados;
    }

    /**
     * Summary of ventaAutomatica
     * Implementar el método ventaAutomatica que recibe por parámetro la cantidad de asientos, una fecha y un destino y el aeropuerto realiza automáticamente la asignación al vuelo. 
     * Para la implementación de este método debe utilizarse uno de los métodos implementados en la clase Vuelo. 
     * @param mixed $cantAsientos
     * @param mixed $fecha
     * @param mixed $destino
     * @param mixed $aeropuerto
     * @return void
     */
    public function ventaAutomatica($cantAsientos, $fecha, $destino) {
        
        $respuesta = null;
        foreach ($this->getColeccionAerolinas() as $aerolinea) {
            foreach ($aerolinea->getColeccionVuelos() as $vuelo) {
                if (
                    $vuelo->getFecha() == $fecha &&
                    $vuelo->getDestino() == $destino &&
                    $vuelo->getCantAsientosDisponibles() >= $cantAsientos
                ) {
                    $vuelo->asignarAsientosDisponibles($cantAsientos); 
                    $respuesta = $vuelo;
                }
            }
        }
        return $respuesta; // Retorna el vuelo asignado o null si no se encontró
    }

    /**
     * Summary of promedioRecaudadoXAerolinea
     * Implementar en la clase Aeropuerto el método promedioRecaudadoXAerolinea,  que recibe por parámetro la identificación de una Aerolínea y 
     * retorna el promedio de lo recaudado por esa Aerolínea en ese Aeropuerto. 
     * Para la implementación utilizar, si es posible, alguno de los métodos previamente implementado.
     * @param mixed $identificacion
     * @return float
     */
    public function promedioRecaudadoXAerolinea($identificacion) {
        $totalRecaudado = 0;
        foreach ($this->getColeccionAerolinas() as $aerolinea) {
            if ($aerolinea->getIdentificacion() == $identificacion) {
                $totalRecaudado = 0;
                $vuelos = $aerolinea->getColeccionVuelos();
                $cantVuelos = count($vuelos);
                foreach ($vuelos as $vuelo) {
                    $totalRecaudado += $vuelo->getImporte();
                }
                $totalRecaudado = ($cantVuelos > 0) ? ($totalRecaudado / $cantVuelos) : 0;
            }
        }
        return $totalRecaudado; // No se encontró la aerolínea
    }











}