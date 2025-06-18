<?php
include_once "BaseDatos.php";
include_once "Viajes.php";
class Pasajeros
{

    private $pnombre;
    private $papellido;
    private $pdocumento;
    private $ptelefono;
    private $idviaje;

    //Constructor
    public function __construct()
    {
        $this->pdocumento = '';
        $this->pnombre = '';
        $this->papellido = '';
        $this->ptelefono = '';
        $this->idviaje = new Viajes();
    }



    public function setNombre($nom)
    {
        if (empty($nom)) {
            throw new InvalidArgumentException("El nombre no puede estar vacío");
        }
        $this->pnombre = $nom;
    }
    public function setApellido($ape)
    {
        if (empty($ape)) {
            throw new InvalidArgumentException("El apellido no puede estar vacío");
        }
        $this->papellido = $ape;
    }
    public function setNroDoc($nDoc)
    {
        if (empty($nDoc)) {
            throw new InvalidArgumentException("El número de documento no puede estar vacío");
        }
        if (!is_numeric($nDoc)) {
            throw new InvalidArgumentException("El número de documento debe ser numérico");
        }
        $this->pdocumento = $nDoc;
    }
    public function setTelefono($tel)
    {
        if (empty($tel)) {
            throw new InvalidArgumentException("El teléfono no puede estar vacío");
        }
        $this->ptelefono = $tel;
    }

    public function setViaje($viaje)
    {
        if ($viaje === null || !($viaje instanceof Viajes)) {
            throw new InvalidArgumentException("El viaje debe ser una instancia válida de la clase Viajes");
        }
        $this->idviaje = $viaje;
    }

    public function getNombre()
    {
        return $this->pnombre;
    }
    public function getApellido()
    {
        return $this->papellido;
    }
    public function getNroDoc()
    {
        return $this->pdocumento;
    }
    public function getTelefono()
    {
        return $this->ptelefono;
    }
    public function getViaje()
    {
        return $this->idviaje;
    }

    /**
     * Summary of cargarPasajero
     * @param mixed $nDoc
     * @param mixed $nom
     * @param mixed $ape
     * @param mixed $tel
     * @param mixed $viaje
     * @return void
     */
    public function cargarPasajero($nDoc, $nom, $ape, $tel, $viaje)
    {
        $this->setNroDoc($nDoc);
        $this->setNombre($nom);
        $this->setApellido($ape);
        $this->setTelefono($tel);
        $this->setViaje($viaje);
    }

    //Metodos ORM

    /**
     * Summary of buscarPasajerosXDni
     * Busca un pasajero por DNI y carga sus datos en el objeto
     * Si no encuentra el pasajero, no modifica el objeto actual
     * @param string $dni Número de documento a buscar
     * @throws Exception Si hay error de conexión o consulta
     * @return bool True si encontró el pasajero, false si no
     */
    public function buscarPasajerosXDni($dni): bool
    {
        $base = new BaseDatos();
        if (empty($dni) || !is_numeric($dni)) {
            throw new InvalidArgumentException("El DNI debe ser un número válido");
        }
        //Crear la consulta para buscar el pasajero por DNI
        $consulta = "SELECT * FROM pasajero WHERE pdocumento = '" . $dni . "'";
        $respuesta = false;
        // Iniciar la conexión a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Ejecutar la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta: " . $base->getError());
        }
        // Si se encontró el pasajero, cargar sus datos en el objeto
        // y devolver true, si no se encontró, devolver false
        if ($array = $base->Registro()) {
            $this->setNombre($array['pnombre'] ?? '');
            $this->setApellido($array['papellido'] ?? '');
            $this->setNroDoc($array['pdocumento'] ?? '');
            $this->setTelefono($array['ptelefono'] ?? '');
            $respuesta = true;
        }

        return $respuesta;
    }
    /**
     * Summary of obtenerDatosActuales
     * Devuelve los datos actuales del pasajero según su ID sin modificar el objeto actual
     * Si no encuentra el pasajero, devuelve null
     * @throws Exception Si hay error de conexión o consulta
     * @param int $dni ID del pasajero
     * @return array|null
     */
    public function obtenerDatosActuales($dni)
    {
        $respuesta = null;
        $base = new BaseDatos();
        if (empty($dni) || !is_numeric($dni)) {
            throw new InvalidArgumentException("El DNI debe ser un número válido");
        }
        // Crear la consulta para buscar el pasajero por DNI
        $consulta = "SELECT * FROM pasajero WHERE pdocumento = '" . $dni . "'";
        // Iniciar la conexión a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al iniciar la BD: " . $base->getError());
        }
        // Ejecutar la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar la consulta: " . $base->getError());
        }
        // Si se encontró el pasajero, devolver sus datos en un array
        // Si no se encontró, devolver null
        if ($array = $base->Registro()) {
            $respuesta = $array;
        }

        return $respuesta;
    }


    /**
     * Summary of insertarPasajero
     * Inserta un nuevo pasajero en la base de datos
     * @throws Exception Si hay error de conexión, validación o inserción
     * @return bool True si se insertó correctamente
     */
    public function insertarPasajero()
    {

        $base = new BaseDatos();
        $respuesta = false;

        // Verificar si ya existe el pasajero
        $verificador = new Pasajeros();
        if ($verificador->buscarPasajerosXDni($this->getNroDoc())) {
            throw new Exception("Ya existe un pasajero con el mismo documento.");
        }

        // Validar que el pasajero tenga un viaje asociado
        if ($this->getViaje() === null || $this->getViaje()->getIdViaje() === null) {
            throw new Exception("El pasajero debe estar asociado a un viaje válido");
        }
        //Conectar a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Crear la consulta para insertar el pasajero
        $consulta = "INSERT INTO pasajero (pnombre, papellido, pdocumento, ptelefono, idviaje) 
            VALUES ('" . $this->getNombre() . "', 
                    '" . $this->getApellido() . "', 
                    '" . $this->getNroDoc() . "', 
                    '" . $this->getTelefono() . "', 
                    " . $this->getViaje()->getIdViaje() . ")";
        // Ejecutar la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta Insertar: " . $base->getError());
        }else{
            $respuesta = true;
        }
        return $respuesta;
    }


    /**
     * Summary of modificarPasajero
     * Modifica los datos de un pasajero existente
     * Verifica qué campos cambiaron y actualiza solo esos
     * @throws \Exception
     * @return bool
     */
    public function modificarPasajero()
    {
        $respuesta = false;
        $base = new BaseDatos();


        $dni = $this->getNroDoc();
        //Conexión a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Obtener los datos actuales del pasajero
        $datosActuales = self::obtenerDatosActuales($dni);
        if ($datosActuales == null) {
            throw new Exception("No se encontró el pasajero con ese documento");
        }

        // Verificamos qué campos cambiaron y no están vacíos
        $updates = [];

        if (!empty($this->getNombre()) && $this->getNombre() !== $datosActuales['pnombre']) {
            $updates[] = "pnombre='" . $this->getNombre() . "'";
        }

        if (!empty($this->getApellido()) && $this->getApellido() !== $datosActuales['papellido']) {
            $updates[] = "papellido='" . $this->getApellido() . "'";
        }

        if (!empty($this->getTelefono()) && $this->getTelefono() !== $datosActuales['ptelefono']) {
            $updates[] = "ptelefono='" . $this->getTelefono() . "'";
        }

        if (count($updates) === 0) {
            throw new Exception("No hay cambios para actualizar.");
        }
        // Si hay cambios, armamos la consulta de actualización
        $consulta = "UPDATE pasajero SET  " . implode(", ", $updates) . " WHERE pdocumento='" . $dni . "'";
        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar Modificación: " . $base->getError());
        } else {
            $respuesta = true;
        }

        return $respuesta;
    }

    /**
     * Summary of eliminarPasajero
     * Elimina un pasajero de la base de datos por su DNI
     * Verifica que el DNI no esté vacío y que exista en la base de datos
     * @throws \Exception
     * @return bool
     */
    function eliminarPasajero()
    {
        $respuesta = false;
        $base = new BaseDatos();

        $dni = $this->getNroDoc();

        //Conectamos a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Creamos la consulta para eliminar el pasajero por DNI
        $consulta = "DELETE FROM `pasajero` WHERE pdocumento='" . $dni . "'";
        //Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta de Eliminar: " . $base->getError());
        } else {
            $respuesta = true;
        }

        return $respuesta;
    }

    /**
     * Summary of listarPasajeros
     * Lista todos los pasajeros de la base de datos
     * Si se pasa una condición, la aplica a la consulta
     * @param mixed $condicion
     * @throws \Exception
     * @return array
     */
    static public function listarPasajeros($condicion = '')
    {
        $arrayPersona = [];
        $base = new BaseDatos();
        // Validar la condición
        if (!empty($condicion) && !is_string($condicion)) {
            throw new InvalidArgumentException("La condición debe ser una cadena de texto");
        }
        // Si la condición no es una cadena vacía, la agregamos a la consulta
        $consulta = "SELECT * FROM `pasajero`";
        $consulta = (!empty($condicion)) ? $consulta . ' WHERE ' . $condicion : $consulta;

        // Iniciar la conexión a la base de datos
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Ejecutar la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta: " . $base->getError());
        }
        // Recorrer los resultados y crear objetos Pasajeros
        while (($array = $base->Registro()) !== null) {
            $nroDoc = $array['pdocumento'];
            $nom = $array['pnombre'];
            $ape = $array['papellido'];
            $tel = $array['ptelefono'];
            $idViaje = $array['idviaje'];
            // Crear un nuevo objeto Pasajeros y cargar sus datos
            $pasajero = new Pasajeros();
            $pasajero->cargarPasajero($nroDoc, $nom, $ape, $tel, $idViaje);
            array_push($arrayPersona, $pasajero);
        }
        return $arrayPersona;
    }

    /**
     * Summary of __toString
     * Devuelve una representación en cadena del pasajero
     * Incluye DNI, nombre, apellido y teléfono
     * @return string
     */
    public function __toString() {
        return "DNI: " . $this->getNroDoc() . " - " . $this->getApellido() . ", " . $this->getNombre() . " - Teléfono: " . $this->getTelefono();
    }
}
