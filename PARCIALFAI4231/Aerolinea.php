<?php
class Aerolinea{
    /*En la clase Aerolíneas se registra la siguiente información: identificación, nombre y la colección de vuelos programados.*/
private $identificacion;
private $nombre;
private $coleccionVuelos; // Colección de vuelos programados
private $cantVuelos; // Cantidad de vuelos programados

// Constructor de la clase Aeropuerto
public function __construct($identificacion, $nombre,$coleccionVuelos,$cantVuelos) {
    $this->setIdentificacion($identificacion);
    $this->setNombre($nombre);
    $this->setColeccionVuelos($coleccionVuelos); // Inicializa la colección de vuelos como un array vacío
    $this->setCantVuelos($cantVuelos); // Inicializa la cantidad de vuelos programados a 0
}

    // Métodos de acceso (getters y setters)
    public function getIdentificacion() {
        return $this->identificacion;
    }
    public function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getColeccionVuelos() {
        return $this->coleccionVuelos;
    }
    public function setColeccionVuelos($coleccionVuelos) {
        $this->coleccionVuelos = $coleccionVuelos;
    }
    public function getCantVuelos() {
        return $this->cantVuelos;
    }
    public function setCantVuelos($cantVuelos) {
        $this->cantVuelos = $cantVuelos;
    }
    //Metodo toString
    public function __toString() {
        return "Identificación: " . $this->getIdentificacion() . "\n" .
               "Nombre: " . $this->getNombre() . "\n" .
               "Cantidad de Vuelos Programados: " . $this->getCantVuelos() . "\n";
    }

    /**
     * Summary of darVueloADestino
     * Se debe implementar el método  darVueloADestino que recibe por parámetro un destino junto a una cantidad de asientos libres
     *  y se debe retornar una colección con los vuelos disponibles a ese destino.
     * @param mixed $destino
     * @param mixed $cantAsientosDisponibles
     * @return array
     */
    public function darVueloADestino($destino, $cantAsientosDisponibles) {
        $colVuelos = [];
        foreach ($this->getColeccionVuelos() as $vuelo) {
            if ($vuelo->getDestino() === $destino && $vuelo->getCantAsientosDisponibles() >= $cantAsientosDisponibles) {
                $colVuelos[] = $vuelo;
            }
        }
        return $colVuelos;
    }

    /**
     * Summary of incorporarVuelo
     * Implementar en la clase Aerolinea el método incorporarVuelo que recibe como parámetro un vuelo, 
     * verifica que no se encuentre registrado ningún otro vuelo al mismo destino, en la misma fecha y con el mismo horario de partida.
     *  El método debe retornar verdadero si la incorporación del vuelo se realizó correctamente y falso en caso contrario.
     * @return bool
     */
    public function incorporarVuelo($vuelo) {
        $vueloAgregado = true;
        
        foreach ($this->getColeccionVuelos() as $v) {
            if (
                $v->getDestino() === $vuelo->getDestino() &&
                $v->getFecha() === $vuelo->getFecha() &&
                $v->getHoraPartida() === $vuelo->getHoraPartida()
            ) {
                $vueloAgregado = false;
            }
        }

        if ($vueloAgregado) {
            $coleccionVuelos = $this->getColeccionVuelos();
            $coleccionVuelos[] = $vuelo;
            $this->setColeccionVuelos($coleccionVuelos);
            $this->setCantVuelos($this->getCantVuelos() + 1);
        }

        return $vueloAgregado;
    }

    /**
     * Summary of venderVueloDestino
     * Implemente en la clase Aerolinea  el método venderVueloADestino, que recibe por parámetro: la cantidad de asientos, el destino y una fecha. 
     * El método realiza la venta con el primer vuelo encontrado a ese destino, con los asientos disponibles y en la fecha deseada. 
     * En la implementación debe invocar al método asignarAsientosDisponibles y retornar la instancia del vuelo asignado o null en caso contrario.
     * @param mixed $cantAsientos
     * @param mixed $destino
     * @param mixed $fecha
     * @return void
     */
    public function venderVueloADestino($cantAsientos, $destino, $fecha) {
        $vueloAsignado = null;
        $vuelos = $this->getColeccionVuelos();
    
        foreach ($vuelos as $vuelo) {
            if ($vueloAsignado === null) {
                if (
                    $vuelo->getDestino() === $destino &&
                    $vuelo->getFecha() === $fecha &&
                    $vuelo->getCantAsientosDisponibles() >= $cantAsientos
                ) {
                    $vuelo->asignarAsientosDisponibles($cantAsientos);
                    $vueloAsignado = $vuelo;
                }
            }
        }
    
        return $vueloAsignado;
    }

    /**
     * 
     * Summary of asignarAsientosDisponibles
     * En la clase Aerolínea  se debe implementar el método  montoPromedioRecaudado que retorna el importe promedio recaudado por la aerolínea con cada uno de sus vuelos.
     * @return float
     */
    public function montoPromedioRecaudado() {
        $totalRecaudado = 0;
        $coleccionVuelos = $this->getColeccionVuelos();
        $cantVuelos = count($coleccionVuelos);

        foreach ($coleccionVuelos as $vuelo) {
            $importe = $vuelo->getImporte();
            $vendidos = $vuelo->getCantAsientosTotales() - $vuelo->getCantAsientosDisponibles();
            $totalRecaudado += $importe * $vendidos;
        }

        return $cantVuelos > 0 ? $totalRecaudado / $cantVuelos : 0;
    }


}