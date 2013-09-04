<?php

namespace Adm\Usuario\Service;
use EnterpriseSolutions\Simple\Cambios\Cambios;
use Adm\Usuario\Repository;
use EnterpriseSolutions\Exceptions\Thrower;
use Adm\Usuario\Service\Creacion\Validacion;
class Edicion
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
		$this->_passwordEncoder = function($password){
			return md5($password);
		};
	}
	
	public function ejecutar($params)
	{
		/*
		 * Validar los datos enviados
		 * Si fue enviada la contrasenha incluir en cambios
		 * */
		$admUsuario = $this->_repository->getAdmUsuario($params['adm_usuario_id']);
		$this->_validarOperacion($admUsuario, $params);
		$this->_editarAdmUsuario($admUsuario, $params, $this->_repository, $this->_passwordEncoder);
	}
	
	public function _validarOperacion($admUsuario,$params)
	{
		if(!$admUsuario){
			Thrower::throwValidationException("Error de validacion",array('No se ha encontrado el usuario'));
		}
		if(isset($params['contrasenha'])){
			$validacion = new Validacion();
			$validadores = $validacion->crearValidadorDeContrasenhaYConfirmacion($this->_repository->getRequisitosDePassword());
			$resultado = array_reduce(
					$validadores,
					function($resultado,$validador) use($params){
						$resultado = $validador($params,$resultado);
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
	}
	
	public function _editarAdmUsuario($admUsuario,$params,$repository,$passwordEncoder)
	{
		$cambiosEnviados = array();
		if(isset($params['estado'])){
			$cambiosEnviados[] = array('estado' => $params['estado']);
		}
		
		if(isset($params['contrasenha'])){
			$cambiosEnviados[] = array('contrasenha' => $this->_passwordEncoder);
		}
		
		$cambios = new Cambios();
		$cambiosAdmUsuario = $cambios->cambiar($admUsuario, $cambiosEnviados);
		$repository->persistirCambiosADatos($cambiosAdmUsuario,$admUsuario,'adm_usuario','adm_usuario_id');
	}
}