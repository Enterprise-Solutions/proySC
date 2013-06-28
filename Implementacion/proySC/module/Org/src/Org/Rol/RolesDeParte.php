<?php

namespace Org\Rol;

use Org\Parte\Parte;
use Org\Rol\Rol;
use Org\Rol\Repository;
use EnterpriseSolutions\Exceptions\Exception;
use EnterpriseSolutions\Exceptions\Thrower;
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
		$this->_validarRolNoRepetido($rol)
		     ->_validarRolPermitido($rol);
		
		$rolDeParte = new RolDeParte();
		$rolDeParte->setParte($this->_parte);
		$rolDeParte->setRol($rol);
		//$this->_repository->persistir($rolDeParte);
		return $rolDeParte;
	}
	
	/**
	 * @param Rol $rol
	 * @throws Exception
	 */
	public function _validarRolNoRepetido($rol)
	{
		$rolDeParte = $this->_repository->findRolDeParte($rol->getCodigo(),$this->_parte->getId());
		if($rolDeParte){
			Thrower::throwValidationException("La parte ya tiene el rol {$rol->nombre}!");
		}
		return $this;
	}
	
	/**
	 * @param unknown_type $rol
	 * @throws Exception
	 */
	public function _validarRolPermitido($rol)
	{
		return $this;
	}
}