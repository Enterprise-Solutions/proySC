<?php

namespace Stock\Detalle\Service;

use Doctrine\ORM\EntityManager;
use Fact\Detalle\Ingreso as IngresoDetalle;
use Stock\Articulo\Articulo;
use EnterpriseSolutions\Exceptions\Thrower;

class Eliminar
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Articulo
     * @var Articulo
     */
    protected $articulo;
    
    /**
     * Detalle del Ingreso
     * @var IngresoDetalle
     */
    protected $ingresoDetalle;
    
    public function __construct($em, $ingresoDetalle)
    {
        $this->em             = $em;
        $this->ingresoDetalle = $ingresoDetalle;
        $this->articulo       = $this->em->getReference('Stock\Articulo\Articulo', $this->ingresoDetalle->getArticuloId());
    }
    
    public function ejecutar($data)
    {
        $detalles = $this->articulo->getDetalle();
        foreach ($detalles as $detalle) {
            if ($detalle->getIngresoDetalleId() == $this->ingresoDetalle->getId()) {
                $this->eliminarDetalle($detalle);
                $this->actualizarExistencia($detalle);
            }
        }
    }
    
    protected function eliminarDetalle($detalle)
    {
        if ($detalle->getEstado() === 'D') {
            $this->em->remove($detalle);
        } else {
            $this->em->clear();
            Thrower::throwValidationException('Error de Validacion', 'El articulo no esta disponible');
        }
    }
    
    protected function actualizarExistencia($detalle)
    {
        $this->articulo->getDetalle()->removeElement($detalle);
        $this->articulo->removeExistencia();
        $this->em->persist($this->articulo);
    }
}