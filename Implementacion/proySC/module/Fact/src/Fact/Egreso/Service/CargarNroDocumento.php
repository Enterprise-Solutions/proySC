<?php

namespace Fact\Egreso\Service;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;
use Fact\Egreso\Egreso;

class CargarNroDocumento
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
        $this->egreso = $this->getEgreso($data['fact_egreso_id']);
        $this->cargarNro($data['doc_nro']);
        $this->em->persist($this->egreso);
    }
    
    protected function getEgreso($id)
    {
        return $this->em->find('Fact\Egreso\Egreso', $id);
    }
    
    protected function cargarNro($doc_nro)
    {
        if (!($this->egreso instanceof Egreso)) {
            Thrower::throwValidationException('Error de Validacion', 'No se encuentra el egreso solicitado');
        }
        
        $this->egreso->setNroDocumento($doc_nro);
    }
    
    public function persistir()
    {
        $this->em->flush();
    }
    
    public function getResult()
    {
        return array(
            'fact_egreso_id' => $this->egreso->getId(),
            'exitoso'        => true,
        );
    }
}