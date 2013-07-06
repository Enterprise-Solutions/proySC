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
        return $template($dao, array('id' => 1));
    }
    
    public function postAction()
    {
        // Extraer datos del cliente
        $data = $this->SubmitParams()->getParam('post');
        
        // Pasar los datos al service manager para la creacion
        $serviceManager = $this->getServiceManager();
        $serviceManager->create($data);
        
        $viewModel = $this->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
				'text/html','application/json'
		)));
		$viewModel->setVariables($serviceManager->getResult());
		return $viewModel;
    }
    
    public function putAction()
    {
        $data = $this->SubmitParams()->getParam('put');
        
        $serviceManager = $this->getServiceManager();
        $serviceManager->update($data);
        
        return $serviceManager->getResult();
    }
    
    public function deleteAction()
    {
        $data = $this->SubmitParams()->getParam('delete');
        
        $serviceManager = $this->getServiceManager();
        $serviceManager->delete($data);
        
        return $serviceManager->getResult();
    }
    
    protected function getServiceManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return new ServiceManager($em);
    }
}