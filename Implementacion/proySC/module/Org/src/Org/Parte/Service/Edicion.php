<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

use Doctrine\ORM\EntityManager;

class Edicion
{
	public $_em;
	public $_repository;
	public function __construct(EntityManager $em)
	{
		$this->_repository = new Repository($em);
	}
	
	/**
	 * @param array $datos
	 * @return Org\Parte\Parte
	 * 
	 * {
	 *	org_parte_id:int,
	 *	...	
	 * }
	 */
	public function ejecutar($datos)
	{
		$orgParteId = $datos['org_parte_id'];
		$parte = $this->_repository->get($orgParteId);
		$parte->editar($datos);
		$this->_repository
			 ->persistir($parte);
		$this->_setRespuesta($parte);
		return $parte;
	}
	
	public function _setRespuesta($parte)
	{
		$this->_respuesta = array('org_parte' => $parte->toArray());
	}
	
	public function getRespuesta()
	{
		return $this->_respuesta;
	}
}