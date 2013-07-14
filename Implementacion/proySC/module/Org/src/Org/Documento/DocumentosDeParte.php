<?php

namespace Org\Documento;

use Org\Parte\Parte;

use Org\Documento\Documento\Factory;

class DocumentosDeParte
{
	public $_parte;
	public $_factory;
	public $_repository;
	public $_documentos;
	public $_agregados = array();
	public function __construct(Factory $factory,Repository $repository, Parte $parte)
	{
		$this->_factory = $factory;
		$this->_repository = $repository;
		$this->_parte = $parte;
	}
	
	/**
	 * @param array $datos
	 * [{org_documento_tipo_codigo:string,valor:string},{}]
	 */
	public function agregarDocumentos($datos)
	{
		foreach($datos as $docData){
			$documento = $this->_factory->crearDocumento($docData['org_documento_tipo_codigo']);
			$documento->setParte($this->_parte);
			$documento->crear($docData);
			$this->_repository->persistir($documento);
			$this->_documentos[] = $documento;
		}
		return $this;
	}
	
	/**
	 * @param array $datos
	 * [{org_documento_id:int,valor:string}]
	 */
	public function editarDocumentos($datos)
	{
		foreach($datos as $docData){
			$documento = $this->_getDocumento($datos['org_documento_id']);
			$documento->editar($docData);
			$this->_repository->persistir($documento);
		}
	}
	
	public function borrarDocumentos($datos)
	{
		$borrados = array();
		
		foreach($datos as $orgDocumentoId){
			$documento = $this->_getDocumento($orgDocumentoId);
			$this->_repository->borrar($documento);
			$borrados[] = $orgDocumentoId;
		}
		
		$this->_documentos = array_filter(
			$this->_documentos,
			function($documento) use ($borrados){
				if(in_array($documento->getId(), $borrados)){
					return false;
				}
				return true;
		});
	}
	
	/**
	 * @param unknown_type $orgDocumentoId
	 * @return Org\Documento\Documento
	 */
	public function _getDocumento($orgDocumentoId)
	{
		foreach($this->_documentos as $documento){
			if($documento->getId() == $documento){
				return $documento;
			}
		}
		return false;
	}
}