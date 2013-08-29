<?php

namespace EnterpriseSolutions\Controller\SimpleController;
use EnterpriseSolutions\Db\Select as EsSelect;

class SelectDeListado extends EsSelect
{
	public $_tableName;
	public function __construct($adapter,$tableName)
	{
		$this->_tableName = $tableName;
		parent::__construct($adapter);
	}
	
	public function _init()
	{
		$this->_select
			 ->from($this->_tableName);
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select->where("nombre ~* '$nombre'");
	}
}