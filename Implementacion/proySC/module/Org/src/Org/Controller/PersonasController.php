<?php

namespace Org\Controller;



use Org\Controller\ParteController;

class PersonasController extends ParteController
{
	public function indexAction($overwritedParams = array())
	{
		return parent::indexAction(array('s' => array('org_parte_tipo_codigo' => 'per')));
	}
	
	public function crearAction($orgParteTipoCodigo = null)
	{
		return parent::crearAction('per');
	}
}