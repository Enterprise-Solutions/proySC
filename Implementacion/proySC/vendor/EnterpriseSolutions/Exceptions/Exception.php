<?php

namespace EnterpriseSolutions\Exceptions;

class Exception extends \Exception
{
	/**
	 * @var string
	 */
	public $_mensaje;
	
	/**
	 * @var int
	 */
	public $_codigoDeRespuesta;
	
	/**
	 * @var array
	 */
	public $_datos;
	
	/**
	 * @param string $error
	 * @param unknown_type $codigoDeRespuesta
	 * @param unknown_type $datos
	 */
	public function __construct($mensaje,$codigoDeRespuesta,$datos = array())
	{
		$this->_mensaje = $mensaje;
		$this->_codigoDeRespuesta = $codigoDeRespuesta;
		$this->_datos = $datos;		
	}
	/**
	 * @return the $_mensaje
	 */
	public function getMensaje() {
		return $this->_mensaje;
	}

	/**
	 * @return the $_codigoDeRespuesta
	 */
	public function getCodigoDeRespuesta() {
		return $this->_codigoDeRespuesta;
	}

	/**
	 * @return the $_datos
	 */
	public function getDatos() {
		return $this->_datos;
	}

	
	
}