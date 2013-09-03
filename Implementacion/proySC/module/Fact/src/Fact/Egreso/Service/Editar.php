<?php

namespace Fact\Egreso\Service;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;
use Fact\Egreso\Egreso;
use Stock\Detalle\Service\Disponibilizar as DisponibilizarDetalleService;

class Editar
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
    
    public function __construct($em)
    {
        $this->em     = $em;
        $this->egreso = null;
    }
    
    public function ejecutar($data)
    {
        // Obtener el egreso
        $this->egreso = $this->getEgreso($data['fact_egreso_id']);
        $estadoFuturo = $data['estado'];
        
        $detalles = $this->egreso->getDetalle();
        
        switch ($estadoFuturo) {
        	case 'A':
        	    $this->anularEgreso($detalles);
        	    break;
        	default:
        	    break;
        }
    }
    
    protected function getEgreso($id)
    {
        $egreso = $this->em->find('Fact\Egreso\Egreso', $id);
        if (!$egreso->getNroDocumento()) {
            Thrower::throwValidationException('El egreso no tiene asignado un Nro. de Documento');
        }
        
        return $egreso;
    }
    
    /**
     * Anular Egreso
     * 
     */
    protected function anularEgreso($detalles)
    {
        foreach ($detalles as $detalle) {
            // Verificar que los articulos se hayan vendidao (todos tienen que estar en V)
            // Disponibilizar los articulos
            // Actualizar la existencia del articulo
            $service = new DisponibilizarDetalleService($this->em, $detalle);
            $service->ejecutar(array());
        }
        
        // Cambiar el estado del egreso
        // Marcar para guardar
        $this->editarEgreso('A');
    }
    
    /**
     * Actualizar el estado del ingreso
     * @param array $data
     */
    protected function editarEgreso($estado)
    {
        $this->egreso->setEstado($estado);
        $this->em->persist($this->egreso);
    }
    
    public function persistir()
    {
        $this->em->flush();
    }
    
    public function getRespuesta()
    {
        return array(
            'fact_egreso_id' => $this->egreso->getId(),
            'exitoso'        => true,
        );
    }
}