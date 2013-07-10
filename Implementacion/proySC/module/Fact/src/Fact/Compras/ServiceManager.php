<?php

namespace Fact\Compras;

class ServiceManager
{
    /**
     * Doctrine Entity Manager
     * @var Doctrine\Orm\EntityManager
     */
    protected $em;
    
    /**
     * Resultado de la operacion
     * @var array
     */
    protected $result;
    
    public function __construct($em)
    {
        $this->em     = $em;
        $this->result = array();
    }
    
    /**
     * Control de los datos que se van agregar en el detalle (No se persiste nada)
     * 
     * Controles realizados:
     * - Cantidad sea un valor positivo.
     * - Costo Unitario sea un valor positivo.
     * 
     * @param array $data
     * @todo Agregar validaciones
     */
    public function validateDetalle($data)
    {
        $this->result = array('exitoso' => true);
    }
    
    /**
     * Resultado de la operacion realizada
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}