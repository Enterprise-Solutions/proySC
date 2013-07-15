<?php

namespace Fact\Controller;

use EnterpriseSolutions\Controller\BaseController;
use Fact\Compras\ServiceManager;

use Fact\Ingreso\Service\Crear as CrearIngresoService;

class CompraController extends BaseController
{
    /**
     * Valida los datos del detalle
     */
    public function validateAction()
    {
        $data = $this->SubmitParams()->getParam('Detalle');
        
        $serviceManager = $this->getServiceManager();
        $serviceManager->validateDetalle($data);
        
        return $this->toJson($serviceManager->getResult());
    }
    
    /**
     * Ultimo costo del articulo comprado a un proveedor
     */
    public function getLastCostAction()
    {
        
    }
    
    /**
     * Detalle del Ingreso
     */
    public function getAction()
    {
    
    }
    
    /**
     * Crear Ingreso
     */
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearIngresoService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    /**
     * Editar Ingreso
     */
    public function putAction()
    {
        
    }
    
    /**
     * Eliminar Ingreso
     */
    public function deleteAction()
    {
        
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
    
    protected function getServiceManager()
    {
        return new ServiceManager($this->getEntityManager());
    }
}