<?php

namespace Fact\Detalle\Service\Egreso;

use Doctrine\ORM\EntityManager;
use Fact\Egreso\Egreso;
use Fact\Detalle\Egreso as EgresoDetalle;
use Stock\Detalle\Service\Vender as VenderArticuloDetalleService;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Egreso
     * @var Egreso
     */
    protected $egreso;
    
    /**
     * Detalle del Egreso
     * @var EgresoDetalle
     */
    protected $detalle;
    
    public function __construct($em, $egreso)
    {
        $this->em     = $em;
        $this->egreso = $egreso;
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
        $this->venderArticuloDetalle();
    }
    
    protected function crearDetalle($data)
    {
        $this->detalle = new EgresoDetalle();
        $this->detalle->fromArray($data);
        $this->detalle->setDefaultValues();
        $this->detalle->setEgreso($this->egreso);
        $this->em->persist($this->detalle);
    }
    
    protected function venderArticuloDetalle()
    {
        $service = new VenderArticuloDetalleService($this->em, $this->detalle);
        $size = $this->detalle->getCantidad();
    
        for ($i=0; $i<$size; $i++) {
            $service->ejecutar(array());
        }
    }
}