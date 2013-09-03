<?php

namespace Stock\Detalle\Service;

use Doctrine\ORM\EntityManager;
use Fact\Detalle\Egreso as EgresoDetalle;
use Stock\Articulo\Articulo;
use EnterpriseSolutions\Exceptions\Thrower;

class Disponibilizar
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
            if ($detalle->getEstado() === 'V') {
                $this->disponibilizarArticulo($detalle);
                $this->actualizarExistencia();
                return;
            }
        }
        
        Thrower::throwValidationException('No todos los articulos figuran como vendidos');
    }
    
    protected function disponibilizarArticulo($detalle)
    {
        $detalle->disponibilizar();
        $this->em->persist($detalle);
    }
    
    protected function actualizarExistencia()
    {
        $this->articulo->addExistencia();
        $this->em->persist($this->articulo);
    }
}