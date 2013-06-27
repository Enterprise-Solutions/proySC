<?php

namespace EnterpriseSolutions\Exceptions;
use EnterpriseSolutions\Exceptions\Exception;

class Thrower
{
	public static function throwValidationException($mensaje = 'Error de validacion!',$datos = array())
	{
		throw self::_createException($mensaje, 400, $datos);
	}
	
	public static function throwAuthenticationException($mensaje = 'Error de autenticacion',$datos = array())
	{
		throw self::_createException($mensaje, 401, $datos);
	}
	
	public static function throwAuthorizationException($mensaje = 'Error de autorizacion',$datos = array())
	{
		throw self::_createException($mensaje, 403, $datos);
	}
	
	public static function throwApplicationException($mensaje = 'Error de aplicacion!',$datos = array())
	{
		throw self::_createException($mensaje, 500, $datos);
	}
	
	public static function _createException($mensaje,$codigoDeRespuesta,$datos)
	{
		return new Exception($mensaje,$codigoDeRespuesta,$datos);
	}
}