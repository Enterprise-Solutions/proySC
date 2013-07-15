<?php

namespace Fact\Ingreso\Service;

use Doctrine\ORM\EntityManager;
use Fact\Ingreso\Ingreso;
use Fact\Detalle\Service\Crear as CrearDetalleIngresoService;

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
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function ejecutar($data)
    {
        $this->crearIngreso($data['Ingreso']);
        $this->crearIngresoDetalle($data['Detalle']);
        $this->em->persist($this->ingreso);
    }
    
    protected function crearIngreso($data)
    {
        $this->ingreso = new Ingreso();
        $this->ingreso->fromArray($data);
        $this->ingreso->setDefaultValues();
    }
    
    protected function crearIngresoDetalle($data)
    {
        $service = new CrearDetalleIngresoService($this->em, $this->ingreso);
        $size = count($data);
        
        for ($i=0; $i<$size; $i++) {
            $service->init();
            $service->ejecutar($data[$i]);
            $detalle = $service->getDetalle();
            $this->ingreso->add($detalle);
        }
    }
    
    public function getRespuesta()
    {
        return array(
        	'fact_ingreso_id' => $this->ingreso->getId(),
            'exitoso'         => true,
        );
    }
}