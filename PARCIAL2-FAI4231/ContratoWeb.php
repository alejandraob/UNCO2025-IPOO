<?php
/*De un contrato realizado vía web se guarda además el porcentaje de descuento y tiene un cálculo de costo diferente. */
class ContratoWeb extends Contrato {
    // Atributos específicos de ContratoWeb
    private $porcentajeDescuento;

    // Constructor
    public function __construct($fechaInicio, $fechaVencimiento, $plan, $estado, $costo,$codigo, $renovado, $cliente, $porcentajeDescuento) {
        parent::__construct($fechaInicio, $fechaVencimiento, $plan, $estado, $costo,$codigo, $renovado, $cliente);
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    // Getters
    public function getPorcentajeDescuento() {
        return $this->porcentajeDescuento;
    }

    // Setters
    public function setPorcentajeDescuento($porcentajeDescuento) {
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    // ToString usando los getters
    public function __toString() {
        return parent::__toString() . ", Porcentaje Descuento: " . $this->getPorcentajeDescuento() . "%";
    }

    public function calcularImporte () {
        $importeBase = parent::calcularImporte();
        return $importeBase * (1 - $this->getPorcentajeDescuento() / 100);
    }
    

}