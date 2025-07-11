<?php
/* IMPORTANTE !!!!  Clase para (PHP 5, PHP 7)*/

class BaseDatos {
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;
    /**
     * Constructor de la clase que inicia ls variables instancias de la clase
     * vinculadas a la coneccion con el Servidor de BD
     */
    public function __construct(){
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdviajes";
        $this->USUARIO = "root";
        $this->CLAVE="";
        $this->RESULT=0;
        $this->QUERY="";
        $this->ERROR="";
    }
    /**
     * Funcion que retorna una cadena
     * con una peque�a descripcion del error si lo hubiera
     *
     * @return string
     */
    public function getError(){
        return "\n".$this->ERROR;
        
    }
    
    /**
     * Inicia la coneccion con el Servidor y la  Base Datos Mysql.
     * Retorna true si la coneccion con el servidor se pudo establecer y false en caso contrario
     *
     * @return boolean
     */
    public  function Iniciar(){
        $resp  = false;
        $conexion = mysqli_connect($this->HOSTNAME,$this->USUARIO,$this->CLAVE,$this->BASEDATOS);
        if ($conexion){
            if (mysqli_select_db($conexion,$this->BASEDATOS)){
                $this->CONEXION = $conexion;
                unset($this->QUERY);
                unset($this->ERROR);
                $resp = true;
            }  else {
                $this->ERROR = mysqli_errno($conexion) . ": " .mysqli_error($conexion);
            }
        }else{
            $this->ERROR =  mysqli_errno($conexion) . ": " .mysqli_error($conexion);
        }
        return $resp;
    }
    
    /**
     * Ejecuta una consulta en la Base de Datos.
     * Recibe la consulta en una cadena enviada por parametro.
     *
     * @param string $consulta
     * @return boolean
     */
    public function Ejecutar($consulta){
        $resp  = false;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if(  $this->RESULT = mysqli_query( $this->CONEXION,$consulta)){
            $resp = true;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION).": ". mysqli_error( $this->CONEXION);
        }
        return $resp;
    }
    
    /**
     * Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se despleza al siguiente registro de la consulta
     *
     * @return boolean
     */
    public function Registro() {
        $resp = null;
        if ($this->RESULT){
            unset($this->ERROR);
            if($temp = mysqli_fetch_assoc($this->RESULT)){
                $resp = $temp;
            }else{
                mysqli_free_result($this->RESULT);
            }
        }else{
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $resp ;
    }
    
/**
 * Devuelve el id de un campo autoincrement utilizado como clave de una tabla
 * Retorna el id numérico del registro insertado, devuelve null en caso que la ejecución de la consulta falle
 *
 * @param string $consulta
 * @return int|null id de la tupla insertada o null si falla
 */
public function devuelveIDInsercion($consulta) {
    $resp = null;
    unset($this->ERROR);
    $this->QUERY = $consulta;
    
    if ($this->RESULT = mysqli_query($this->CONEXION, $consulta)) {
        // Corrección: Pasar la conexión como parámetro
        $id = mysqli_insert_id($this->CONEXION);
        $resp = $id;
    } else {
        $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
    }
    
    return $resp;
}

public function devuelveIDInsercionSinConsulta() {
    $id = mysqli_insert_id($this->CONEXION);
    return $id > 0 ? $id : null;
}
//Crear funcion que me devuelva el nro de registros
    public function NroRegistros() {
        $resp = 0;
        if ($this->RESULT) {
            unset($this->ERROR);
            $resp = mysqli_num_rows($this->RESULT);
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $resp;
    }
}
?>
