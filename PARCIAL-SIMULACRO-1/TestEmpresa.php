<?php
/*
 1. Cree 2 instancias de la clase Cliente: $objCliente1, $objCliente2.
 2. Cree 3 objetos Motos con la información visualizada en la tabla: código, costo, año fabricación,
 descripción, porcentaje incremento anual, activo

 código  costo  anio_fabricacion  Descripcion                          porc_increment  activo
 12      584000   2021             Benelli Imperiale 400                85%             true   
 13     999900    2023             Zanella Zr 150 Ohc                   70%             true 
 11     2230000   2022             Zanella Patagonian Eagle 250         55%             false           


 4. Se crea un objeto Empresa con la siguiente información: denominación =” Alta Gama”, dirección= “Av
 Argenetina 123”, colección de motos= [$obMoto1, $obMoto2, $obMoto3] , colección de clientes =
 [$objCliente1, $objCliente2 ], la colección de ventas realizadas=[].
 5. Invocar al método registrarVenta($colCodigosMoto, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [11,12,13]. Visualizar el resultado obtenido.
 6. Invocar al método registrarVenta($colCodigosMotos, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [0]. Visualizar el resultado obtenido.
 7. Invocar al método registrarVenta($colCodigosMotos, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [2]. Visualizar el resultado obtenido.
 8. Invocar al método retornarVentasXCliente($tipo,$numDoc) donde el tipo y número de documento se
 corresponden con el tipo y número de documento del $objCliente1.
 9. Invocar al método retornarVentasXCliente($tipo,$numDoc) donde el tipo y número de documento se
 corresponden con el tipo y número de documento del $objCliente2
 10. Realizar un echo de la variable Empresa creada en 2

*/

require_once "Cliente.php";
require_once "Moto.php";
require_once "Venta.php";
require_once "Empresa.php";

// 1. Cree 2 instancias de la clase Cliente: $objCliente1, $objCliente2.
$objCliente1 = new Cliente("Juan", "Pérez", "DNI", 12345678, 0); // Activo
$objCliente2 = new Cliente("Ana", "Gómez", "DNI", 87654321, 1); // Dado de baja

// 2. Cree 3 objetos Motos con la información visualizada en la tabla: código, costo, año fabricación,
// descripción, porcentaje incremento anual, activo
$objMoto1 = new Moto(12, 584000, 2021, "Benelli Imperiale 400", 0.85, true);
$objMoto2 = new Moto(13, 999900, 2023, "Zanella Zr 150 Ohc", 0.70, true);
$objMoto3 = new Moto(11, 2230000, 2022, "Zanella Patagonian Eagle 250", 0.55, false);


// 3. Se crea un objeto Empresa con la siguiente información: denominación =” Alta Gama”, dirección= “Av 
// Argenetina 123”, colección de motos= [$obMoto1, $obMoto2, $obMoto3] , colección de clientes =
// [$objCliente1, $objCliente2 ], la colección de ventas realizadas=[].
$empresa = new Empresa("Alta Gama", "Av Argentina 123");
$empresa->setClientes([$objCliente1, $objCliente2]);
$empresa->setMotos([$objMoto1, $objMoto2, $objMoto3]);
$empresa->setVentas([]);

/*
 4. Invocar al método registrarVenta($colCodigosMoto, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [11,12,13]. Visualizar el resultado obtenido.

*/
try{
    $empresa->registrarVenta([11, 12, 13], $objCliente1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
/*
try{
    $empresa->registrarVenta([11, 12, 13], $objCliente1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
*/

//print_r($empresa->getVentas());

echo "\n----------------------------------------\n";

/*
5.Invocar al método registrarVenta($colCodigosMotos, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [0]. Visualizar el resultado obtenido.
*/
try{
    // Intentar registrar una venta con un código de moto inválido (0)
    // Esto debería lanzar una excepción
$empresa->registrarVenta([0], $objCliente2);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/*
try{
    $empresa->registrarVenta([0], $objCliente1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
*/

//print_r($empresa->getVentas());

echo "\n----------------------------------------\n";
/*
6. Invocar al método registrarVenta($colCodigosMotos, $objCliente) de la Clase Empresa donde el
 $objCliente es una referencia a la clase Cliente almacenada en la variable $objCliente2 (creada en el
 punto 1) y la colección de códigos de motos es la siguiente [2]. Visualizar el resultado obtenido.
*/

try{
$empresa->registrarVenta([2], $objCliente2);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/*
try{
    $empresa->registrarVenta([2], $objCliente1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
*/

//print_r($empresa->getVentas());
echo "\n----------------------------------------\n";
/*
7. Invocar al método retornarVentasXCliente($tipo,$numDoc) donde el tipo y número de documento se
 corresponden con el tipo y número de documento del $objCliente1.
*/

echo "Ventas del Cliente 1:\n";
try {
    $ventasCliente1 = $empresa->retornarVentasXCliente($objCliente1->getTipoDoc(), $objCliente1->getNumDoc());
    foreach ($ventasCliente1 as $venta) {
        echo $venta . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "\n----------------------------------------\n";
/*Invocar al método retornarVentasXCliente($tipo,$numDoc) donde el tipo y número de documento se
 corresponden con el tipo y número de documento del $objCliente2
 */
echo "\n----------------------------------------\n";
echo "Ventas del Cliente 2:\n";
try {
    $ventasCliente2 = $empresa->retornarVentasXCliente($objCliente2->getTipoDoc(), $objCliente2->getNumDoc());
    foreach ($ventasCliente2 as $venta) {
        echo $venta . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


echo "\n----------------------------------------\n";
/*
8. Realizar un echo de la variable Empresa creada en 2
*/

echo $empresa . "\n";
