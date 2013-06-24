<?php

namespace Org\Controller;

use Org\Controller\ParteController;

class EmpresasController extends ParteController 
{
	public function indexAction()
	{
		return parent::indexAction(array('s' => array('org_parte_tipo_codigo' => 'org')));
	}
	
	public function crearAction()
	{
		return parent::crearAction('org');
	}
}