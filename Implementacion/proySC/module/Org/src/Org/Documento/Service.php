<?php

namespace Org\Documento;
require_once 'Documentos.php';

use Org\Documento\Documento\Factory;
use Org\Documento\Repository;
use Org\Documento\Documentos as f;


class Service
{
	public $_docFactory;
	public $_docRepository;
	public $_respuesta;
	public function __construct(Factory $docFactory,Repository $docRepository)
	{
		$this->_docFactory = $docFactory;
		$this->_docRepository = $docRepository;
	}
	
	/**
	 * @param array $datos
	 * {
	 *  org_parte:\Org\Documento\Parte\Parte,
	 *  Documentos{
	 *   agregados:[{},{}],editados:[{},{}],borrados:[]
	 *  }
	 * }
	 */
	public function ejecutar($datos)
	{
		$parte = $datos['org_parte'];
		$documentosData = $datos['Documentos'];
		$listado = $this->_docRepository->findDocumentosDeParte($parte);
		
		$agregadosData = $documentosData['agregados'];
		$agregados = f\crearDocumentosParaParte($agregadosData, $parte, $this->_docFactory);
		$listado = array_merge($listado,$agregados);
		
		$editadosData = $documentosData['editados'];
		$editados = f\editarDocumentos($editadosData, $listado);
		
		$borradosIds = $documentosData['borrados'];
		$borrados = f\getDocumentos($borradosIds, $listado);
		$listado = f\removerDocumentosBorrados($borrados, $listado);
		
		$agregados = $this->_docRepository->persistir($agregados);
		$editados  = $this->_docRepository->persistir($editados);
		$borrados  = $this->_docRepository->borrar($borrados);
		$this->_setRepuesta($agregados,$editados,$borrados);
	}
	
	public function _setRepuesta($agregados = array(),$editados = array(),$borrados = array())
	{
		$respuesta = array(
			'agregados' => $agregados,
			'editados' => $editados,
			'borrados' => $borrados
		);
		//Excluye los vacios, los que no fueron realizados por el servicio
		$this->_respuesta = array_filter($respuesta);
	}
	
	public function getRespuesta()
	{
		return $this->_respuesta;
	}
}