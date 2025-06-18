<?php
class Empresa
{
    private $id;
    private $nombre;
    private $direccion;
    private $viajes;

    public function __construct()
    {
        $this->id = "";
        $this->nombre = "";
        $this->direccion = "";
        $this->viajes = array();
    }


    //InvalidArgumentException es una excepción que indica que un argumento no es válido
    public function setId($id)
    {
        if (!is_numeric($id) && !empty($id)) {
            throw new InvalidArgumentException("El ID debe ser un número o estar vacío.");
        }
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre)) {
            throw new InvalidArgumentException("El nombre de la empresa no puede estar vacío.");
        }
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setDireccion($direccion)
    {
        if (empty($direccion)) {
            throw new InvalidArgumentException("La dirección de la empresa no puede estar vacía.");
        }
        $this->direccion = $direccion;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setViajes($viajes)
    {
        if (!is_array($viajes)) {
            throw new InvalidArgumentException("Los viajes deben ser un array.");
        }
        $this->viajes = $viajes;
    }

    public function getViajes()
    {
        return $this->viajes;
    }

    /**
     * Summary of cargarEmpresa
     * Carga los datos de una empresa
     * @param mixed $id
     * @param mixed $nombre
     * @param mixed $direccion
     * @return void
     */
    public function cargarEmpresa($id, $nombre, $direccion)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }


    /**
     * Summary of listar
     * Lista todas las empresas registradas en la base de datos
     * Si se proporciona una condición, la aplica a la consulta
     * @param mixed $cond
     * @throws \Exception
     * @return array
     */
    public static function listar($cond = "")
    {
        $base = new BaseDatos();
        $arrayEmpresas = array();
        // Creamos la consulta para listar las empresas
        // Si hay una condición, la agregamos a la consulta 
        $query = "SELECT * FROM empresa";
        $query = (!empty($cond)) ? $query . ' WHERE ' . $cond : $query; //? es un operador ternario, si hay una condición, la agrega a la consulta

        // Conectamos a la BD
        // Si la conexión falla, lanzamos una excepción con el error
        if (!$base->Iniciar()) {
            throw new Exception("Error en la conexion a la base de datos " . $base->getError());
        }
        // Ejecutamos la consulta
        // Si la consulta falla, lanzamos una excepción con el error
        if ($base->Ejecutar($query)) {
            // Si la consulta se ejecuta correctamente, iteramos sobre los registros
            // y creamos objetos Empresa para cada registro
            while (($array = $base->Registro()) !== null) {
                $empresa = new Empresa();
                $empresa->cargarEmpresa($array['idempresa'], $array['enombre'], $array['edireccion']);
                $viajes = Viajes::listar("idempresa = " . $array['idempresa']);
                $empresa->setViajes($viajes);
                array_push($arrayEmpresas, $empresa);
            }
        }
        // Si no hay registros, retornamos un array vacío   
        return $arrayEmpresas;
    }

    /**
     * Summary of buscarEmpresa
     * Busca una empresa en la base de datos por su ID
     * Verifica que el ID de la empresa no sea nulo antes de proceder
     * @param int $id
     * @throws \Exception
     * @return bool
     */
    public function buscarEmpresa(): bool
    {
        $base = new BaseDatos();
        $respuesta = false;
        // Verificamos que el ID de la empresa no sea nulo
        // Si el ID es nulo, lanzamos una excepción
        if ($this->getId() == null) {
            throw new Exception("No se puede cargar la empresa desde BD porque el objeto no tiene un id seteado.");
        }

        //Creamos la consulta para buscar la empresa por su ID
        $consulta = "SELECT * FROM empresa WHERE idempresa=" . $this->getId();

        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta: " . $base->getError());
        }
        // Si la consulta se ejecuta correctamente, obtenemos el registro
        // Si no hay registros, retornamos false
        if ($array = $base->Registro()) {
            $this->setNombre($array['enombre'] ?? ''); // ?? es un operador de coalescencia nula, si el valor es nulo, se asigna un valor por defecto
            $this->setDireccion($array['edireccion'] ?? '');
            $respuesta = true;
        }

        return $respuesta;
    }

    /**
     * Summary of insertarEmpresa
     * Inserta una nueva empresa en la base de datos
     * Verifica que los campos necesarios no estén vacíos antes de proceder
     * @throws \Exception
     * @return bool
     */
    public function insertarEmpresa()
    {

        $base = new BaseDatos();
        $respuesta = false;

        // Conectamos a la BD
        // Si la conexión falla, lanzamos una excepción con el error
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Creamos la consulta para insertar la empresa
        // Si la consulta falla, lanzamos una excepción con el error
        $consulta = "INSERT INTO  empresa (enombre,edireccion)
                VALUES ('" . $this->getNombre() . "', 
                        '" . $this->getDireccion() . "')";

        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta Insertar: " . $base->getError());
        } else {
            $respuesta = true;
        }
        // Si la consulta se ejecuta correctamente, retornamos true
        // y la empresa queda registrada en la base de datos
        return $respuesta;
    }



    /**
     * Summary of modificarEmpresa
     * Modifica los datos de una empresa en la base de datos
     * Verifica que el id de la empresa no esté vacío antes de proceder
     * @throws \Exception
     * @return bool
     */
    public function modificarEmpresa()
    {
        $respuesta = false;
        $base = new BaseDatos();

        // Verificamos que el id de la empresa no esté vacío
        $idEmpresa = $this->getId();

        if (empty($idEmpresa)) {
            throw new Exception("Debe tener un idempresa válido para modificar.");
        }

        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }


        // Array para acumular los campos modificados
        $updates = [];

        if (!empty($this->getNombre())) {
            $updates[] = "enombre='" . $this->getNombre() . "'";
        }

        if (!empty($this->getDireccion())) {
            $updates[] = "edireccion='" . $this->getDireccion() . "'";
        }

        // Si no hay cambios, no hacemos nada
        if (count($updates) === 0) {
            throw new Exception("No hay cambios para actualizar.");
        }

        // Armamos y ejecutamos la consulta UPDATE
        $consulta = "UPDATE empresa SET " . implode(", ", $updates) . " WHERE idempresa ='" . $idEmpresa . "'";

        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar la modificación: " . $base->getError());
        }

        $respuesta = true;
        return $respuesta;
    }


    /**
     * Summary of eliminarEmpresa
     * Elimina una empresa de la base de datos
     * Verifica que el id de la empresa no esté vacío antes de proceder
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return bool
     */
    function eliminarEmpresa()
    {
        $respuesta = false;
        $base = new BaseDatos();

        // Verificamos que el id de la empresa no esté vacío
        $idEmpresa = $this->getId();
        if (empty($idEmpresa)) {
            throw new InvalidArgumentException("El id empresa no puede estar vacío");
        }
        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Creamos la consulta para eliminar la empresa
        $consulta = "DELETE FROM `empresa` WHERE idempresa='" . $idEmpresa . "'";
        // Ejecutamos la consulta
        // Si la consulta falla, lanzamos una excepción con el error
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta de Eliminar: " . $base->getError());
        } else {
            $respuesta = true;
        }
        // Si la consulta se ejecuta correctamente, retornamos true
        return $respuesta;
    }

    /**
     * Summary of mostrarViajesDetallado
     * Mostrar los viajes asociados a la empresa de forma detallada
     * @throws \Exception
     * @return string
     */
    public function mostrarViajesDetallado()
    {
        //Asignamos los viajes asociados a la empresa
        $arrViajes = $this->getViajes();
        $strViajes = "  Viajes asociados a " . $this->getNombre() . ":\n";
        //Verificamos si hay viajes asociados a la empresa, si no hay, mostramos un mensaje
        if (empty($arrViajes)) {
            $strViajes .= "    (No hay viajes registrados para esta empresa)\n";
        } else {
            // Iteramos sobre los viajes y los concatenamos a la cadena de texto
            foreach ($arrViajes as $viaje) {
                $strViajes .= "    - " . $viaje->__toString() . "\n";
            }
        }
        // Retornamos la cadena de texto con los viajes
        return $strViajes;
    }

    /**
     * Summary of __toString
     * Método para representar la empresa como una cadena de texto
     * @return string
     */
    public function __toString()
    {
        return "ID: " . $this->getId() . " - Nombre: " . $this->getNombre() . " - Dirección: " . $this->getDireccion();
    }
}
