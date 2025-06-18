<?php
//Requiere los archivos de funciones comunes
require_once 'utils/funciones_comunes.php'; 
// Requiere los archivos de datos y controladores
require_once 'datos/Empresa.php';
require_once 'datos/Viajes.php';
require_once 'datos/Pasajeros.php';
require_once 'datos/ResponsableV.php';
require_once 'datos/BaseDatos.php';


// Menú principal
do {
    limpiarPantalla();
    // Muestra el menú principal de gestión de viajes
    echo "======== MENÚ PRINCIPAL DE GESTIÓN DE VIAJES ========\n";
    echo "1. Gestionar Empresas\n";
    echo "2. Gestionar Viajes\n";
    echo "3. Gestionar Pasajeros\n";
    echo "4. Gestionar Responsables\n";
    echo "0. Salir\n";
    echo "Seleccione una opción: ";
    // Captura la opción del usuario
    // Utiliza fgets para leer la entrada del usuario
    $opcion = trim(fgets(STDIN));

    // Verifica la opción seleccionada y ejecuta el script correspondiente
    // Utiliza un switch para manejar las diferentes opciones del menú
    switch ($opcion) {
        case '1':
            // Incluye y ejecuta el script de gestión de empresas
            include_once 'controller/GestionEmpresas.php';
            break;
        case '2':
            // Incluye y ejecuta el script de gestión de viajes
            include_once 'controller/GestionViajes.php';
            break;
        case '3':
            // Incluye y ejecuta el script de gestión de pasajeros
            include_once 'controller/GestionPasajeros.php';
            break;
        case '4':
            // Incluye y ejecuta el script de gestión de responsables
            include_once 'controller/GestionResponsables.php';
            break;
        case '0':
            echo "Saliendo del programa. ¡Hasta luego!\n";
            break;
        default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
            pausar();
            break;
    }
} while ($opcion != '0');

?>