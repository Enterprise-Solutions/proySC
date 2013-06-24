<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

use Doctrine\ORM\EntityManager;
use Org\Parte\Factory;

class Creacion
{
	public $_em;
	public $_factory;
	public $_repository;
	public $_respuesta  = array();
	public function __construct(EntityManager $em)
	{
		$this->_factory = new Factory($em);
		$this->_repository = new Repository($em);   	
	}
	
	/**
	 * @param unknown_type $datos
	 * @return Org\Parte\Parte
	 * {
	 *   org_parte_id:null,
	 *   org_parte_tipo_codigo:per,
	 *   
	 * }
	 */
	public function ejecutar($datos)
	{
		$orgParteTipoCodigo = $datos['org_parte_tipo_codigo'];
		$parte = $this->_factory->crear($orgParteTipoCodigo);
		$parte->crear($datos);
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