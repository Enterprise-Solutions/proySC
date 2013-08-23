<?php

namespace Fact\Egreso\Service;

use Doctrine\ORM\EntityManager;

use Fact\Egreso\Egreso;

use Fact\Detalle\Service\Egreso\Crear as CrearDetalleEgresoService;
use Fact\Egreso\Cliente;
use Fact\Egreso\Vendedor;

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
    
    public function __construct($em)
    {
        $this->em     = $em;
        $this->egreso = null;
    }
    
    public function ejecutar($data)
    {
        $this->crearEgreso($data['Egreso']);
        $this->crearEgresoDetalle($data['Detalle']);
        $this->asignarCliente($data['Cliente']);
        $this->asignarVendedor($data['Vendedor']);
    }
    
    /**
     * Crea el egreso y persiste
     * @param array $data
     */
    protected function crearEgreso($data)
    {
        $this->egreso = new Egreso();
        $this->egreso->fromArray($data);
        $this->egreso->setDefaultValues();
        $this->em->persist($this->egreso);
    }
    
    /**
     * Crea los detalles del egreso
     * @param array $data
     */
    protected function crearEgresoDetalle($data)
    {
        $service = new CrearDetalleEgresoService($this->em, $this->egreso);
        
        for ($i=0; $i<count($data); $i++) {
            $service->init();
            $service->ejecutar($data[$i]);
            $detalle = $service->getDetalle();
            $this->egreso->add($detalle);
        }
    }
    
    protected function asignarCliente($data)
    {
    	if (isset($data['org_parte_rol_id'])) {
    	    $cliente = $this->em->find('Org\Rol\RolDeParte', $data['org_parte_rol_id']);
    	    $egreso  = $this->egreso;
    	    
    		$clienteAsignado = new Cliente();
    		$clienteAsignado->setEgreso($egreso);
    		$clienteAsignado->setCliente($cliente);
    		
    		$this->em->persist($clienteAsignado);
    	}
    }
    
    protected function asignarVendedor($data)
    {
        if (isset($data['org_parte_rol_id'])) {
            $vendedor = $this->em->find('Org\Rol\RolDeParte', $data['org_parte_rol_id']);
            $egreso   = $this->egreso;
            	
            $vendedorAsignado = new Vendedor();
            $vendedorAsignado->setEgreso($egreso);
            $vendedorAsignado->setVendedor($vendedor);
    
            $this->em->persist($vendedorAsignado);
        }
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