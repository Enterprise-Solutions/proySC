<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

class Borrado
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($ids)
	{
		$partes = $this->_repository->find($ids);
		foreach($partes as $parte){
			$this->_repository->borrar($parte);
		}
		return partes;
	}
}