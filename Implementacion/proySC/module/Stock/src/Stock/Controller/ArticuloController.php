<?php

namespace Stock\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

use Stock\Articulo\QueryObject\Select;
use Stock\Articulo\QueryObject\Get;

use Stock\Articulo\ServiceManager;

class ArticuloController extends BaseController
{
    public function indexAction($overwritedParams = array())
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function getAction()
    {
        $query = new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new DaoGet($query);
        $template = $this->_crearTemplateParaGet();
        return $template($dao, array());
    }
    
    public function postAction()
    {
        // Extraer datos del cliente
        $data = $this->SubmitParams()->getParam('post');
        
        // Pasar los datos al service manager para la creacion
        $serviceManager = $this->getServiceManager();
        $serviceManager->create($data);
        
        return $this->toJson($serviceManager->getResult());
    }
    
    public function putAction()
    {
        // Extraer datos del cliente
        $data = $this->SubmitParams()->getParam('put');
        
        // Pasar los datos al sercice manager para la actualizacion
        $serviceManager = $this->getServiceManager();
        $serviceManager->update($data);
        
        return $this->toJson($serviceManager->getResult());
    }
    
    public function deleteAction()
    {
        $data = $this->SubmitParams()->getParam('delete');
        
        $serviceManager = $this->getServiceManager();
        $serviceManager->delete($id);
        
        return $this->toJson($serviceManager->getResult());
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json')
        ));
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    protected function getServiceManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return new ServiceManager($em);
    }
}