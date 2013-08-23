<?php

namespace Stock\Detalle\Service;

use Doctrine\ORM\EntityManager;
use Fact\Detalle\Egreso as EgresoDetalle;
use Stock\Articulo\Articulo;
use EnterpriseSolutions\Exceptions\Thrower;

class Vender
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Detalle del Egreso
     * @var EgresoDetalle
     */
    protected $egresoDetalle;
    
    /**
     * Articulo
     * @var Articulo
     */
    protected $articulo;
    
    public function __construct($em, $egresoDetalle)
    {
        $this->em = $em;
        $this->egresoDetalle = $egresoDetalle;
        $this->articulo = $this->em->find('Stock\Articulo\Articulo', $this->egresoDetalle->getArticuloId());
    }
    
    public function ejecutar($data)
    {
        $detalles = $this->articulo->getDetalle();
        foreach ($detalles as $detalle) {
            if ($detalle->getEstado() === 'D') {
                $this->venderArticulo($detalle);
                $this->actualizarExistencia();
                return;
            }
        }
        
        Thrower::throwValidationException('No existe la cantidad de articulos que desea vender');
    }
    
    protected function venderArticulo($detalle)
    {
        $detalle->vender($this->egresoDetalle->getId());
        $this->em->persist($detalle);
    }
    
    protected function actualizarExistencia()
    {
        $this->articulo->removeExistencia();
        $this->em->persist($this->articulo);
    }
}