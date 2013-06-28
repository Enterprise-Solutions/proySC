<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

class Borrado
{
	public $_repository;
	public $_resultado = array();
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($ids)
	{
		$partes = $this->_repository->find($ids);
		foreach($partes as $parte){
			$this->_repository->borrar($parte);
			$this->_agregarAResultado($parte);
		}
		return $partes;
	}
	
	public function _agregarAResultado($parte)
	{
		$this->_resultado[] = $parte->toArray();
	}
	
	public function getRespuesta()
	{
		return $this->_resultado;
	}
}