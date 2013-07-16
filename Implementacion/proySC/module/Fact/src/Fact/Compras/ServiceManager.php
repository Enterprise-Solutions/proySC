<?php

namespace Fact\Compras;

use Doctrine\ORM\EntityManager;

class ServiceManager
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
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
        $articuloId = $data['stock_articulo_id'];
        $articulo = $this->em->find('Stock\Articulo\Articulo', $articuloId);
        
        $result = array('exitoso' => true, 'articulo' => $articulo->getNombre());
        $this->result = array_merge($data, $result);
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