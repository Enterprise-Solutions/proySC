<?php

namespace Application\Authentication\Db;
use Zend\Db\Adapter\Adapter;
use Application\Authentication\Credenciales;
use Application\Authentication\Db\AuthSelect;
use Application\Authentication\Db\DefaultAuthParamsSelect;
use \Exception;

class AuthDao
{
	protected $_adapter;
	protected $_defaultParams;
	public function __construct(Adapter $adapter)
	{
		$this->_adapter = $adapter;
	}
	
	/**
	 * @param Credenciales $credenciales
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function findUsuarios(Credenciales $credenciales)
	{
		$credenciales = $this->_completarCredencialesConValoresPorDefault($credenciales);
		$select = new AuthSelect($this->_adapter);
		/*$select->addSearchByDocNro($credenciales->cedula)
		       ->addSearchByDirPaisId($credenciales->dirPaisId)
		       ->addSearchByPerDocTipoId($credenciales->perDocTipoId);*/
		$select->addSearchByValor($credenciales->cedula)
			   ->addSearchByOrgDocumentoTipoCodigo($credenciales->orgDocumentoTipoCodigo)
			   ->addSearchByDirPaisId($credenciales->dirPaisId);
		$rs = $select->execute();
		return $rs;
	}
	
	public function _completarCredencialesConValoresPorDefault(Credenciales $credenciales)
	{
		if($credenciales->dirPaisId == false){
			//$credenciales->dirPaisId = $this->_getDefaultParamValue('defaultDirPais');
			$credenciales->dirPaisId = 1;
		}
		
		if($credenciales->orgDocumentoTipoCodigo == false){
			$credenciales->orgDocumentoTipoCodigo = 'cedula';//$this->_getDefaultParamValue('defaultOrgDocumentoTipoCodigo');
		}
		return $credenciales;
	}
	
	public function _getDefaultParamValue($param_cod)
	{
		if(!$this->_defaultParams){
			$query = new DefaultAuthParamsSelect($this->_adapter);
			$this->_defaultParams = $query->execute()->toArray();
		}
		
		foreach($this->_defaultParams as $param){
			if($param['param_cod'] == $param_cod){
				return $param['valor'];
			}
		}
		throw new Exception("Error en consulta de parametros en sistema de autenticacion!!");
	}
}