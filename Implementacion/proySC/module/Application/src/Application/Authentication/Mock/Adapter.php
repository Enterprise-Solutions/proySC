<?php

namespace Application\Authentication\Mock;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthenticationResult;

class Adapter implements AdapterInterface
{
	public function authenticate()
	{
		$usuario = array(
		    'adm_usuario_id' => 20		
	    );
		return new AuthenticationResult(AuthenticationResult::SUCCESS, array('Autenticacion exitosa'),$usuario);
	}
}