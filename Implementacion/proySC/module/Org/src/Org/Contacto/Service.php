<?php

namespace Org\Contacto;
require_once 'ContactosDeParte.php';

use Org\Contacto\Factory;
use Org\Contacto\Repository;
use Org\Contacto\ContactosDePartes as f;


class Service
{
	public $_contactosFactory;
	public $_contactosRepository;
	public $_respuesta;
	public function __construct(Factory $contactosFactory,Repository $contactosRepository)
	{
		$this->_contactosFactory = $contactosFactory;
		$this->_contactosRepository = $contactosRepository;
	}
	
	/**
	 * @param array $datos
	 * {
	 *  org_parte:\Org\Documento\Parte\Parte,
	 *  Contactos{
	 *   agregados:[{},{}],editados:[{},{}],borrados:[]
	 *  }
	 * }
	 */
	public function ejecutar($datos)
	{
		$datos = array_merge_recursive(
			array('Contactos' => array(
				'agregados' => array(),
				'editados'  => array(),
				'borrados'  => array()	
			)),
			$datos
	 	);
		$parte = $datos['org_parte'];
		$contactosData = $datos['Contactos'];
		$listado = $this->_contactosRepository->findContactosDeParte($parte);
		
		$agregadosData = $contactosData['agregados'];
		$agregados = f\crearContactosParaParte($agregadosData, $parte, $this->_contactosFactory);
		$listado = array_merge($listado,$agregados);
		
		$editadosData = $contactosData['editados'];
		$editados = f\editarContactos($editadosData, $listado);
		
		$borradosIds = $contactosData['borrados'];
		$borrados = f\getContactos($borradosIds, $listado);
		$listado = f\removerContactosBorrados($borrados, $listado);
		
		$agregados = $this->_contactosRepository->persistir($agregados);
		$editados  = $this->_contactosRepository->persistir($editados);
		$borrados  = $this->_contactosRepository->borrar($borrados);
		$this->_setRepuesta($agregados,$editados,$borrados);
	}
	
	public function _setRepuesta($agregados = array(),$editados = array(),$borrados = array())
	{
		$mapFunction = function($contacto){return $contacto->toArray();};
		$respuesta = array(
			'agregados' => array_map($mapFunction,$agregados),
			'editados' => array_map($mapFunction,$editados),
			'borrados' => array_map($mapFunction,$borrados)
		);
		//Excluye los vacios, los que no fueron realizados por el servicio
		$this->_respuesta = array_filter($respuesta);
	}
	
	public function getRespuesta()
	{
		return $this->_respuesta;
	}
}