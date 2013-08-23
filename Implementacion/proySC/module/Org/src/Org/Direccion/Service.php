<?php

namespace Org\Direccion;
require_once 'DireccionesDeParte.php';

use Org\Direccion\Factory;
use Org\Direccion\Repository;
use Org\Direccion\DireccionesDeParte as f;


class Service
{
	public $_dirFactory;
	public $_dirRepository;
	public $_respuesta;
	public function __construct(Factory $dirFactory,Repository $dirRepository)
	{
		$this->_dirFactory = $dirFactory;
		$this->_dirRepository = $dirRepository;
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
			array('Direcciones' => array(
				'agregados' => array(),
				'editados'  => array(),
				'borrados'  => array()	
			)),
			$datos
	 	);
		$parte = $datos['org_parte'];
		$dirData = $datos['Direcciones'];
		$listado = $this->_dirRepository->findDireccionesDeParte($parte);
		
		$agregadosData = $dirData['agregados'];
		$agregados = f\crearDireccionesParaParte($agregadosData, $parte, $this->_dirFactory);
		$listado = array_merge($listado,$agregados);
		
		$editadosData = $dirData['editados'];
		$editados = f\editarDirecciones($editadosData, $listado);
		
		$borradosIds = $dirData['borrados'];
		$borrados = f\getDirecciones($borradosIds, $listado);
		$listado = f\removerDireccionesBorrados($borrados, $listado);
		
		$agregados = $this->_dirRepository->persistir($agregados);
		$editados  = $this->_dirRepository->persistir($editados);
		$borrados  = $this->_dirRepository->borrar($borrados);
		$this->_setRepuesta($agregados,$editados,$borrados);
	}
	
	public function _setRepuesta($agregados = array(),$editados = array(),$borrados = array())
	{
		$mapFunction = function($direccion){return $direccion->toArray();};
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