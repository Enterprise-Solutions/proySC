<?php

namespace Org\Rol\Service;
use Org\Rol\Repository;

class DesactivarRolesDePartes
{
	public $_repository;
	public $_respuesta = array();
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($ids)
	{
		$self = $this;
		$this->_respuesta[] = array_map(
			function($rolDeParte) use($self){
				$rolDeParte->desactivar();
				$self->_repository->persistir($rolDeParte);
				return $rolDeParte->toArray();
			},
			$this->_repository->findRolesDePartes($ids)
		);
	}
	
	public function getRespuesta()
	{
		return $this->_respuesta;
	} 
}