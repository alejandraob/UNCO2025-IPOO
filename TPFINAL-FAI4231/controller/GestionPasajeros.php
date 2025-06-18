<?php
// GestionPasajeros.php
/* Este script permite gestionar los pasajeros de un viaje.
  Incluye funciones para agregar, modificar y eliminar pasajeros,
  así como un menú para seleccionar el viaje y realizar las operaciones.
 */
require_once 'utils/funciones_comunes.php'; // Para limpiar pantalla y pausar
require_once 'datos/BaseDatos.php'; // Para la conexión a la base de datos
require_once 'datos/Empresa.php'; // Para buscar empresas si es necesario
require_once 'datos/ResponsableV.php'; // Para buscar responsables si es necesario
require_once 'datos/Viajes.php'; // Para buscar viajes y sus pasajeros
require_once 'datos/Pasajeros.php'; // Para manejar los pasajeros

/**
 * Summary of agregarPasajero
 * Esta función permite agregar un nuevo pasajero a un viaje.
 * Solicita al usuario el documento, nombre, apellido y teléfono del pasajero.
 * Valida que el pasajero no exista en ningún viaje y que el viaje no haya alcanzado su capacidad máxima.
 * @param mixed $viaje
 * @throws \Exception
 * @return void
 */
function agregarPasajero($viaje) {
    limpiarPantalla();
    echo "======== AGREGAR PASAJERO ========\n";
    try {
        if (count($viaje->getPasajeros()) >= $viaje->getCantMaxPasajeros()) {
            throw new Exception("El viaje ya alcanzó su capacidad máxima de pasajeros.");
        }
        
        echo "Ingrese documento del pasajero: ";
        $doc = trim(fgets(STDIN));

        // Validar si el pasajero con ese DNI ya existe en CUALQUIER viaje
        $pasajeroExistente = Pasajeros::listarPasajeros("pdocumento = '{$doc}'");
        if (!empty($pasajeroExistente)) {
            throw new Exception("Ya existe un pasajero con el DNI {$doc}. Un pasajero no puede estar en múltiples viajes.");
        }
        
        echo "Ingrese nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese apellido: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingrese teléfono: ";
        $telefono = trim(fgets(STDIN));
        
        $pasajero = new Pasajeros();
        $pasajero->cargarPasajero($doc, $nombre, $apellido, $telefono, $viaje); 
        
        if ($pasajero->insertarPasajero()) {
            echo "✅ Pasajero agregado correctamente\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    
    pausar();
}
/**
 * Summary of modificarPasajero
 * Esta función permite modificar los datos de un pasajero existente en un viaje.
 * Solicita al usuario seleccionar un pasajero, luego permite cambiar su nombre, apellido y teléfono.
 * @param mixed $viaje
 * @throws \Exception
 * @return void
 */
function modificarPasajero($viaje) {
    limpiarPantalla();
    echo "======== MODIFICAR PASAJERO ========\n";
    try {
        $pasajeros = $viaje->getPasajeros();
        if (empty($pasajeros)) {
            throw new Exception("No hay pasajeros en este viaje para modificar.");
        }
        
        echo "Seleccione un pasajero:\n";
        foreach ($pasajeros as $index => $pasajero) {
            echo ($index + 1) . ". " . $pasajero->getApellido() . ", " . $pasajero->getNombre() . 
                 " (DNI: " . $pasajero->getNroDoc() . ")\n";
        }
        echo "Opción: ";
        $opcionPasajero = (int)trim(fgets(STDIN)) - 1;

        if (!isset($pasajeros[$opcionPasajero])) {
            throw new Exception("Opción de pasajero inválida.");
        }
        $pasajero = $pasajeros[$opcionPasajero];
        
        echo "Pasajero seleccionado:\n" . $pasajero . "\n";
        
        echo "Nuevo nombre (actual: " . $pasajero->getNombre() . ", dejar vacío para no modificar): ";
        $nombre = trim(fgets(STDIN));
        if (!empty($nombre)) {
            $pasajero->setNombre($nombre);
        }
        
        echo "Nuevo apellido (actual: " . $pasajero->getApellido() . ", dejar vacío para no modificar): ";
        $apellido = trim(fgets(STDIN));
        if (!empty($apellido)) {
            $pasajero->setApellido($apellido);
        }
        
        echo "Nuevo teléfono (actual: " . $pasajero->getTelefono() . ", dejar vacío para no modificar): ";
        $telefono = trim(fgets(STDIN));
        if (!empty($telefono)) {
            $pasajero->setTelefono($telefono);
        }
        
        if ($pasajero->modificarPasajero()) {
            echo "✅ Pasajero modificado correctamente\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    
    pausar();
}
/**
 * Summary of eliminarPasajero
 * Esta función permite eliminar un pasajero de un viaje.
 * Solicita al usuario seleccionar un pasajero y confirma la eliminación.
 * @param mixed $viaje
 * @throws \Exception
 * @return void
 */
function eliminarPasajero($viaje) {
    limpiarPantalla();
    echo "======== ELIMINAR PASAJERO ========\n";
    try {
        $pasajeros = $viaje->getPasajeros();
        if (empty($pasajeros)) {
            throw new Exception("No hay pasajeros en este viaje para eliminar.");
        }
        
        echo "Seleccione un pasajero a eliminar:\n";
        foreach ($pasajeros as $index => $pasajero) {
            echo ($index + 1) . ". " . $pasajero->getApellido() . ", " . $pasajero->getNombre() . 
                 " (DNI: " . $pasajero->getNroDoc() . ")\n";
        }
        echo "Opción: ";
        $opcionPasajero = (int)trim(fgets(STDIN)) - 1;

        if (!isset($pasajeros[$opcionPasajero])) {
            throw new Exception("Opción de pasajero inválida.");
        }
        $pasajero = $pasajeros[$opcionPasajero];
        
        echo "¿Está seguro que desea eliminar al pasajero?\n" . $pasajero . "\n(S/N): ";
        $confirmacion = strtoupper(trim(fgets(STDIN)));
        
        if ($confirmacion === 'S') {
            if ($pasajero->eliminarPasajero()) {
                echo "✅ Pasajero eliminado correctamente\n";
            }
        } else {
            echo "Operación cancelada\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    
    pausar();
}

// --- Menú de Gestión de Pasajeros 
function gestionarPasajeros() {
    try {
        // Seleccionar viaje
        $viajes = Viajes::listar();
        if (empty($viajes)) {
            throw new Exception("No hay viajes registrados. Debe crear un viaje primero.");
        }
        
        echo "Seleccione un viaje para gestionar sus pasajeros:\n";
        foreach ($viajes as $index => $viaje) {
            echo ($index + 1) . ". ID: " . $viaje->getIdViaje() . " - Destino: " . $viaje->getDestino() . 
                 " - Pasajeros: " . count($viaje->getPasajeros()) . "/" . $viaje->getCantMaxPasajeros() . "\n";
        }
        echo "Opción: ";
        $opcionViaje = (int)trim(fgets(STDIN)) - 1;

        if (!isset($viajes[$opcionViaje])) {
            throw new Exception("Opción de viaje inválida.");
        }
        $viaje = $viajes[$opcionViaje];
        
        // Menú de pasajeros
        do {
            limpiarPantalla();
            echo "=== GESTIÓN DE PASAJEROS DEL VIAJE ===\n";
            echo "Viaje seleccionado: ID " . $viaje->getIdViaje() . " - " . $viaje->getDestino() . "\n";
            echo "Pasajeros actuales (" . count($viaje->getPasajeros()) . "/" . $viaje->getCantMaxPasajeros() . "):\n";
            echo $viaje->mostrarPasajeros() . "\n"; 
            
            echo "1. Agregar pasajero\n";
            echo "2. Modificar pasajero\n";
            echo "3. Eliminar pasajero\n";
            echo "0. Volver\n";
            echo "Seleccione una opción: ";
            $opcion = trim(fgets(STDIN));
            
            switch ($opcion) {
                case '1':
                    agregarPasajero($viaje);
                    // Recargamos los pasajeros del viaje para actualizar la vista del sub-menú
                    $viaje->setPasajeros(Pasajeros::listarPasajeros("idviaje = " . $viaje->getIdViaje()));
                    break;
                case '2':
                    modificarPasajero($viaje);
                    $viaje->setPasajeros(Pasajeros::listarPasajeros("idviaje = " . $viaje->getIdViaje()));
                    break;
                case '3':
                    eliminarPasajero($viaje);
                    $viaje->setPasajeros(Pasajeros::listarPasajeros("idviaje = " . $viaje->getIdViaje()));
                    break;

                case '0':
                    break;
                default:
                    echo "Opción inválida.\n";
                    pausar();
            }
        } while ($opcion !== '0');
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        pausar();
    }
}
// Llamada a la función principal para gestionar pasajeros
gestionarPasajeros();
?>