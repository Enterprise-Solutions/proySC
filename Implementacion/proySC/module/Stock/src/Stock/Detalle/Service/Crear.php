<?php

namespace Stock\Detalle\Service;

use Doctrine\ORM\EntityManager;
use Stock\Articulo\Articulo;
use Stock\Detalle\Detalle;
use Fact\Detalle\Ingreso as IngresoDetalle;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Ingreso Detalle
     * @var IngresoDetalle
     */
    protected $ingresoDetalle;
    
    /**
     * Detalle del Articulo
     * @var Detalle
     */
    protected $detalle;
    
    /**
     * Articulo
     * @var Articulo
     */
    protected $articulo;
    
    public function __construct($em, $ingresoDetalle)
    {
        $this->em             = $em;
        $this->ingresoDetalle = $ingresoDetalle;
        $this->articulo       = $this->em->getReference('Stock\Articulo\Articulo', $this->ingresoDetalle->getArticuloId());
    }
    
    public function init()
    {
        $this->detalle = null;
    }
    
    public function ejecutar($data)
    {
        $this->crearDetalle($data);
        $this->actualizarExistencia();
    }
    
    protected function crearDetalle($data)
    {
        $this->detalle = new Detalle();
        $this->detalle->fromArray($data);
        $this->detalle->setDefaultValues();
        $this->detalle->setIngresoDetalle($this->ingresoDetalle);
        $this->detalle->setArticulo($this->articulo);
        $this->em->persist($this->detalle);
    }
    
    protected function actualizarExistencia()
    {
        $this->articulo->getDetalle()->add($this->detalle);
        $this->articulo->addExistencia();
        $this->em->persist($this->articulo);
    }
}