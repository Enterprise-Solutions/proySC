<?php

namespace Org\Parte\Listado;
use EnterpriseSolutions\Db\Select as DbSelect;
class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('op' => 'org_parte'))
			 ->join(
			 	array('opt' => 'org_parte_tipo'),
			 	'op.org_parte_tipo_codigo = opt.org_parte_tipo_codigo',
			 	array('org_parte_tipo_nombre' => 'nombre'));
	}
	
	public function addSearchByOrgParteTipoCodigo($orgParteTipoCodigo)
	{
		$this->_select->where("op.org_parte_tipo_codigo = '$orgParteTipoCodigo'");
	}
}