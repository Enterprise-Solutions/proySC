<?php

namespace Adm\Usuario\Repository;
use EnterpriseSolutions\Db\Select;

class SelectRequisitosDePassword extends Select
{
	public function _init()
	{
		$this->_select->from(array('acc' => 'adm_credenciales_config'))
			 ->limit(1);
	}
}