<?php

namespace Fact\Movimiento;

use Doctrine\ORM\EntityManager;
use Fact\Detalle\Service\Ingreso\CrearInterno as CrearMovInternoService;
use Fact\Ingreso\Ingreso as IngresoInterno;
use Fact\Ingreso\Proveedor;

class Ingreso
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * IngresoInterno
     * @var Ingreso
     */
    protected $ingreso;
    
    public function __construct($em)
    {
        $this->em = $em;
        $this->ingreso = null;
    }
    
    public function ejecutar($data)
    {
        $this->crearIngreso($data['Ingreso']);
        $this->crearIngresoDetalle($data['Detalle']);
        $this->asignarProveedor($data['Proveedor']);
    }
    
    /**
     * Crea el ingreso y persiste
     * @param array $data
     */
    protected function crearIngreso($data)
    {
        $this->ingreso = new IngresoInterno();
        $this->ingreso->esMovimientoInterno();
        $this->ingreso->fromArray($data);
        $this->ingreso->setDefaultValues();
        $this->em->persist($this->ingreso);
    }
    
    /**
     * Crea los detalles del ingreso
     * @param array $data
     */
    protected function crearIngresoDetalle($data)
    {
        $service = new CrearMovInternoService($this->em, $this->ingreso);
    
        for ($i=0; $i<count($data); $i++) {
            $service->init();
            $service->ejecutar($data[$i]);
            $detalle = $service->getDetalle();
            $this->ingreso->add($detalle);
        }
    }
    
    protected function asignarProveedor($data)
    {
        if (isset($data['org_parte_rol_id'])) {
            $proveedor = $this->em->find('Org\Rol\RolDeParte', $data['org_parte_rol_id']);
            $ingreso   = $this->ingreso;
            
            $proveedorAsignado = new Proveedor();
            $proveedorAsignado->setIngreso($ingreso);
            $proveedorAsignado->setProveedor($proveedor);
            
            $this->em->persist($proveedorAsignado);
        }
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