<?php
require_once "Aeropuerto.php";
require_once "Vuelo.php";
require_once "Persona.php";
require_once "Aerolinea.php";


// Crear instancias de Persona
$persona1= new Persona("Berta","Gonzalez","Mexico 123","berta@mail.com","123456789");
$persona2= new Persona("Camilo","Guzman","Bahamas 123","camilin@mail.com","987654321");

// Crear instancias de Vuelo
$vuelo1= new Vuelo(1,1000,"2023-10-01","Buenos Aires","10:00","12:00",100,50,$persona1);
$vuelo2= new Vuelo(2,2000,"2023-10-02","Madrid","14:00","16:00",200,100,$persona2);
$vuelo3= new Vuelo(3,1500,"2023-10-03","Paris","18:00","20:00",150,75,$persona1);
$vuelo4= new Vuelo(4,2500,"2023-10-04","Londres","22:00","00:00",250,125,$persona2);

// Crear instancia de Aerolinea
$Aerolinea1= new Aerolinea("AeroArgentina","Av. Libertador 1234",[$vuelo3,$vuelo4],2);
$Aerolinea2= new Aerolinea("AeroChile","Av. Libertador 5678",[$vuelo1,$vuelo2],2);

// Crear instancia de Aerolinea
$aeropuerto= new Aeropuerto("AeroArgentina","Av. Libertador 1234",[$Aerolinea1,$Aerolinea2]);

// Mostrar información del Aeropuerto
//Registro de venta Automatica
 echo $aeropuerto->ventaAutomatica(3,"2023-10-01","Buenos Aires");
 echo "\n";
 echo $aeropuerto->promedioRecaudadoXAerolinea("AeroArgentina");
 echo "\n";

