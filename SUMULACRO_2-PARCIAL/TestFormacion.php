<?php
require_once("Locomotora.php");
require_once("Vagon.php");
require_once("VagonPasajeros.php");
require_once("VagonCarga.php");
require_once("Formacion.php");
//1. Se crea un objeto locomotora con un peso de 188 toneladas y una velocidad de 140 km/h.
$locomotora = new Locomotora(188, 140);

//2 - Se crea 3 objetos con la información visualizada en la tabla:

$vagonPasajero1 = new VagonPasajeros(2025, 20, 10, 15000, 30,25,50);
$vagonPasajero2 = new VagonPasajeros(2025, 20, 10, 15000, 50,50,50);
$vagonCarga= new VagonCarga(2025, 20, 10, 15000, 55000, 0);

$formacion = new Formacion($locomotora, 5);
/*3 -Se crea un objeto formación que tiene la locomotora y los vagones creados en (1) y (2) usando el método
incorporarVagonFormacion. */
$formacion->incorporarVagonFormacion($vagonPasajero1);
$formacion->incorporarVagonFormacion($vagonPasajero2);
$formacion->incorporarVagonFormacion($vagonCarga);


/*
4. Invocar al método incorporarPasajeroFormacion con el parámetros cantidad de pasajero = 6 y
visualizar el resultado.
$incorporarPasajero = $formacion->incorporarPasajeroFormacion(6);
if($incorporarPasajero){
    echo "Se incorporaron los pasajeros a la formación.\n";
}else{
    echo "No se pudieron incorporar los pasajeros a la formación. Supera la cantidad maxima\n";
}*/

/*
Probando con 2 pasajeros
$incorporarPasajero = $formacion->incorporarPasajeroFormacion(2);
if($incorporarPasajero){
    echo "Se incorporaron los pasajeros a la formación.\n";
}else{
    echo "No se pudieron incorporar los pasajeros a la formación. Supera la cantidad maxima \n";
}
*/

/*
6. Invocar al método incorporarPasajeroFormacion con el parámetros cantidad de pasajero = 14 y
visualizar el resultado
$incorporarPasajero = $formacion->incorporarPasajeroFormacion(14);
if($incorporarPasajero){
    echo "Se incorporaron los pasajeros a la formación.\n";
}else{
    echo "No se pudieron incorporar los pasajeros a la formación. Supera la cantidad maxima \n";
}*/

//7. Realizar un print del objeto locomotora
echo "Informacíon de la locomotora:\n";
echo $locomotora . "\n";
//8. Invocar al método promedioPasajeroFormacion y visualizar el resultado obtenido.
$pesoPromedio= $formacion->promedioPasajeroFormacion();
echo "El promedio de pasajeros por vagón es: " . $pesoPromedio . "\n";
//9. Invocar al método pesoFormacion y visualizar el resultado obtenido.
$pesoFormacion= $formacion->pesoFormacion();
echo "El peso de la formación es: " . $pesoFormacion . "\n\n";

//5 y 10. Realizar un print de los 3 objetos vagones creados.
echo "Informacíon de los vagones:\n";
echo "Vagón 1:\n" . $vagonPasajero1->__toString() . "\n\n";
echo "Vagón 2:\n" . $vagonPasajero2->__toString() . "\n\n";
echo "Vagón 3:\n" . $vagonCarga->__toString() . "\n\n";


echo "\n";