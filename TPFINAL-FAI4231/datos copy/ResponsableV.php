<?php
class ResponsableV
{
    private $nroEmpleado;
    private $nroLicencia;

    private $nombre;
    private $apellido;

    public function __construct()
    {
        $this->nroEmpleado = '';
        $this->nroLicencia = '';
        $this->nombre = '';
        $this->apellido = '';
    }

    public function setNroEmpleado($nroEmpleado)
    {
        $this->nroEmpleado = $nroEmpleado;
    }
    public function setNroLicencia($nroLicencia)
    {
        if (empty($nroLicencia)) {
            throw new InvalidArgumentException("El número de licencia no puede estar vacío");
        }
        if (!is_numeric($nroLicencia)) {
            throw new InvalidArgumentException("El número de licencia debe ser numérico");
        }
        $this->nroLicencia = $nroLicencia;
    }
    public function setNombre($nombre)
    {
        if (empty($nombre)) {
            throw new InvalidArgumentException("El nombre no puede estar vacío");
        }
        $this->nombre = $nombre;
    }
    public function setApellido($apellido)
    {
        if (empty($apellido)) {
            throw new InvalidArgumentException("El apellido no puede estar vacío");
        }
        $this->apellido = $apellido;
    }

    public function getNroEmpleado()
    {
        return $this->nroEmpleado;
    }
    public function getNroLicencia()
    {
        return $this->nroLicencia;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Summary of cargarEmpleado
     * @param mixed $nroEmp
     * @param mixed $nLic
     * @param mixed $nomE
     * @param mixed $apeE
     * @return void
     */
    public function cargarEmpleado($nroEmp, $nLic, $nomE, $apeE)
    {
        $this->setNroEmpleado($nroEmp);
        $this->setNroLicencia($nLic);
        $this->setNombre($nomE);
        $this->setApellido($apeE);
    }


    /**
     * Summary of buscarEmpleado
     * Busca un empleado por número de empleado o número de licencia.
     * Si se proporciona ambos, buscará por ambos criterios.
     * Si no se encuentra, devuelve false.
     * @param mixed $nEmp
     * @param mixed $nlic
     * @throws \Exception
     * @return bool
     */
    public function buscarEmpleado($nEmp = '', $nlic = ''): bool
    {
        $base = new BaseDatos();
        $respuesta = false;
        // Validamos los parámetros de entrada
        if (empty($nEmp) && empty($nlic)) {
            throw new InvalidArgumentException("Debe proporcionar al menos un número de empleado o licencia");
        }
        if (!is_numeric($nEmp) && !empty($nEmp)) {
            throw new InvalidArgumentException("El número de empleado debe ser numérico");
        }
        if (!is_numeric($nlic) && !empty($nlic)) {
            throw new InvalidArgumentException("El número de licencia debe ser numérico");
        }
        // Construimos la consulta
        // Si ambos parámetros están vacíos, no se ejecuta la consulta
        $consulta = "SELECT * FROM `responsable`";

        // Si se proporciona un número de empleado o licencia, se agrega a la consulta
        if (!empty($nEmp) and empty($nlic)) {
            $consulta .= " WHERE rnumeroempleado='" . $nEmp . "'";
        } else if (empty($nEmp) and !empty($nlic)) {
            $consulta .= " WHERE rnumerolicencia='" . $nlic . "'";
        } else {
            $consulta .= " WHERE rnumerolicencia='" . $nlic . "' AND rnumeroempleado='" . $nEmp . "'";
        }
        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }

        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta: " . $base->getError());
        }
        // Si se encuentra un registro, cargamos los datos en el objeto
        // y devolvemos true
        if ($array = $base->Registro()) {
            $this->setNroEmpleado($array['rnumeroempleado'] ?? '');
            $this->setNroLicencia($array['rnumerolicencia'] ?? '');
            $this->setNombre($array['rnombre'] ?? '');
            $this->setApellido($array['rapellido'] ?? '');
            $respuesta = true;
        }

        return $respuesta;
    }

    /**
     * Summary of obtenerDatosActualesResponsable
     * Obtiene los datos actuales del responsable según su número de empleado o número de licencia.
     * Si se proporciona ambos, buscará por ambos criterios.
     * @param mixed $nroResponsable
     * @throws \Exception
     * @return bool|null
     */
    public function obtenerDatosActualesResponsable($nroResponsable = '', $nlic = '')
    {
        $respuesta = null;
        $base = new BaseDatos();
        // Validamos los parámetros de entrada
        if (empty($nroResponsable) && empty($nlic)) {
            throw new InvalidArgumentException("Debe proporcionar al menos un número de empleado o licencia");
        }
        if (!is_numeric($nroResponsable) && !empty($nroResponsable)) {
            throw new InvalidArgumentException("El número de empleado debe ser numérico");
        }
        if (!is_numeric($nlic) && !empty($nlic)) {
            throw new InvalidArgumentException("El número de licencia debe ser numérico");
        }
        // Conectamos a la BD

        if (!$base->Iniciar()) {
            throw new Exception("Error al iniciar la BD: " . $base->getError());
        }
        // Construimos la consulta
        $consulta = "SELECT * FROM responsable WHERE rnumeroempleado = '" . $nroResponsable . "'";
        // Si se proporciona un número de empleado o licencia, se agrega a la consulta
        if (!empty($nroResponsable) and empty($nlic)) {
            $consulta .= " WHERE rnumeroempleado='" . $nroResponsable . "'";
        } else if (empty($nroResponsable) and !empty($nlic)) {
            $consulta .= " WHERE rnumerolicencia='" . $nlic . "'";
        } else {
            $consulta .= " WHERE rnumerolicencia='" . $nlic . "' AND rnumeroempleado='" . $nroResponsable . "'";
        }
        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar la consulta: " . $base->getError());
        }
        // Si se encuentra un registro, devolvemos el array con los datos   
        // y devolvemos true
        if ($array = $base->Registro()) {
            $respuesta = $array;
        }

        return $respuesta;
    }

    /**
     * Summary of insertarEmpleado
     * Inserta un nuevo empleado en la base de datos.
     * Valida que no exista otro empleado con la misma licencia.
     * @throws \Exception
     * @return bool
     */
    public function insertarEmpleado()
    {
        $base = new BaseDatos();
        $respuesta = false;

        // Verificar empleado
        $verificador = new ResponsableV();
        if ($verificador->buscarEmpleado($this->getNroLicencia())) {
            throw new Exception("Ya existe un empleado con misma licencia registrada");
        }

        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Creamos la consulta de inserción
        $consulta = "INSERT INTO `responsable`(
                            `rnumerolicencia`,
                            `rnombre`,
                            `rapellido`
                        )
            VALUES ('" . $this->getNroLicencia() . "', 
                    '" . $this->getNombre() . "', 
                    '" . $this->getApellido() . "')";
        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta Insertar: " . $base->getError());
        } else {
            $respuesta = true;
        }
        return $respuesta;
    }


    /**
     * Summary of modificarPasajero
     * Modifica los datos de un pasajero existente.
     * Verifica si el número de empleado es válido y si hay cambios en los datos.
     * @throws \Exception
     * @return bool
     */
    public function modificarPasajero()
    {
        $respuesta = false;
        $base = new BaseDatos();

        // Tomamos el número de empleado para usar como identificador
        $nroEmpleado = $this->getNroEmpleado();
        // Validamos que el número de empleado no esté vacío
        if (empty($nroEmpleado)) {
            throw new Exception("Debe tener un número de empleado válido para modificar.");
        }

        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }

        // Traemos los datos actuales del empleado
        $datosActuales = self::obtenerDatosActualesResponsable($nroEmpleado);

        // Validamos que se haya encontrado un registro
        if (!is_array($datosActuales)) {
            throw new Exception("No se encontró el empleado con ese número.");
        }

        // Array para acumular los campos modificados
        $updates = [];

        // Verificamos uno por uno si cambió algún dato
        if (!empty($this->getNroLicencia()) && $this->getNroLicencia() !== $datosActuales['rnumerolicencia']) {
            $updates[] = "rnumerolicencia='" . $this->getNroLicencia() . "'";
        }

        if (!empty($this->getNombre()) && $this->getNombre() !== $datosActuales['rnombre']) {
            $updates[] = "rnombre='" . $this->getNombre() . "'";
        }

        if (!empty($this->getApellido()) && $this->getApellido() !== $datosActuales['rapellido']) {
            $updates[] = "rapellido='" . $this->getApellido() . "'";
        }

        // Si no hay cambios, no hacemos nada
        if (count($updates) === 0) {
            throw new Exception("No hay cambios para actualizar.");
        }

        // Armamos y ejecutamos la consulta UPDATE
        $consulta = "UPDATE responsable SET " . implode(", ", $updates) . " WHERE rnumeroempleado ='" . $nroEmpleado . "'";

        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar la modificación: " . $base->getError());
        }

        $respuesta = true;
        return $respuesta;
    }

    /**
     * Summary of eliminarEmpleado
     * Elimina un empleado de la base de datos.
     * Verifica que el número de empleado no esté vacío.
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return bool
     */
    function eliminarEmpleado()
    {
        $respuesta = false;
        $base = new BaseDatos();

        $nroEmp = $this->getNroEmpleado();
        // Validamos que el número de empleado no esté vacío
        if (empty($nroEmp)) {
            throw new InvalidArgumentException("El nroEmpleado no puede estar vacío");
        }
        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        //Creamos la consulta de eliminación
        $consulta = "DELETE FROM `responsable` WHERE rnumeroempleado='" . $nroEmp . "'";
        // Ejecutamos la consulta
        // Si no se encuentra el empleado, no se puede eliminar
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta de Eliminar: " . $base->getError());
        } else {
            $respuesta = true;
        }

        return $respuesta;
    }
    /**
     * Summary of listarEmpleado
     * Lista todos los empleados o filtra por una condición específica.
     * Si se proporciona una condición, se agrega a la consulta SQL.
     * @param mixed $condicion
     * @throws \Exception
     * @return array
     */
    static public function listarEmpleado($condicion = '')
    {
        $arrayEmpleado = [];
        $base = new BaseDatos();
        //Creamos la consulta de selección
        // Si se proporciona una condición, se agrega a la consulta
        $consulta = "SELECT * FROM `responsable`";
        //validamos la condición
        if (!empty($condicion) && !is_string($condicion)) {
            throw new InvalidArgumentException("La condición debe ser una cadena de texto");
        }
        // Si la condición no está vacía, la agregamos a la consulta
        $consulta = (!empty($condicion)) ? $consulta . ' WHERE ' . $condicion : $consulta;

        // Conectamos a la BD
        if (!$base->Iniciar()) {
            throw new Exception("Error al conectar a la BD: " . $base->getError());
        }
        // Ejecutamos la consulta
        if (!$base->Ejecutar($consulta)) {
            throw new Exception("Error al ejecutar consulta: " . $base->getError());
        }
        // Recorremos los resultados y los agregamos al array
        // Si no hay resultados, devolvemos un array vacío
        while (($array = $base->Registro()) !== null) {
            $nroEmp = $array['rnumeroempleado'];
            $nroLic = $array['rnumerolicencia'];
            $nomEmp = $array['rnombre'];
            $ApeEmp = $array['rapellido'];

            // Creamos un nuevo objeto ResponsableV y lo cargamos con los datos
            $empleado = new ResponsableV();
            $empleado->cargarEmpleado($nroEmp, $nroLic, $nomEmp, $ApeEmp);
            array_push($arrayEmpleado, $empleado);
        }
        return $arrayEmpleado;
    }

    /**
     * Summary of __toString
     * Devuelve una representación en cadena del objeto ResponsableV.
     * Incluye el ID del empleado, nombre, apellido y número de licencia.
     * @return string
     */
    public function __toString()
    {
        return "ID: " . $this->getNroEmpleado() . " - Nombre: " . $this->getApellido() . ", " . $this->getNombre() . " - Licencia: " . $this->getNroLicencia();
    }
}
