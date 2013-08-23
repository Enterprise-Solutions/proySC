<?php

namespace Fact\Ingreso\Service;

use Doctrine\ORM\EntityManager;
use Fact\Ingreso\Ingreso;

use Stock\Detalle\Service\Eliminar as EliminarDetalleService;

use EnterpriseSolutions\Exceptions\Thrower;

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
        $this->em      = $em;
        $this->ingreso = null;
    }
    
    public function ejecutar($data)
    {
        $estadoFuturo = $data['estado'];
        // Obtener el ingreso
        $this->ingreso = $this->em->find('Fact\Ingreso\Ingreso', $data['fact_ingreso_id']);
        $detalles = $this->ingreso->getDetalle();
        
        switch ($estadoFuturo) {
        	case 'A':
        	    $this->anularIngreso($detalles);
        	    break;
        	default:
        	    break;
        }
    }
    
    /**
     * Anular Ingreso
     * 
     */
    protected function anularIngreso($detalles)
    {
        foreach ($detalles as $detalle) {
            // Verificar la disponibilidad de los articulos (todos tienen que estar en D)
            // Eliminar los articulos
            // Actualizar la existencia del articulo
            $service = new EliminarDetalleService($this->em, $detalle);
            $service->ejecutar(array());
        }
        
        // Cambiar el estado del ingreso
        // Marcar para guardar
        $this->editarIngreso('A');
    }
    
    /**
     * Actualizar el estado del ingreso
     * @param array $data
     */
    protected function editarIngreso($estado)
    {
        $this->ingreso->setEstado($estado);
        $this->em->persist($this->ingreso);
    }
    
    public function persistir()
    {
        $this->em->flush();
    }
    
    public function getRespuesta()
    {
        return array(
            'fact_ingreso_id' => $this->ingreso->getId(),
            'exitoso'         => true,
        );
    }
}