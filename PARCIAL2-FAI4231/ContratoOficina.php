<?php
class ContratoOficina extends Contrato{

    public function __construct(
        string $fechaInicio,
        string $fechaVencimiento,
        Plan $objPlan,
        string $estado,
        float $costo,
        $codigo,
        bool $renovado,
        Cliente $objCliente
    ) {
        parent::__construct(
            $fechaInicio,
            $fechaVencimiento,
            $objPlan,
            $estado,
            $costo,
            $codigo,
            $renovado,
            $objCliente
        );
    }


    public function calcularImporte() {
        $importeBase = parent::calcularImporte();
        $totalCanales = array_reduce(
            $this->getObjPlan()->getCanales(),
            fn(float $acum, Canal $canal) => $acum + $canal->getImporte(),
            0.0
        );
        return $importeBase + $totalCanales;
    }
    
}