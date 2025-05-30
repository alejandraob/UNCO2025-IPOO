<?php
/*
Los contratos tienen una fecha de inicio, la fecha de vencimiento, 
el plan, un estado (al día, moroso, suspendido, finalizado), un costo, 
si se renueva o no y una referencia al cliente que adquirió el contrato. 
*/
class Contrato{
    private $fechaInicio;
    private $fechaVencimiento;
    private $objPlan;
    private $estado; // al día, moroso, suspendido, finalizado
    private $costo;
    private $codigo;
    private $renovado; // true o false
    private $objCliente; // Referencia al cliente
    // Constructor
    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $estado, $costo,$codigo, $renovado, $objCliente) {
        $this->fechaInicio = $fechaInicio;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->objPlan = $objPlan;
        $this->estado = $estado;
        $this->costo = $costo;
        $this->codigo = $codigo;
        $this->renovado = $renovado;
        $this->objCliente = $objCliente;
    }
    // Getters
    public function getFechaInicio() {
        return $this->fechaInicio;
    }
    public function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }
    public function getObjPlan() {
        return $this->objPlan;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function getCosto() {
        return $this->costo;
    }
    public function getCodigo() {
        return $this->codigo;
    }
    public function getRenovado() {
        return $this->renovado;
    }
    public function getObjCliente() {
        return $this->objCliente;
    }
    // Setters
    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }
    public function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }
    public function setObjPlan($objPlan) {
        $this->objPlan = $objPlan;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
    public function setCosto($costo) {
        $this->costo = $costo;
    }
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    public function setRenovado($renovado) {
        $this->renovado = $renovado;
    }
    public function setObjCliente($objCliente) {
        $this->objCliente = $objCliente;
    }
    // ToString usando los getters
    public function __toString() {
        return "Contrato: Fecha Inicio: " . $this->getFechaInicio() . 
               ", Fecha Vencimiento: " . $this->getFechaVencimiento() . 
               ", Plan: " . $this->getObjPlan() . 
               ", Estado: " . $this->getEstado() . 
               ", Costo: $" . $this->getCosto() . 
               ", Renovado: " . ($this->getRenovado() ? "Sí" : "No") . 
               ", Cliente: " . $this->getObjCliente();
    }


    public function actualizarEstadoContrato($nuevoEstado) {
        $this->setEstado($nuevoEstado);
    }

    /*
    Utilice un método diasContratoVencido que recibe por parámetro un contrato 
    y retorna la cantidad de días vencidos o 0 en caso contrario. No es necesario que lo implemente.
    */
    public function diasContratoVencido(): int {
        $fechaActual = new DateTime();
        $fechaVencimiento = new DateTime($this->getFechaVencimiento());
        
        if ($fechaActual > $fechaVencimiento) {
            return $fechaActual->diff($fechaVencimiento)->days;
        }
        return 0;
    }

   
    public function calcularImporte() {
        // Calcular el importe del contrato basado en el plan y otros factores   
        return $this->getObjPlan()->getImporte();
    }


    /*Un contrato se considera en estado moroso cuando su fecha de vencimiento ha sido superada, en caso de que pasen 10 días al vencimiento el estado
 cambiará de moroso a suspendido; caso contrario el contrato se encuentra al día. Antes de que un cliente realice un pago se debe verificar su estado.

 */
    public function verificarEstado() {
        $fechaActual = new DateTime();
        $fechaVencimiento = new DateTime($this->getFechaVencimiento());
        
        if ($fechaActual > $fechaVencimiento) {
            $diasVencidos = $this->diasContratoVencido();
            if ($diasVencidos > 10) {
                $this->actualizarEstadoContrato("suspendido");
            } else {
                $this->actualizarEstadoContrato("moroso");
            }
        } else {
            $this->actualizarEstadoContrato("al día");
        }
    }

    /*Cuando un cliente paga su contrato hay que analizar el estado del mismo. Si el contrato está al día, se renovará por un mes más abonando el importe pactado.
 Si el contrato está en estado moroso, se cobrará una multa que será un incremento del 10% del valor pactado por la cantidad de días en mora, además su estado 
 se actualizará al valor al día y se renovará. Si el estado del contrato es suspendido se cobrará la misma multa de un contrato moroso pero no se permitirá su
  renovación. Si el estado del contrato es finalizado no se podrá realizar ninguna acción sobre ese contrato, es el ultimo estado en el que se puede encontrar 
  un contrato y que es inmutable (no puede pasar a ningún otro estado).*/
  public function procesarPago(): string {
    $this->verificarEstado();
    
    if ($this->estado === 'finalizado') {
        throw new Exception("Contrato finalizado no permite acciones");
    }

    $mensaje = "";
    $diasVencidos = $this->diasContratoVencido();
    $multa = 0;

    switch ($this->estado) {
        case 'al día':
            $this->renovarContrato(1);
            $mensaje = "Renovado por 1 mes";
            break;
            
        case 'moroso':
            $multa = $this->costo * 0.10 * $diasVencidos;
            $this->costo += $multa;
            $this->actualizarEstadoContrato("al día");
            $this->renovarContrato(1);
            $mensaje = "Multa: $$multa - Renovado";
            break;
            
        case 'suspendido':
            $multa = $this->costo * 0.10 * $diasVencidos;
            $this->costo += $multa;
            $this->actualizarEstadoContrato("al día");
            $mensaje = "Multa: $$multa - No renovado";
            break;
    }

    return $mensaje;
}

    // Metodo para renovar el contrato por un número específico de meses
    private function renovarContrato($meses) {
        $fecha = new DateTime($this->fechaVencimiento);
        $fecha->add(new DateInterval("P{$meses}M"));
        $this->fechaVencimiento = $fecha->format('Y-m-d');
        $this->renovado = true;
    }

}