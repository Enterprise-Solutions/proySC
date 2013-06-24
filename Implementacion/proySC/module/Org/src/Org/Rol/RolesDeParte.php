<?php

namespace Org\Rol;

use Org\Parte\Parte;
use Org\Rol\Repository;
class RolesDeParte
{
	public $_parte;
	public $_repository;
	public function __construct(Parte $parte,Repository $repository)
	{
		$this->_parte = $parte;
		$this->_repository = $repository;
	}
	
	public function agregar($orgRolCodigo)
	{
		$rol = $this->_repository->getRol($orgRolCodigo);
		$rolDeParte = new RolDeParte();
		$rolDeParte->setParte($this->_parte);
		$rolDeParte->setRol($rol);
		//$this->_repository->persistir($rolDeParte);
		return $rolDeParte;
	}
}