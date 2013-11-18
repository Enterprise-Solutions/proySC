<?php

namespace Fact\Controller;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Controller\BaseController;
use Fact\Movimiento\Ingreso as CrearIngresoService;

class MovimientoController extends BaseController
{
    /**
     * Crear movimiento interno de entrada
     */
    public function entradaAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearIngresoService($em);
        $service->ejecutar($data);
        $service->persistir();
        
        return $this->toJson($service->getRespuesta());
    }
    
    /**
     * Crear movimiento interno de salida
     */
    public function salidaAction()
    {
        
    }
    
    /**
     * Convierte un array a json
     * @param array $respuesta
     */
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
                array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    /**
     * Obtiene el Doctrine Entity Manager
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
}