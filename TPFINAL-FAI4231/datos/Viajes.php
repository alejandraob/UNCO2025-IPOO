<?php
include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "ResponsableV.php";
include_once "Pasajeros.php";
class Viajes
{

    private $idviaje;
    private $destino;
    private $importe;
    private $cantmaxpasajeros;
    private $pasajeros;
    private $rnumeroempleado;
    private $idempresa;


    public function __construct()
    {
        $this->idviaje = null;
        $this->destino = "";
        $this->importe = 0;
        $this->cantmaxpasajeros = 0;
        $this->pasajeros = array();
        $this->rnumeroempleado  = new ResponsableV();
        $this->idempresa  = new Empresa();
    }

    // Getters
    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function getCantmaxpasajeros()
    {
        return $this->cantmaxpasajeros;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    public function getResponsable()
    {
        return $this->rnumeroempleado;
    }

    public function getEmpresa()
    {
        return $this->idempresa;
    }

    // Setters
    public function setIdViaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    public function setDestino($destino)
    {
        if (empty($destino)) {
            throw new Exception("El destino no puede estar vacío.");
        }
        $this->destino = $destino;
    }

    public function setImporte($importe)
    {
        if (!is_numeric($importe) || $importe < 0) {
            throw new Exception("El importe debe ser un número positivo.");
        }
        $this->importe = $importe;
    }

    public function setCantMaxPasajeros($cantmaxpasajeros)
    {

        if (is_numeric($cantmaxpasajeros) && $cantmaxpasajeros > 0) {
            if ($cantmaxpasajeros < count($this->getPasajeros())) {
                throw new Exception("La cantidad máxima de pasajeros no puede ser menor a la cantidad de pasajeros actual.");
            } else {
                $this->cantmaxpasajeros = $cantmaxpasajeros;
            }
        } else {
            throw new Exception("La cantidad máxima de pasajeros debe ser un número mayor a 0.");
        }
    }

    public function setPasajeros($pasajeros)
    {
        if (!is_array($pasajeros)) {
            throw new Exception("Los pasajeros deben ser un array.");
        }
        $this->pasajeros = $pasajeros;
    }

    public function setResponsable($responsable)
    {
        if (!$responsable instanceof ResponsableV) {
            throw new Exception("El responsable debe ser una instancia de ResponsableV.");
        }
        $this->rnumeroempleado = $responsable;
    }

    public function setEmpresa($empresa)
    {
        if (!$empresa instanceof Empresa) {
            throw new Exception("La empresa debe ser una instancia de Empresa.");
        }
        $this->idempresa = $empresa;
    }
    /**
     * Summary of cargarViaje
     * 
     * @param mixed $Id
     * @param mixed $destino
     * @param mixed $cantMaxPasajeros
     * @param mixed $empresa
     * @param mixed $responsableV
     * @param mixed $importe
     * @param mixed $pasajeros
     * @return void
     */
    public function cargarViaje($Id, $destino, $cantMaxPasajeros, $empresa, $responsableV, $importe, $pasajeros)
    {
        $this->setIdViaje($Id);
        $this->setDestino($destino);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setEmpresa($empresa);
        $this->setResponsable($responsableV);
        $this->setImporte($importe);
        $this->setPasajeros($pasajeros);
    }

    /**
     * Summary of agregarPasajeroEnArray
     * Valido si el pasajero ya existe en el array de pasajeros del viaje y si hay lugar para agregarlo.
     * Si no existe y hay lugar, lo agrega al array de pasajeros del viaje.
     * @param mixed $pasajero
     * @throws \Exception
     * @return bool
     */
    public function agregarPasajeroEnArray($pasajero)
    {
        // Verifico que el pasajero sea una instancia de Pasajeros
        if (!$pasajero instanceof Pasajeros) {
            throw new Exception("El pasajero debe ser una instancia de Pasajeros.");
        }

        //Verifico la cantidad máxima de pasajeros
        if (count($this->getPasajeros()) >= $this->cantmaxpasajeros) {
            throw new Exception("No hay más lugar en el viaje.");
        }

        $puedeAgregar = true;
        // Verifico si el pasajero ya existe en el array de pasajeros del viaje
        $i = 0;
        $total = count($this->getPasajeros());
        while ($i < $total && $puedeAgregar) {
            if ($this->getPasajeros()[$i]->getNroDoc() === $pasajero->getNroDoc()) {
                $puedeAgregar = false;
            }
            $i++;
        }

        // Si pasó ambas validaciones, lo agregamos
        if ($puedeAgregar) {
            $this->pasajeros[] = $pasajero;
        }

        return $puedeAgregar;
    }
    /**
     * Summary of listar
     * Lista los viajes de la base de datos.
     * Si se pasa una condición, la agrega a la consulta.
     * Si no, lista todos los viajes.
     * @param mixed $cond
     * @throws \Exception
     * @return Viajes[]
     */
    public static function listar($cond = "")
    {
        $conexion = new BaseDatos();
        //Creamos la consulta SQL para listar los viajes
        $query = "SELECT * FROM viaje";
        $query = (!empty($cond)) ? $query . ' WHERE ' . $cond : $query;
        //Creamos un array para almacenar los viajes
        $arrViajes = [];
        // Verificamos si la conexión a la base de datos se realizó correctamente
        // Si no, lanzamos una excepción con el error de conexión
        if (!$conexion->Iniciar()) {
            throw new Exception("Error de conexion con la base de datos. Error: " . $conexion->getError());
        }
        // Ejecutamos la consulta y verificamos si se obtuvo algún resultado
        if ($conexion->Ejecutar($query)) {
            // Si se obtuvieron resultados, recorremos cada registro
            // y creamos un objeto Viajes para cada uno
            while ($resp = $conexion->Registro()) {
                // Creamos un nuevo objeto Viajes
                $obj = new Viajes();
                //Instanciamos Empresa y buscamos la empresa
                // Seteamos el ID de la empresa y buscamos los datos de la empresa
                $empresa = new Empresa();
                $empresa->setId($resp["idempresa"]);
                $empresa->buscarEmpresa();
                //Instanciamos ResponsableV y buscamos el empleado
                // Seteamos el número de empleado y buscamos los datos del responsable
                $responsableV = new ResponsableV();
                $responsableV->setNroEmpleado($resp["rnumeroempleado"]);
                $responsableV->buscarEmpleado($resp["rnumeroempleado"]);

                // Cargamos los datos del viaje en el objeto
                $obj->setIdViaje($resp["idviaje"]);
                $obj->setPasajeros(Pasajeros::listarPasajeros("idviaje = " . $resp["idviaje"]));

                // Cargamos el viaje con los datos obtenidos
                $obj->cargarViaje(
                    $resp["idviaje"],
               $resp["vdestino"],
      $resp["vcantmaxpasajeros"],
               $empresa,
          $responsableV,
               $resp["vimporte"],
             $obj->getPasajeros()
                );
                // Agregamos el objeto Viajes al array de viajes
                // Esto permite que cada viaje tenga su propia instancia con los datos cargados
                $arrViajes[] = $obj;
            }
        } else {
            throw new Exception("Error al listar los viajes. SQL: " . $conexion->getError());
        }
        // Retornamos el array de viajes
        return $arrViajes;
    }

    /**
     * Summary of cargar
     * Carga un viaje desde la base de datos según su ID.
     * Si el viaje no existe, lanza una excepción.
     * @throws \Exception
     * @return bool
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        //Creamos la consulta SQL para buscar el viaje por su ID
        $sql = "SELECT * FROM viaje WHERE idviaje = " . $this->getIdViaje();
        //Verificamos conexión a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la base de datos.");
        }
        //Ejecutamos la consulta SQL
        // Si la consulta se ejecuta correctamente, buscamos el viaje
        if ($base->Ejecutar($sql)) {
            // Si se encuentra un viaje, cargamos sus datos en el objeto actual
            // y también cargamos los datos de la empresa y el responsable
            if ($row2 = $base->Registro()) {
                $this->setIdViaje($row2['idviaje']);
                $this->setDestino($row2['vdestino']);
                $this->setCantMaxPasajeros($row2['vcantmaxpasajeros']);
                $this->setImporte($row2['vimporte']);
                // Instanciamos Empresa y ResponsableV para buscar los datos correspondientes
                $empresa = new Empresa();
                $empresa->setId($row2['idempresa']);
                $empresa->buscarEmpresa();
                $this->setEmpresa($empresa);

                $responsable = new ResponsableV();
                $responsable->setNroEmpleado($row2['rnumeroempleado']);
                $responsable->buscarEmpleado($row2['rnumeroempleado']);
                $this->setResponsable($responsable);
                $resp = true;
                // Cargamos los pasajeros del viaje
                // Llamamos al método listarPasajeros para obtener los pasajeros del viaje
                $pasajeros = Pasajeros::listarPasajeros("idviaje = " . $this->getIdViaje());
                $this->setPasajeros($pasajeros);
            }
        } else {
            throw new Exception("Error al ejecutar la consulta sql en la base de datos.");
        }

        // Retornamos true si se cargó correctamente el viaje
        return $resp;
    }

    /**
     * Summary of insertar
     * Inserta un nuevo viaje en la base de datos.
     * @throws \Exception
     * @return bool
     */
    public function insertar()
    {
        $conexion = new BaseDatos();
        //Creamos la consulta SQL para insertar un nuevo viaje
        $query = "INSERT INTO viaje (vdestino, vcantmaxpasajeros,idempresa, rnumeroempleado, vimporte) 
            VALUES ('" . $this->getDestino() . "','" . $this->getCantMaxPasajeros() . "','" . $this->getEmpresa()->getId() . "','" . $this->getResponsable()->getNroEmpleado() . "','" . $this->getImporte() . "')";
        // Verificamos si la conexión a la base de datos se realizó correctamente
        if (!$conexion->Iniciar()) {

            throw new Exception("Error de conexion con la base de datos en método. Traza: " . $conexion->getError());
        }
        // Ejecutamos la consulta y verificamos si se insertó correctamente
        // Si se insertó correctamente, obtenemos el ID del nuevo viaje 
        if ($id = $conexion->devuelveIDInsercion($query)) {
            $this->setIdViaje($id);
            return true;
        } else {
            throw new Exception("Error al insertar un viaje en la base de datos. Traza: " . $conexion->getError());
        }
    }

    /**
     * Summary of actualizar
     * Actualiza un viaje existente en la base de datos.
     * Verifica que los campos a actualizar no estén vacíos antes de construir la consulta.
     * @throws \Exception
     * @return bool
     */
    public function actualizar()
    {

        $conexion = new BaseDatos();
        $updates = [];
        // Verificamos que exista al menos un campo para actualizar
        if (!empty($this->getDestino())) {
            $updates[] = "vdestino='" . $this->getDestino() . "'";
        }
        if (!empty($this->getCantMaxPasajeros())) {
            $updates[] = "vcantmaxpasajeros='" . $this->getCantMaxPasajeros() . "'";
        }
        if (!empty($this->getEmpresa()->getId())) {
            $updates[] = "idempresa='" . $this->getEmpresa()->getId() . "'";
        }
        if (!empty($this->getResponsable()->getNroEmpleado())) {
            $updates[] = "rnumeroempleado='" . $this->getResponsable()->getNroEmpleado() . "'";
        }
        if (!empty($this->getImporte())) {
            $updates[] = "vimporte='" . $this->getImporte() . "'";
        }
        //Creamos la consulta SQL para actualizar el viaje
        $query = "UPDATE viaje SET " . implode(", ", $updates) . " WHERE idviaje = '" . $this->getIdViaje() . "'"; //implode une los campos a actualizar con comas
        $response = false;
        // Verificamos si la conexión a la base de datos se realizó correctamente
        if (!$conexion->Iniciar()) {

            throw new Exception("Error de conexion con la base de datos en método actualizarViaje. Traza: " . $conexion->getError());
        }
        // Ejecutamos la consulta y verificamos si se actualizó correctamente
        // Si se actualizó correctamente, retornamos true
        if ($conexion->Ejecutar($query)) {
            $response = true;
        } else {
            throw new Exception("Error al actualizar un viaje en la base de datos. Traza: " . $conexion->getError());
        }


        return $response;
    }
    /**
     * Summary of eliminarViaje
     * Elimina un viaje de la base de datos según su ID.
     * Verifica que el ID del viaje no esté vacío antes de proceder.
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return bool
     */
    function eliminarViaje()
    {
        $respuesta = false;
        $base = new BaseDatos();
        // Verificamos que el ID del viaje no esté vacío
        // Si está vacío, lanzamos una excepción
        $idV = $this->getIdViaje();
        if (empty($idV)) {
            throw new InvalidArgumentException("El viaje no puede estar vacío");
        }
        // Verificamos si la conexión a la base de datos se realizó correctamente
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Creamos la consulta SQL para eliminar el viaje por su ID
        $consulta = "DELETE FROM `viaje` WHERE idviaje ='" . $idV . "'";
        // Ejecutamos la consulta y verificamos si se eliminó correctamente
        // Si se eliminó correctamente, retornamos true
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta de Eliminar: " . $base->getError());
        } else {
            $respuesta = true;
        }

        return $respuesta;
    }

    /**
     * Summary of mostrarPasajeros
     * Muestra los pasajeros del viaje.
     * Si no hay pasajeros, devuelve un mensaje indicando que no hay pasajeros cargados.
     * @return string
     */
    public function mostrarPasajeros()
    {
        $pasajeros = $this->getPasajeros();
        $response = "";
        if (count($pasajeros) == 0) {
            $response = "No hay pasajeros cargados en este viaje.";
        } else {
            foreach ($pasajeros as $pasajero) {
                $response .= $pasajero->__toString() . "\n";
            }
        }
        return $response;
    }

    // Método para mostrar detalles completos del viaje
    /**
     * Summary of verDetalleCompleto
     * Muestra un detalle completo del viaje, incluyendo ID, destino, importe, capacidad máxima,
     * empresa asignada, responsable asignado y lista de pasajeros.
     * Este método devuelve un string con todos los detalles del viaje.
     * @return string
     */
    public function verDetalleCompleto()
    {
        $detalle = "--- Detalles del Viaje ---\n";
        $detalle .= "ID: " . $this->getIdViaje() . "\n";
        $detalle .= "Destino: " . $this->getDestino() . "\n";
        $detalle .= "Importe: $" . $this->getImporte() . "\n";
        $detalle .= "Capacidad Máxima: " . $this->getCantmaxpasajeros() . "\n";
        $detalle .= "--- Empresa Asignada ---\n" . $this->getEmpresa()->__toString() . "\n"; // Llama al __toString() de Empresa
        $detalle .= "--- Responsable Asignado ---\n" . $this->getResponsable()->__toString() . "\n"; // Llama al __toString() de ResponsableV
        $detalle .= "--- Pasajeros ---\n" . $this->mostrarPasajeros() . "\n"; // Este ya lo tienes, y lo mantendrás detallado aquí
        return $detalle;
    }

    /**
     * Summary of __toString
     * Devuelve una representación en string del viaje.
     * Incluye ID, destino, capacidad actual y máxima, e importe.
     * @return string
     */
    public function __toString()
    {
        return "ID: " . $this->getIdViaje() .
            " | Destino: " . $this->getDestino() .
            " | Capacidad: " . count($this->getPasajeros()) . "/" . $this->getCantmaxpasajeros() .
            " | Importe: $" . $this->getImporte();
    }
}
