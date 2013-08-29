<?php

namespace Adm\Controller;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Adm\Usuario\Service\Listado\Select as SelectDeUsuarios;
use Adm\Usuario\Service\PersonasDisponibles\Select as SelectDePersonasDisponibles;
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
}