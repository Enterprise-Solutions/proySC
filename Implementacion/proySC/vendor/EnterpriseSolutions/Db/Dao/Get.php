<?php

namespace EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Exceptions\Thrower;

use EnterpriseSolutions\Db\Select;
use EnterpriseSolutions\Db\Dao\Dto;
use EnterpriseSolutions\Exceptions;

class Get
{
	public $_select;
	public function __construct(Select $select)
	{
		$this->_select = $select;
	}
	
	public function get(Dto $dto)
	{
		if(!$dto->getId()){
			Thrower::throwValidationException("No se recibio el parametro id del recurso a consultar!");	
		}
		return $this->_aplicarBusqueda($dto)
					->_consultarDs();
	}
	
	public function _aplicarBusqueda(Dto $dto)
	{
		$this->_select->addSearch($dto->getParametrosDeGet());
		return $this;
	}
	
	public function _consultarDs()
	{
		$rs = $this->_select->execute()->toArray();
		if(count($rs) == 1){
			return current($rs);
		}
		return array();
		//return current($this->_select->execute()->toArray());
	}
}