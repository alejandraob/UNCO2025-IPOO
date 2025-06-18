<?php
// GestionEmpresas.php
/*
Este script maneja la gestión de empresas en un sistema de viajes.
Permite realizar operaciones de alta, modificación, eliminación y visualización de empresas.
*/
//Llamadas a archivos necesarios
require_once 'utils/funciones_comunes.php'; // Para limpiar pantalla y pausar
require_once 'datos/BaseDatos.php'; // Para la conexión a la base de datos
require_once 'datos/Empresa.php'; // Para buscar empresas si es necesario
require_once 'datos/ResponsableV.php'; // Para buscar responsables si es necesario
require_once 'datos/Viajes.php'; // Para buscar viajes y sus pasajeros
require_once 'datos/Pasajeros.php'; // Para manejar los pasajeros

// Funciones para gestionar empresas

/**
 * Summary of altaEmpresa
 * Esta función permite dar de alta una nueva empresa.
 * Solicita al usuario el nombre y dirección de la empresa, crea un objeto Empresa,
 * y lo inserta en la base de datos.
 * Si la inserción es exitosa, muestra el ID de la empresa registrada.
 * @return void
 */
function altaEmpresa()
{
    limpiarPantalla(); // Limpia la pantalla antes de mostrar el menú, esta funcion viene del archivo funciones_comunes.php
    // Muestra el título de la sección
    echo "======== ALTA DE EMPRESA ========\n";
    //try-catch para manejar excepciones
    try {
        // Se solicita al usuario ingresar el nombre y dirección de la empresa
        echo "Ingrese nombre de la empresa: ";
        // Se utiliza trim para eliminar espacios en blanco al inicio y al final
        // fgets(STDIN) lee la entrada del usuario desde la consola
        $nombre = trim(fgets(STDIN));
        echo "Ingrese dirección: ";
        $direccion = trim(fgets(STDIN));

        // Se crea un nuevo objeto Empresa
        $empresa = new Empresa();
        // Se utiliza el método cargarEmpresa para inicializar los atributos de la empresa
        $empresa->cargarEmpresa(null, $nombre, $direccion);
        // Se intenta insertar la empresa en la base de datos
        // Si la inserción es exitosa, se muestra un mensaje de éxito con el ID de la empresa
        if ($empresa->insertarEmpresa()) {
            echo "✅ Empresa registrada con ID: " . $empresa->getId() . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();   // Pausa la ejecución para que el usuario pueda leer el mensaje
}

/**
 * Summary of modificarEmpresa
 * Esta función permite modificar los datos de una empresa existente.
 * Solicita al usuario el ID de la empresa a modificar, busca la empresa en la base de datos,
 * y permite al usuario cambiar el nombre y/o dirección.
 * Si la empresa se encuentra y se modifica correctamente, muestra un mensaje de éxito.
 * @throws \Exception
 * @return void
 */
function modificarEmpresa()
{
    limpiarPantalla();
    echo "======== MODIFICAR EMPRESA ========\n";
    try {
        echo "Ingrese ID de la empresa a modificar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        $empresa->setId($id);

        if (!$empresa->buscarEmpresa()) {
            throw new Exception("No se encontró la empresa con ID $id");
        }

        echo "Empresa actual:\n" . $empresa . "\n";

        echo "Nuevo nombre (dejar vacío para no modificar): ";
        $nombre = trim(fgets(STDIN));
        if (!empty($nombre)) {
            $empresa->setNombre($nombre);
        }

        echo "Nueva dirección (dejar vacío para no modificar): ";
        $direccion = trim(fgets(STDIN));
        if (!empty($direccion)) {
            $empresa->setDireccion($direccion);
        }

        if ($empresa->modificarEmpresa()) {
            echo "✅ Empresa modificada correctamente\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();
}
/**
 * Summary of eliminarEmpresa
 * Esta función permite eliminar una empresa existente.
 * Solicita al usuario el ID de la empresa a eliminar, busca la empresa en la base de datos,
 * y solicita confirmación antes de proceder con la eliminación.
 * Si la empresa se encuentra y se elimina correctamente, muestra un mensaje de éxito.
 * Si la empresa no se encuentra, lanza una excepción con un mensaje de error.
 * @throws \Exception
 * @return void
 */
function eliminarEmpresa()
{
    limpiarPantalla();
    echo "======== ELIMINAR EMPRESA ========\n";
    try {
        echo "Ingrese ID de la empresa a eliminar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        $empresa->setId($id);

        if (!$empresa->buscarEmpresa()) {
            throw new Exception("No se encontró la empresa con ID $id");
        }

        echo "¿Está seguro que desea eliminar la empresa?\n" . $empresa . "\n(S/N): ";
        $confirmacion = strtoupper(trim(fgets(STDIN)));

        if ($confirmacion === 'S') {
            if ($empresa->eliminarEmpresa()) {
                echo "✅ Empresa eliminada correctamente\n";
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
 * Summary of verEmpresas
 * Esta función muestra un listado de todas las empresas registradas en el sistema.
 * Utiliza el método listar de la clase Empresa para obtener todas las empresas.
 * @return void
 */
function verEmpresas()
{
    limpiarPantalla();
    echo "======== LISTADO DE EMPRESAS ========\n";
    try {
        $empresas = Empresa::listar();

        if (empty($empresas)) {
            echo "No hay empresas registradas.\n";
        } else {
            foreach ($empresas as $empresa) {
                echo $empresa->__toString() . "\n";
                echo $empresa->mostrarViajesDetallado() . "\n";
                echo "---------------------------------------- \n";
            }
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    pausar();
}

// --- Menú de Gestión de Empresas ---
do {
    limpiarPantalla();
    echo "=== GESTIÓN DE EMPRESAS ===\n";
    echo "1. Alta de empresa\n";
    echo "2. Modificar empresa\n";
    echo "3. Eliminar empresa\n";
    echo "4. Ver todas las empresas\n";
    echo "0. Volver al menú principal\n";
    echo "Seleccione una opción: ";
    $opcionEmpresa = trim(fgets(STDIN));

    switch ($opcionEmpresa) {
        case '1':
            altaEmpresa();
            break;
        case '2':
            modificarEmpresa();
            break;
        case '3':
            eliminarEmpresa();
            break;
        case '4':
            verEmpresas();
            break;
        case '0':
            break;
        default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
            pausar();
    }
} while ($opcionEmpresa !== '0');
