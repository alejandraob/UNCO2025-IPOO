<?php
// Gestión de Responsables
/*
Este script permite gestionar los responsables de los viajes.
Incluye funcionalidades para dar de alta, modificar, eliminar y listar responsables.
Utiliza la clase ResponsableV para interactuar con la base de datos.
*/
require_once 'utils/funciones_comunes.php'; // Para limpiar pantalla y pausar
require_once 'datos/BaseDatos.php'; // Para la conexión a la base de datos
require_once 'datos/ResponsableV.php'; // Para manejar los responsables

// Funciones para gestionar responsables
/**
 * Summary of altaResponsable
 * Esta función permite dar de alta un nuevo responsable.
 * Solicita al usuario el número de empleado, número de licencia, nombre y apellido del responsable.
 * @throws \Exception
 * @return void
 */
function altaResponsable()
{
    limpiarPantalla();
    echo "======== ALTA DE RESPONSABLE ========\n";
    echo "Ingrese Número de Licencia: ";
    $nroLicencia = trim(fgets(STDIN));
    echo "Ingrese Nombre del Responsable: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese Apellido del Responsable: ";
    $apellido = trim(fgets(STDIN));

    try {
        $responsable = new ResponsableV();

        $responsable->cargarEmpleado(0, $nroLicencia, $nombre, $apellido);

        if ($responsable->insertarEmpleado()) {
            echo "✅ Responsable dado de alta correctamente.\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    pausar();
}
/**
 * Summary of modificarResponsable
 * @throws \Exception
 * @return void
 */
function modificarResponsable()
{
    limpiarPantalla();
    echo "======== MODIFICAR RESPONSABLE ========\n";
    //Listar responsables para seleccionar uno a modificar
    echo "Listado de responsables:\n";
    $responsables = ResponsableV::listarEmpleado();
    if (empty($responsables)) {
        echo "No hay responsables registrados.\n";
        pausar();
        return;
    }
    foreach ($responsables as $responsable) {
        echo "Número de Empleado: " . $responsable->getNroEmpleado() . " - " . $responsable->getNombre() . " " . $responsable->getApellido() . "\n";
    }
    echo "----------------------------------------\n";
    echo "Ingrese el Número de Empleado del responsable a modificar: ";
    $nroEmpleado = trim(fgets(STDIN));

    try {
        $responsableEncontrado = ResponsableV::listarEmpleado("rnumeroempleado = '{$nroEmpleado}'");

        if (empty($responsableEncontrado)) {
            throw new Exception("No se encontró ningún responsable con el número de empleado '{$nroEmpleado}'.");
        }

        $responsable = $responsableEncontrado[0];
        echo "Responsable encontrado:\n" . $responsable->__toString() . "\n";

        echo "Ingrese nuevo Número de Licencia (actual: " . $responsable->getNroLicencia() . ", dejar vacío para no modificar): ";
        $nuevaLicencia = trim(fgets(STDIN));
        if (!empty($nuevaLicencia)) {
            $responsable->setNroLicencia($nuevaLicencia);
        }

        echo "Ingrese nuevo Nombre (actual: " . $responsable->getNombre() . ", dejar vacío para no modificar): ";
        $nuevoNombre = trim(fgets(STDIN));
        if (!empty($nuevoNombre)) {
            $responsable->setNombre($nuevoNombre);
        }

        echo "Ingrese nuevo Apellido (actual: " . $responsable->getApellido() . ", dejar vacío para no modificar): ";
        $nuevoApellido = trim(fgets(STDIN));
        if (!empty($nuevoApellido)) {
            $responsable->setApellido($nuevoApellido);
        }

        if ($responsable->modificarEmpleado()) {
            echo "✅ Responsable modificado correctamente.\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    pausar();
}

/**
 * Summary of eliminarResponsable
 * Esta función permite eliminar un responsable existente.
 * Solicita al usuario el número de empleado del responsable a eliminar.
 * @throws \Exception
 * @return void
 */
function eliminarResponsable()
{
    limpiarPantalla();
    echo "======== ELIMINAR RESPONSABLE ========\n";
    //Listar responsables para seleccionar uno a eliminar
    echo "Listado de responsables:\n";
    $responsables = ResponsableV::listarEmpleado();
    if (empty($responsables)) {
        echo "No hay responsables registrados.\n";
        pausar();
        return;
    }
    foreach ($responsables as $responsable) {
        echo "Número de Empleado: " . $responsable->getNroEmpleado() . " - " . $responsable->getNombre() . " " . $responsable->getApellido() . "\n";
    }
    echo "----------------------------------------\n";
    echo "Ingrese el Número de Empleado del responsable a eliminar: ";
    $nroEmpleado = trim(fgets(STDIN));

    try {
        $responsableEncontrado = ResponsableV::listarEmpleado("rnumeroempleado = '{$nroEmpleado}'");

        if (empty($responsableEncontrado)) {
            throw new Exception("No se encontró ningún responsable con el número de empleado '{$nroEmpleado}'.");
        }

        $responsable = $responsableEncontrado[0];
        echo "¿Está seguro que desea eliminar al siguiente responsable?\n" . $responsable->__toString() . "\n(S/N): ";
        $confirmacion = strtoupper(trim(fgets(STDIN)));

        if ($confirmacion === 'S') {
            if ($responsable->eliminarEmpleado()) {
                echo "✅ Responsable eliminado correctamente.\n";
            }
        } else {
            echo "Operación de eliminación cancelada.\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    pausar();
}

/**
 * Summary of verResponsables
 * @return void
 */
function verResponsables()
{
    limpiarPantalla();
    echo "======== LISTADO DE RESPONSABLES ========\n";
    try {
        $responsables = ResponsableV::listarEmpleado();

        if (empty($responsables)) {
            echo "No hay responsables registrados.\n";
        } else {
            foreach ($responsables as $responsable) {
                echo $responsable->__toString() . "\n";
                echo "----------------------------------------\n";
            }
        }
    } catch (Exception $e) {
        echo "❌ Error al listar responsables: " . $e->getMessage() . "\n";
    }
    pausar();
}

// --- Menú de Gestión de Responsables ---
do {
    limpiarPantalla();
    echo "=== GESTIÓN DE RESPONSABLES ===\n";
    echo "1. Alta de responsable\n";
    echo "2. Modificar responsable\n";
    echo "3. Eliminar responsable\n";
    echo "4. Ver todos los responsables\n";
    echo "0. Volver al menú principal\n";
    echo "Seleccione una opción: ";
    $opcionResponsable = trim(fgets(STDIN));

    switch ($opcionResponsable) {
        case '1':
            altaResponsable();
            break;
        case '2':
            modificarResponsable();
            break;
        case '3':
            eliminarResponsable();
            break;
        case '4':
            verResponsables();
            break;
        case '0':
            break;
        default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
            pausar();
    }
} while ($opcionResponsable !== '0');