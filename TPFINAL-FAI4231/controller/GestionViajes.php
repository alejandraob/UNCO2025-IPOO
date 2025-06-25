<?php
// GestionViajes.php
/*
     Este archivo contiene las funciones para gestionar los viajes en el sistema.
     Permite dar de alta, modificar, eliminar y listar viajes.
     Utiliza las clases Empresa, ResponsableV, Viajes y Pasajeros para manejar los datos.
*/

require_once 'utils/funciones_comunes.php'; // Para limpiar pantalla y pausar
require_once 'datos/BaseDatos.php'; // Para la conexión a la base de datos
require_once 'datos/Empresa.php';
require_once 'datos/ResponsableV.php';
require_once 'datos/Viajes.php';
require_once 'datos/Pasajeros.php';

/**
 * Summary of altaViaje
 * Esta función permite dar de alta un nuevo viaje.
 * Solicita al usuario el destino, importe y cantidad máxima de pasajeros.
 * Luego, permite seleccionar una empresa y un responsable de viaje.
 * Crea un objeto Viajes y lo inserta en la base de datos.
 * @throws \Exception
 * @return void
 */
function altaViaje()
{
    limpiarPantalla();
    echo "======== ALTA DE VIAJE ========\n";
    try {
        echo "Ingrese destino: ";
        $destino = trim(fgets(STDIN));
        echo "Ingrese importe: ";
        $importe = trim(fgets(STDIN));
        echo "Ingrese cantidad máxima de pasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));

        // Seleccionar empresa
        $empresas = Empresa::listar();
        if (empty($empresas)) {
            throw new Exception("No hay empresas registradas. Debe crear una empresa primero.");
        }

        echo "Seleccione una empresa:\n";
        foreach ($empresas as $index => $emp) {
            echo ($index + 1) . ". " . $emp->getNombre() . " (ID: " . $emp->getId() . ")\n";
        }
        echo "Opción: ";
        $opcionEmpresa = (int)trim(fgets(STDIN)) - 1;

        if (!isset($empresas[$opcionEmpresa])) {
            throw new Exception("Opción de empresa inválida.");
        }
        $empresa = $empresas[$opcionEmpresa];

        // Seleccionar responsable
        $responsables = ResponsableV::listarEmpleado();
        if (empty($responsables)) {
            throw new Exception("No hay responsables registrados. Debe crear un responsable primero.");
        }

        echo "Seleccione un responsable:\n";
        foreach ($responsables as $index => $resp) {
            echo ($index + 1) . ". " . $resp->getNombre() . " " . $resp->getApellido() . " (ID: " . $resp->getNroEmpleado() . ")\n";
        }
        echo "Opción: ";
        $opcionResponsable = (int)trim(fgets(STDIN)) - 1;

        if (!isset($responsables[$opcionResponsable])) {
            throw new Exception("Opción de responsable inválida.");
        }
        $responsable = $responsables[$opcionResponsable];

        // Crear viaje
        $viaje = new Viajes();
        // Los pasajeros se inicializan como array vacío en la carga de un viaje nuevo
        $viaje->cargarViaje(null, $destino, $cantMaxPasajeros, $empresa, $responsable, $importe, array());

        if ($viaje->insertar()) {
            echo "✅ Viaje creado con ID: " . $viaje->getIdViaje() . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    
    pausar();
}

/**
 * Summary of modificarViaje
 * Esta función permite modificar un viaje existente.
 * Solicita al usuario el ID del viaje a modificar y muestra los datos actuales.
 * Permite cambiar el destino, importe y cantidad máxima de pasajeros.
 * @throws \Exception
 * @return void
 */
function modificarViaje()
{
    limpiarPantalla();
    echo "======== MODIFICAR VIAJE ========\n";
    try {
        echo "Ingrese ID del viaje a modificar: ";
        $id = trim(fgets(STDIN));

        $viaje = new Viajes();
        $viaje->setIdViaje($id);

        if (!$viaje->cargar()) {
            throw new Exception("No se encontró el viaje con ID $id");
        }

        echo "Viaje actual:\n" . $viaje . "\n";

        echo "Nuevo destino (dejar vacío para no modificar): ";
        $destino = trim(fgets(STDIN));
        if (!empty($destino)) {
            $viaje->setDestino($destino);
        }

        echo "Nuevo importe (dejar vacío para no modificar): ";
        $importe = trim(fgets(STDIN));
        if (!empty($importe)) {
            $viaje->setImporte($importe);
        }

        echo "Nueva cantidad máxima de pasajeros (dejar vacío para no modificar): ";
        $cantMax = trim(fgets(STDIN));
        if (!empty($cantMax)) {
            $viaje->setCantMaxPasajeros($cantMax);
        }

        if ($viaje->actualizar()) {
            echo "✅ Viaje modificado correctamente\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();
}

/**
 * Summary of eliminarViaje
 * Esta función permite eliminar un viaje existente.
 * Solicita al usuario el ID del viaje a eliminar y muestra los datos actuales.
 * Confirma la eliminación antes de proceder.
 * Si el viaje se encuentra y se elimina correctamente, muestra un mensaje de éxito.
 * @throws \Exception
 * @return void
 */
function eliminarViaje()
{
    limpiarPantalla();
    echo "======== ELIMINAR VIAJE ========\n";
    try {
        echo "Ingrese ID del viaje a eliminar: ";
        $id = trim(fgets(STDIN));

        $viaje = new Viajes();
        $viaje->setIdViaje($id);

        if (!$viaje->cargar()) {
            throw new Exception("No se encontró el viaje con ID $id");
        }

        echo "¿Está seguro que desea eliminar el viaje?\n" . $viaje . "\n(S/N): ";
        $confirmacion = strtoupper(trim(fgets(STDIN)));

        if ($confirmacion === 'S') {
            if ($viaje->eliminarViaje()) {
                echo "✅ Viaje eliminado correctamente\n";
            }
        } else {
            echo "Operación cancelada\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();
}

/**
 * Summary of verViajes
 * Esta función permite ver todos los viajes registrados en el sistema.
 * Muestra un listado con los detalles de cada viaje, incluyendo destino, importe,
 * cantidad máxima de pasajeros, empresa y responsable.
 * Si no hay viajes registrados, muestra un mensaje indicando que no hay viajes.
 * @return void
 */
function verViajes()
{
    limpiarPantalla();
    echo "======== LISTADO DE VIAJES ========\n";
    try {
        $viajes = Viajes::listar();

        if (empty($viajes)) {
            echo "No hay viajes registrados.\n";
        } else {
            foreach ($viajes as $viaje) {
                echo $viaje->verDetalleCompleto();
                echo "----------------------------------------\n";
            }
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();
}

// --- Menú de Gestión de Viajes ---
do {
    limpiarPantalla();
    echo "=== GESTIÓN DE VIAJES ===\n";
    echo "1. Alta de viaje\n";
    echo "2. Modificar viaje\n";
    echo "3. Eliminar viaje\n";
    echo "4. Ver todos los viajes\n";
    echo "0. Volver al menú principal\n";
    echo "Seleccione una opción: ";
    $opcionViaje = trim(fgets(STDIN));

    switch ($opcionViaje) {
        case '1':
            altaViaje();
            break;
        case '2':
            modificarViaje();
            break;
        case '3':
            eliminarViaje();
            break;
        case '4':
            verViajes();
            break;
        case '0':
            break;
        default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
            pausar();
    }
} while ($opcionViaje !== '0');
