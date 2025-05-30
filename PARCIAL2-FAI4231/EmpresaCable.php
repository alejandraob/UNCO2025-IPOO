<?php
class EmpresaCable{
    private $razonSocial;
    private $cuit;
    private $direccion;
    private $telefono;
    private $objContratos; // colección de contratos
    private $objClientes; // colección de clientes
    private $objPlanes; // colección de planes
    private $objCanales; // colección de canales
    // Constructor
    public function __construct($razonSocial, $cuit, $direccion, $telefono) {
        $this->razonSocial = $razonSocial;
        $this->cuit = $cuit;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->objContratos = [];
        $this->objClientes = [];
        $this->objPlanes = [];
        $this->objCanales = [];
    }
    // Getters
    public function getRazonSocial() {
        return $this->razonSocial;
    }
    public function getCuit() {
        return $this->cuit;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function getObjContratos() {
        return $this->objContratos;
    }
    public function getObjClientes() {
        return $this->objClientes;
    }
    public function getObjPlanes() {
        return $this->objPlanes;
    }
    public function getObjCanales() {
        return $this->objCanales;
    }
    // Setters
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }
    public function setCuit($cuit) {
        $this->cuit = $cuit;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    public function setObjContratos(array $objContratos) {
        $this->objContratos = $objContratos;
    }
    public function setObjClientes(array $objClientes) {
        $this->objClientes = $objClientes;
    }
    public function setObjPlanes(array $objPlanes) {
        $this->objPlanes = $objPlanes;
    }
    public function setObjCanales(array $objCanales) {
        $this->objCanales = $objCanales;
    }
    // ToString usando los getters
    public function __toString() {
        $contratosStr = implode(", ", array_map(fn($c) => $c->__toString(), $this->getObjContratos()));
        $clientesStr = implode(", ", array_map(fn($c) => $c->__toString(), $this->getObjClientes()));
        $planesStr = implode(", ", array_map(fn($p) => $p->__toString(), $this->getObjPlanes()));
        $canalesStr = implode(", ", array_map(fn($c) => $c->getTipo(), $this->getObjCanales()));
        
        return "Empresa: " . $this->getRazonSocial() . 
               ", CUIT: " . $this->getCuit() . 
               ", Dirección: " . $this->getDireccion() . 
               ", Teléfono: " . $this->getTelefono() . 
               ", Contratos: [" . $contratosStr . "]" .
               ", Clientes: [" . $clientesStr . "]" .
               ", Planes: [" . $planesStr . "]" .
               ", Canales: [" . $canalesStr . "]";
    }
    // Métodos para agregar contratos, clientes, planes y canales
/*Implementar la función incorporarPlan que incorpora a la colección de planes un nuevo plan siempre
 y cuando no haya un plan con los mismos canales y los mismos MG (en caso de que el plan incluyera).**/
    public function incorporarPlan(Plan $plan) {
        $puedeIncorporar = true;
        $i = 0;
        $listaPlanes = $this->getObjPlanes();
        $cantPlanes = count($listaPlanes);
        while ($i < $cantPlanes && $puedeIncorporar) {
            $objPlanExistente = $listaPlanes[$i];
           
            if ($this->sonPlanesIdenticos($objPlanExistente, $plan)) {
                $puedeIncorporar = false;
            }
           
            $i++;
        }
        if($puedeIncorporar){
            $nuevosPlanes = $listaPlanes;
            $nuevosPlanes[] = $plan;
            $this->planes = $nuevosPlanes;
        }
        return $puedeIncorporar;

    }

    public function sonPlanesIdenticos(Plan $plan1, Plan $plan2) {
        // Compara los canales y MG de datos de ambos planes
        return $plan1->getCanales() == $plan2->getCanales() && 
        $plan1->getMgDatos() == $plan2->getMgDatos();
    }



    /*Implementar la función BuscarContrato que  recibe un tipo y numero de documento
     correspondiente a un cliente y retorna el contrato que tiene el cliente con la empresa. 
     Si no existe ningún contrato el método retorna un valor nulo. */
     public function BuscarContrato($tipoDocumento, $numeroDocumento) {
        $contratoEncontrado = null;
        $i = 0;
        $contratos = $this->getObjContratos();
        $cantidadContratos = count($contratos);
        while ($i < $cantidadContratos && $contratoEncontrado === null) {
            $objContrato = $contratos[$i];
            $objCliente = $objContrato->getObjCliente();
            
            if ($objCliente->getTipoDni() === $tipoDocumento && 
                $objCliente->getDni() === $numeroDocumento) {
                $contratoEncontrado = $objContrato;
            }
            
            $i++;
        }
        
        return $contratoEncontrado;
    }

    /*Implementar la función incorporarContrato: que recibe por parámetro el plan, una referencia al cliente,
     la fecha de inicio y de vencimiento del mismo y si se trata de un contrato realizado en la empresa o vía web 
     (si el valor del parámetro es True se trata de un contrato realizado vía web). 
     El método corrobora que no exista un contrato previo con el cliente, en caso de existir y
      encontrarse activo se debe dar de baja. Por política de la empresa, solo existe la posibilidad 
      de tener un contrato activo con un cliente determinado. */
    public function incorporarContrato(Plan $plan, Cliente $cliente, $fechaInicio, $fechaVencimiento, $esWeb = false) {
        // Verificar si ya existe un contrato activo para el cliente
        $contratoExistente = $this->BuscarContrato($cliente->getTipoDni(), $cliente->getDni());
        
        if ($contratoExistente !== null && $contratoExistente->getEstado() === "al día") {
            // Dar de baja el contrato existente
            $contratoExistente->actualizarEstadoContrato("finalizado");
        }
        
        // Crear un nuevo contrato
        if ($esWeb) {
            $nuevoContrato = new ContratoWeb($fechaInicio, $fechaVencimiento, $plan, "activo", $plan->getImporte(),1, false, $cliente, 10); // Por ejemplo, 10% de descuento
        } else {
            $nuevoContrato = new Contrato($fechaInicio, $fechaVencimiento, $plan, "activo", $plan->getImporte(),2, false, $cliente);
        }
        
        // Agregar el nuevo contrato a la colección
        $this->objContratos[] = $nuevoContrato;
        
        return true; //  se ha incorporado correctamente
    }
    /*Implementar la función  retornarPromImporteContratos que recibe por parámetro el código de un plan y retorna
     el promedio de los importes de los contratos realizados usando ese plan.*/
     public function retornarPromImporteContratos($codigoPlan) {
        $contratos = $this->getObjContratos();
        $cantidadTotal = count($contratos);
        $i = 0;
        $totalImporte = 0;
        $cantidadContratos = 0;
    
        // Recorrido completo con while (permitido)
        while ($i < $cantidadTotal) {
            $contrato = $contratos[$i];
            $plan = $contrato->getObjPlan();
    
            if ($plan->getCodigo() === $codigoPlan) {
                $totalImporte += $contrato->calcularImporte();
                $cantidadContratos++;
            }
            $i++;
        }
    
        $promedio = 0;
        if ($cantidadContratos > 0) {
            $promedio = $totalImporte / $cantidadContratos;
        }
    
        return $promedio;
    }
    

    /*Implementar la función pagarContrato: que recibe como parámetro el código de un contrato,
     actualiza el estado del contrato y retorna el importe final que debe ser abonado por el cliente. */
     public function pagarContrato($codigoContrato) {
        $contratos = $this->getObjContratos();
        $cantidad = count($contratos);
        $i = 0;
        $contrato = null;
        
        // Búsqueda parcial SIN usar break ni múltiples return
        while ($i < $cantidad && $contrato === null) {
            if ($contratos[$i]->getCodigo() === $codigoContrato) {
                $contrato = $contratos[$i];
            }
            $i++;
        }
    
        $importeFinal = 0;
    
        if ($contrato !== null) {
            // Verifica el estado actual del contrato
            $contrato->verificarEstado();
    
            // Calcula el importe a pagar
            $importeFinal = $contrato->calcularImporte();
    
            // Si el contrato está en estado moroso o suspendido, lo pasa a "al día"
            if ($contrato->getEstado() === "moroso" || $contrato->getEstado() === "suspendido") {
                $contrato->actualizarEstadoContrato("al día");
            }
        }
    
       
        return $importeFinal;
    }
    

    /*Implementar la función retornarImporteContratos que recibe por parámetro un código de plan y retorna
     el importe total de los contratos realizados con ese plan.*/
    public function retornarImporteContratos($codigoPlan) {
        $totalImporte = 0;
        
        foreach ($this->getObjContratos() as $contrato) {
            if ($contrato->getObjPlan()->getCodigo() === $codigoPlan) {
                $totalImporte += $contrato->calcularImporte();
            }
        }
        
        return $totalImporte; // Retorna el importe total de los contratos con ese plan
    }

}