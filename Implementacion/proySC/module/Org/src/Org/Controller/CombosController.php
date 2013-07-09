<?php

namespace Org\Controller;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Select;
use EnterpriseSolutions\Db\Dao;

class CombosController extends BaseController
{
	public function orgParteTipoAction()
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$select->_select->from('org_parte_tipo');
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao);
	}
	
	public function orgRolAction()
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$select->_select->from('org_rol');
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao);
	}
	
	public function orgDocumentoTipoAction()
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$select->_select->from('org_documento_tipo');
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao);
	}
}