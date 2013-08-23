<?php

namespace Org\Parte\Service;

use Org\Parte\Repository;

use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\Adapter;
use Org\Parte\Factory;

use Org\Documento\Documento\Factory as docFactory;
use Org\Documento\Repository as docRepository;
use Org\Documento\Service as docService;

use Org\Contacto\Factory as contactosFactory;
use Org\Contacto\Repository as contactosRepository;
use Org\Contacto\Service as contactosService;

use Org\Direccion\Factory as dirFactory;
use Org\Direccion\Repository as dirRepository;
use Org\Direccion\Service as dirService;

class Creacion
{
	public $_em;
	public $_factory,$_docFactory,$_contactosFactory,$_dirFactory;
	public $_repository,$_docRepository,$_contactosRepository,$_dirRepository;
	public $_respuesta  = array();
	public function __construct(EntityManager $em,Adapter $adapter = null)
	{
		$this->_factory = new Factory($em);
		$this->_repository = new Repository($em,$adapter); 
		
		$this->_docRepository = new docRepository($em);
		$this->_docFactory = new docFactory($this->_docRepository);

		$this->_contactosRepository = new contactosRepository($em);
		$this->_contactosFactory = new contactosFactory($this->_contactosRepository);
		
		$this->_dirFactory = new dirFactory();
		$this->_dirRepository = new dirRepository($em);
	}
	
	/**
	 * @param unknown_type $datos
	 * @return Org\Parte\Parte
	 * {
	 *   org_parte_id:null,
	 *   org_parte_tipo_codigo:per,
	 *   Documentos:{
	 *   	agregados:[],editados:[],borrados:[]
	 *   }
	 * }
	 */
	public function ejecutar($datos)
	{
		$orgParteTipoCodigo = $datos['org_parte_tipo_codigo'];
		$parte = $this->_factory->crear($orgParteTipoCodigo);
		$parte->setRepository($this->_repository);
		$parte->crear($datos);
		$this->_repository
		     ->persistir($parte);
		$this->_setRespuesta($parte);
		$datos['org_parte'] = $parte;
		$this->_mantenerDocumentosDeParte($datos);
		$this->_mantenerContactosDeParte($datos);
		$this->_mantenerDireccionesDeParte($datos);
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
	
	public function _mantenerContactosDeParte($datos)
	{
		if(!isset($datos['Contactos'])){
			return;
		}
		$service = new contactosService($this->_contactosFactory,$this->_contactosRepository);
		$service->ejecutar($datos);
		$this->_respuesta['Contactos'] = $service->getRespuesta();
	}
	
	public function _mantenerDireccionesDeParte($datos)
	{
		if(!isset($datos['Direcciones'])){
			return;
		}
		$service = new dirService($this->_dirFactory,$this->_dirRepository);
		$service->ejecutar($datos);
		$this->_respuesta['Direcciones'] = $service->getRespuesta();
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