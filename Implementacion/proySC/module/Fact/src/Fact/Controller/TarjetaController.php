<?php

namespace Fact\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Fact\Tarjeta\QueryObject\Select;
use Fact\Tarjeta\Service\Crear as CrearTarjetaService;

class TarjetaController extends BaseController
{
    public function indexAction()
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), array());
    }
    
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearTarjetaService($em);
        $service->ejecutar($data);
        $service->persistir();
        
        return $this->toJson($service->getRespuesta());
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