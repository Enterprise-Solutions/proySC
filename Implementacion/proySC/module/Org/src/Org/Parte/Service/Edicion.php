<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

use Doctrine\ORM\EntityManager;
use Org\Documento\Documento\Factory as docFactory;
use Org\Documento\Repository as docRepository;
use Org\Documento\Service as docService;

class Edicion
{
	public $_em;
	public $_docFactory;
	public $_repository,$_docRepository;
	public function __construct(EntityManager $em)
	{
		$this->_repository = new Repository($em);
		$this->_docRepository = new docRepository($em);
		$this->_docFactory = new docFactory($this->_docRepository);
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
		$datos['org_parte'] = $parte;
		$this->_mantenerDocumentosDeParte($datos);
		return $parte;
	}
	
	public function _mantenerDocumentosDeParte($datos)
	{
		if(!isset($datos['Documentos'])){
			return;
			//$datosDeDocumentos = $datos['Documentos'];
		}
		//$datosDeDocumentos = $datos['Documentos'];
		$service = new docService($this->_docFactory,$this->_docRepository);
		$service->ejecutar($datos);
		$this->_respuesta['Documentos'] = $service->getRespuesta();
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