<?php

namespace Cont\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Cont\Moneda\Listado\Select;
use Cont\Moneda\Service\Creacion;

class MonedaController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao, array(), $overwritedParams);
	}
	
	
}