<?php

namespace Adm\Usuario;

use Zend\Db\Adapter\Adapter;
use EnterpriseSolutions\Simple\Repository\Repository as EsRepository;
use Adm\Usuario\Repository\FindDatosDePersonaParaCrearUsuario as SelectDatosParaCrearUsuario;
use Adm\Usuario\Repository\SelectRequisitosDePassword;

class Repository extends EsRepository
{
	/**
	 * @param int $orgParteId
	 * @return array
	 */
	public function getDatosParaCrearUsuario($orgParteId)
	{
		$dbAdapter = $this->_ds->_getDbConnection();
		$select = new SelectDatosParaCrearUsuario($dbAdapter);
		$select->addSearchByOrgParteId($orgParteId);
		$rs = $select->execute()->toArray();
		if(count($rs) <= 0){
			return false;
		}
		return current($rs);
	}
	
	public function getRequisitosDePassword()
	{
		$dbAdapter = $this->_ds->_getDbConnection();
		$select = new SelectRequisitosDePassword($dbAdapter);
		$rs = $select->execute()->toArray();
		$requisitos = array(
			'longitud_minina' => '0',
			'tiene_mayusculas' => false,
			'tiene_minusculas' => false,
			'tiene_numeros'    => false,
			'tiene_caracteres_especiales' => false	
		);
		
		if(count($rs) == 1){
			$requisitos = array_merge(
				$requisitos,
				current($rs)
			);
		}
		return $requisitos;
	}
}
