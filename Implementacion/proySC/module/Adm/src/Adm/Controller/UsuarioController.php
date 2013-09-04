<?php

namespace Adm\Controller;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Adm\Usuario\Service\Listado\Select as SelectDeUsuarios;
use Adm\Usuario\Service\PersonasDisponibles\Select as SelectDePersonasDisponibles;
use EnterpriseSolutions\Simple\Repository\DataSource;
use EnterpriseSolutions\Simple\Service\Service as EsService;
use Adm\Usuario\Service\Creacion;
use Adm\Usuario\Repository;
use EnterpriseSolutions\Db\Dao\Get as GetDao;
class UsuarioController extends BaseController
{
	public function indexAction()
	{
		$select = new SelectDeUsuarios($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao,array(),array());
	}
	
	public function personasDisponiblesAction()
	{
		$select = new SelectDePersonasDisponibles($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao,array(),array());
	}
	
	public function getAction()
	{
		$select = new SelectDeUsuarios($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new GetDao($select);
		$template = $this->_crearTemplateParaGet('adm_usuario_id');
		return $template($dao,array());
	}
	
	public function postAction()
	{
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$ds = new DataSource($adapter);
		$repository = new Repository($ds);
		$creacion = new Creacion($repository);
		$params = $this->SubmitParams()->getParam('post');
		$service = function($params) use($creacion){
			return $creacion->ejecutar($params);
		};
		$esService = new EsService();
		$transaccion = $esService->transaccional($service,$ds);
		$respuesta = $transaccion($params);
		return $this->_returnAsJson($respuesta);
	}
}