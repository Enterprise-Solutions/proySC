<?php

namespace Fact\Detalle\Service;

use Doctrine\ORM\EntityManager;
use Fact\Ingreso\Ingreso;
use Fact\Detalle\Ingreso as IngresoDetalle;
use Stock\Detalle\Service\Crear as CrearArticuloDetalleService;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Ingreso
     * @var Ingreso
     */
    protected $ingreso;
    
    /**
     * Detalle
     * @var Detalle
     */
    protected $detalle;
    
    public function __construct($em, $ingreso)
    {
        $this->em      = $em;
        $this->ingreso = $ingreso;
    }
    
    public function init()
    {
        $this->detalle = null;
    }
    
    public function getDetalle()
    {
        return $this->detalle;
    }
    
    public function ejecutar($data)
    {
        $this->crearDetalle($data);
        $this->crearArticuloDetalle();
    }
    
    protected function crearDetalle($data)
    {
        $this->detalle = new IngresoDetalle();
        $this->detalle->fromArray($data);
        $this->detalle->setDefaultValues();
        $this->detalle->setIngreso($this->ingreso);
        $this->em->persist($this->detalle);
    }
    
    protected function crearArticuloDetalle()
    {
        $service = new CrearArticuloDetalleService($this->em, $this->detalle);
        $size = $this->detalle->getCantidad();
        
        for ($i=0; $i<$size; $i++) {
            $service->init();
            $service->ejecutar(array());
        }
    }
}