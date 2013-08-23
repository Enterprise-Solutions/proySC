<?php

namespace Application\Authentication\Db;
use EnterpriseSolutions\Db\Select as DbSelect;

class DefaultAuthParamsSelect extends DbSelect
{
	public function _init()
	{
		$this->_select->from('adm_parametro')
		     ->columns(array('param_cod','valor'))
		     ->where("param_cod in ('defaultDirPais','defaultPerDocTipo')");
	}
}
