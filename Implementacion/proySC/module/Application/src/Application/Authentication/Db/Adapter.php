<?php

namespace Application\Authentication\Db;
use Zend\Stdlib\Hydrator\ObjectProperty;

use Application\Authentication\Identidad;

use Zend\Authentication\Validator\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use Application\Authentication\Credenciales;
use Application\Authentication\Db\AuthDao;
use Zend\Db\ResultSet\ResultSet;
use Zend\Authentication\Result as AuthenticationResult;

class Adapter implements AdapterInterface
{
	protected $_dao;
	public $_credenciales;
	protected $_passwordEncoder;
	protected $_authResult;
	
	public function __construct(AuthDao $dao,$passwordEncoder = null)
	{
		$this->_dao = $dao;
		$this->_passwordEncoder = $passwordEncoder;
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 */
	public function authenticate()
	{
	    $usuarios = $this->_dao->findUsuarios($this->_credenciales);
	    $resultado = $this->_validarResultadosDeConsulta($usuarios);
	    if($resultado){
	    	return $resultado;
	    }
	    
	    $usuario = $usuarios->current();
	    $resultado = $this->_bloquearSiHayActividadSospechosa($usuario);
	    if($resultado){
	    	return $resultado;
	    }
	    
	    return $this->_autenticarUsuarioConCredenciales($this->_credenciales, $usuario);
	}
	
	public function setCredenciales(Credenciales $credenciales)
	{
		$this->_credenciales = $credenciales;
	}
	
    /**
     * @param ResultSet $usuarios
     * @return NULL|\Zend\Authentication\Result
     */
    public function _validarResultadosDeConsulta(ResultSet $usuarios)
    {
    	if($usuarios->count() == 1){
    		return null;
    	}else if($usuarios->count() < 1){
    		return $this->_setAuthResult(AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND, array('Credenciales Invalidas'));
    	}else{
    		return $this->_setAuthResult(AuthenticationResult::FAILURE_IDENTITY_AMBIGUOUS, array('Credenciales Invalidas'));
    	}
    }
    
    /**
     * @param unknown_type $usuario
     * @return NULL|\Zend\Authentication\Result
     */
    public function _bloquearSiHayActividadSospechosa($usuario)
    {
        return null;
    }

    /**
     * @param unknown_type $credenciales
     * @param unknown_type $usuario
     * @return \Zend\Authentication\Result
     */
    public function _autenticarUsuarioConCredenciales($credenciales,$usuario)
    {
    	$password = $credenciales->contrasenha;
    	
    	if($this->_passwordEncoder){
    		$passwordEncoder = $this->_passwordEncoder;
    		$password = $passwordEncoder($password);
    	}
    	
    	if($usuario->contrasenha != $password){
    	    return $this->_setAuthResult(AuthenticationResult::FAILURE_CREDENTIAL_INVALID,array('Credenciales Invalidas'),$usuario);
    	}
    	
    	/*if($usuario->estado == 'B'){
    		return $this->_setAuthResult(AuthenticationResult::FAILURE, array('Usuario no activo'),$usuario);
    	}*/
    	
    	if($usuario->estado == 'B'){
    		return $this->_setAuthResult(AuthenticationResult::FAILURE, array('Usuario bloqueado'),$usuario);
    	}
    	
    	return $this->_setAuthResult(AuthenticationResult::SUCCESS, array('Autenticacion exitosa'),$usuario);
    }
    
    /**
     * @param string $codigo
     * @param array $mensajes
     * @param unknown_type $identidad
     * @return \Zend\Authentication\Result
     */
    public function _setAuthResult($codigo,$mensajes,$identidad = null)
    {
    	$identidadObject = new Identidad();
    	if($identidad){
    		$hydrator = new ObjectProperty();
    		$hydrator->hydrate($identidad->getArrayCopy(), $identidadObject);
    	}
    	
    	$this->_authResult = new AuthenticationResult($codigo,$identidadObject,$mensajes);
    	return $this->_authResult;
    }
}