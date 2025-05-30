<?php

require_once "EmpresaCable.php";
require_once "Cliente.php";
require_once "Contrato.php";
require_once "ContratoWeb.php";
require_once "ContratoOficina.php";
require_once "Plan.php";
require_once "Canal.php";

$empresa = new EmpresaCable("Empresa de Cable S.A.", "123456789", "Calle Falsa 123", "555-1234");
$cliente1 = new Cliente(1,"Juan","Perez","DNI",123456789,"555-1234");
$canal1 = new Canal("Deportes", 100, true);
$canal2 = new Canal("Noticias", 50, true);
$canal3 = new Canal("Entretenimiento", 75, false);
$plan1 = new Plan("123", [$canal1, $canal2], 200);
$plan2 = new Plan("111", [$canal1, $canal2, $canal3], 400);

//cree   3 instancias de Contratos, 1 correspondiente a un contrato realizado en la empresa y 2 realizados via web.
$contrato1 = new ContratoOficina("2023-01-01", "2024-01-01", $plan1, "activo", 200,111, false, $cliente1);
$contrato2 = new ContratoWeb("2023-02-01", "2024-02-01", $plan2, "activo", 400,321, false, $cliente1, 10);
$contrato3 = new ContratoWeb("2023-03-01", "2024-03-01", $plan1, "activo", 200,159, false, $cliente1, 15);

echo "Calcular Importe Contrato Oficina: " . $contrato1->calcularImporte() . "\n";
echo "Calcular Importe Contrato Web 1: " . $contrato2->calcularImporte() . "\n";
echo "Calcular Importe Contrato Web 2: " . $contrato3->calcularImporte() . "\n";

/*al método incorporaPlan con los planes creados previamente .
al método incorporarContrato con los siguientes parámetros: uno de los planes , el cliente, la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días para indicar el vencimiento del mismo y  false como último parámetro.
al método incorporarContrato con los siguientes parámetros: uno de los planes creado en c), el cliente creado en e), la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días para indicar el vencimiento del mismo y true como último parámetro. 
al método pagarContrato que recibe como parámetro uno de los contratos creados  y que haya sido contratado en la empresa. 
al método pagarContrato que recibe como parámetro uno de los contratos creados  y que haya sido contratado vía web.
al método retornarImporteContratos con el código 111.*/

echo $empresa->incorporarPlan($plan1). "\n";
echo $empresa->incorporarPlan($plan2). "\n";
echo $empresa->incorporarContrato($plan1, $cliente1, date("Y-m-d"), date("Y-m-d", strtotime("+30 days")), false). "\n";
echo $empresa->incorporarContrato($plan2, $cliente1, date("Y-m-d"), date("Y-m-d", strtotime("+30 days")), true). "\n";
echo $empresa->pagarContrato($contrato1->getCodigo()). "\n";
echo $empresa->pagarContrato($contrato2->getCodigo()). "\n";
echo "Importe Contratos con código 111: " . $empresa->retornarImporteContratos(111) . "\n";
