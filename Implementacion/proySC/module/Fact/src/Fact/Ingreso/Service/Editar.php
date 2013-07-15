<?php

namespace Fact\Ingreso\Service;

use Doctrine\ORM\EntityManager;
use Fact\Ingreso\Ingreso;

use Fact\Detalle\Service\Crear as CrearIngresoDetalleService;
use Fact\Detalle\Service\Editar as EditarIngresoDetalleService;
use Fact\Detalle\Service\Borrar as BorrarIngresoDetalleService;

class Editar
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
        $this->editarIngreso($data['Ingreso']);
        $this->actualizarDetalle($data['Detalle']);
        $this->em->persist($this->ingreso);
    }
    
    protected function editarIngreso($data)
    {
        $this->ingreso = $this->em->find('Fact\Ingreso\Ingreso', $data['fact_ingreso_id']);
        $this->ingreso->fromArray($data);
    }
    
    protected function actualizarDetalle($data)
    {
        // Separar los datos
        // Crear, editar y borrar detalles
    }
    
    protected function crearIngresoDetalle($data)
    {
        $service = new CrearIngresoDetalleService($this->em, $this->ingreso);
        $size = count($data);
        
        for ($i=0; $i<$size; $i++) {
            $service->init();
            $service->ejecutar($data[$i]);
            $detalle = $service->getDetalle();
            $this->ingreso->add($detalle);
        }
    }
    
    protected function editarIngresoDetalle($data)
    {
        $service = new EditarIngresoDetalleService();
        $size = count($data);
    }
    
    protected function borrarIngresoDetalle($data)
    {
        $service = new BorrarIngresoDetalleService();
        $size = count($data);
    }
    
    public function getRespuesta()
    {
        return array(
            'fact_ingreso_id' => $this->ingreso->getId(),
            'exitoso'         => true,
        );
    }
}