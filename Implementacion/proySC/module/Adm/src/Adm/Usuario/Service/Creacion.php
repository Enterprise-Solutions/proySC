<?php

namespace Adm\Usuario\Service;
use Adm\Usuario\Repository;
use EnterpriseSolutions\Simple\Cambios\Cambios;
use Adm\Usuario\Service\Creacion\Validacion;
use EnterpriseSolutions\Exceptions\Thrower;
class Creacion
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
		$this->_passwordEncoder = function($password){
			return md5($password);
		};
	}
	
	/**
	 * @param array $params
	 * {
	 *  org_parte_id,
	 *  contrasenha,
	 *  confirmacion,
	 * }
	 */
	public function ejecutar($params)
	{
		$params = $this->_validarYFiltrarParametrosRecibidos($params);
		$params = $this->_getDatosParaCrearUsuario($params);
		$this->_validarOperacion($params);
		$params['adm_usuario_id'] = $this->_crearAdmUsuario($params, $this->_repository, $this->_passwordEncoder);
		return $this->_construirRespuesta($params);
	}
	
	public function _validarYFiltrarParametrosRecibidos($params)
	{
		return array_merge(
			array('estado' => 'A'),
			$params
		);
	}
	
	public function _validarOperacion($datos)
	{
		/*
		 * Validar que la persona no sea ya usuario
		 * Validar que la persona tenga documento de identificacion 
		 * Validar contrasenha y confirmacion
		 * */
		$validacion = new Validacion();
		$validadores = array();
		$validadores[] = $validacion->crearValidadorDePersona();
		$validadores = array_merge(
				$validadores,
				$validacion->crearValidadorDeContrasenhaYConfirmacion($this->_repository->getRequisitosDePassword())
		);
		//$validadores = $validacion->crearValidadorDeContrasenhaYConfirmacion($this->_repository->getRequisitosDePassword());
		
		$resultado = array_reduce(
			$validadores, 
			function($resultado,$validador) use($datos){
				$resultado = $validador($datos,$resultado);
				return $resultado;
			},
			array(
				'valido' => true,
				'mensajes' => array()	
			)
		);
		if(!$resultado['valido']){
			Thrower::throwValidationException('Error de validacion',$resultado['mensajes']);
		}
	}
	
	public function _getDatosParaCrearUsuario($params)
	{
		$datos = $this->_repository->getDatosParaCrearUsuario($params['org_parte_id']);
		return array_merge($params,$datos);
	}
	
	public function _crearAdmUsuario($params,$repository,$passwordEncoder)
	{
		$cambios = new Cambios();
		$cambiosAdmUsuario = $cambios->cambiar(
			array(), 
			array(
				array('org_documento_id' => $params['org_documento_id']),
				array('contrasenha'      => $passwordEncoder($params['contrasenha'])),
				array('estado'           => $params['estado']),
				array('fecha_modif_contrasenha' => date('Y-m-d'))
			)
		);
		$cambiosAdmUsuarioId = $repository->persistirCambiosADatos($cambiosAdmUsuario, array(), 'adm_usuario', 'adm_usuario_id');
		return $cambios->getValorNuevo($cambiosAdmUsuarioId, 'adm_usuario_id');
	}
	
	public function _construirRespuesta($params)
	{
		return array(
			'status' => true,
			'mensaje' => 'Usuario creado Exitosamente',
			'datos'   => array(
				'adm_usuario_id' => $params['adm_usuario_id']
			)	
		);
	}
}