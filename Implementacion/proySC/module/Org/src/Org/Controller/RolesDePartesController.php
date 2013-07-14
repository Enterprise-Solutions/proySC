<?php

namespace Org\Controller;
use Org\Rol\Repository;

use Org\Rol\RolesDeParte;
//use EnterpriseSolutions\Db\Dao;
use Org\Parte\Service\Listado\Dao;
use Org\Parte\Service\Transaccional;
use Org\Rol\Service\CreacionDeRolDeParte as Service;
use Org\Rol\Service\DesactivarRolesDePartes as DesactivarService;

use Org\Rol\Service\Listado\Select as RolesDePartesSelect;
use EnterpriseSolutions\Controller\BaseController;

class RolesDePartesController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
		$defaultParams = array('s' => array('estado' => 'A'));
		$select = new RolesDePartesSelect($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao,$defaultParams,$overwritedParams);
	}
	
	public function crearAction($org_rol_codigo = null)
	{
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$actionService = new Service($em);
		$service = new Transaccional($em,$actionService);
		$datos = $this->SubmitParams()->getParam('post');
		if($org_rol_codigo){
			$datos['org_rol_codigo'] = $org_rol_codigo;
		}
		$service->ejecutar($datos);
		return $this->_returnAsJson($service->getRespuesta());
	}
	
	public function desactivarAction()
	{
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$repository = new Repository($em);
		$actionService = new DesactivarService($repository);
		$service = new Transaccional($em,$actionService);
		$datos = $this->SubmitParams()->getParam('post');
		$service->ejecutar($datos);
		return $this->_returnAsJson($service->getRespuesta());
	}
	
	public function _returnAsJson($respuesta)
	{
		$viewModel = $this->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
				'text/html','application/json'
		)));
		$viewModel->setVariables($respuesta);
		return $viewModel;
	}
}