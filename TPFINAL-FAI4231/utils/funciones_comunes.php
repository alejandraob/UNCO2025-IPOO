<?php
//Funciones auxiliares para la gestión  de los menus y pantallas
/**
 * Summary of pausar
 * Esta función pausa la ejecución del programa y espera a que el usuario presione Enter.
 * Permite al usuario leer mensajes o resultados antes de continuar.
 * @param mixed $msg
 * @return void
 */
function pausar($msg = "Presione Enter para continuar...") {
    echo $msg;
    fgets(STDIN);
    echo PHP_EOL;
}
/**
 * Summary of limpiarPantalla
 * Esta función limpia la pantalla de la terminal.
 * Utiliza el comando 'cls' en Windows y 'clear' en sistemas Unix/Linux.
 * @return void
 */
function limpiarPantalla() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}
?>