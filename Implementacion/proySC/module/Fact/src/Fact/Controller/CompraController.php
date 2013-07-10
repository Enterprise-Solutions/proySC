<?php

namespace Fact\Controller;

use EnterpriseSolutions\Controller\BaseController;
use Fact\Compras\ServiceManager;

class CompraController extends BaseController
{
    public function agregarAction()
    {
        $data = $this->SubmitParams()->getParam('IngresoDet');
        
        $serviceManager = $this->getServiceManager();
        $serviceManager->validateDetalle($data);
        
        return $this->toJson($serviceManager->getResult());
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    protected function getServiceManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return new ServiceManager($em);
    }
}