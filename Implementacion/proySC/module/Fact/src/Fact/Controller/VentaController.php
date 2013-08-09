<?php

namespace Fact\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Fact\Egreso\QueryObject\Select;

class VentaController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
	    $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
	    $dao = new Dao($select);
	    $template = $this->_crearTemplateParaListado();
	    return $template($dao, array(), $overwritedParams);
	}
}