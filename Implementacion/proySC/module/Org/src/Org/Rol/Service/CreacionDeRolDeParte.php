<?php

namespace Org\Rol\Service;

use Org\Rol\RolesDeParte;

use Doctrine\ORM\EntityManager;
use Org\Parte\Parte;
use Org\Rol\Repository as RolRepository;
use Org\Parte\Service\Creacion as creacionService;
use Org\Parte\Service\Edicion as edicionService;

class CreacionDeRolDeParte
{
	public $_rolRepository;
	public $_em;
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
		$this->_rolRepository = new RolRepository($em);
	}
	
	
	/**
	 * @param array $datos
	 * {
	 *  org_rol_codigo,
	 *  org_parte:{
	 *  	
	 *  }
	 * }
	 */
	public function ejecutar($datos)
	{
		$orgRolCodigo = $datos['org_rol_codigo'];
		$orgParte = $datos['org_parte'];
		$parte = $this->_crearOEditarParte($orgParte);
		$rolesDeParte = new RolesDeParte($parte, $this->_rolRepository);
		$rolDeParte = $rolesDeParte->agregar($orgRolCodigo);
		$this->_rolRepository
			 ->persistir($rolDeParte);
		return $rolDeParte;
	}
	
	/**
	 * @param array $datos
	 * @return Org\Parte\Parte
	 */
	public function _crearOEditarParte($datos)
	{
		$orgParteId = $datos['org_parte_id'];
		if(!$orgParteId){
			$service = new creacionService($this->_em);
		}else{
			$service = new edicionService($this->_em);
		}
		$parte = $service->ejecutar($datos);
		return $parte;
	}
}