<?php

namespace Org\Parte\Repository;

use EnterpriseSolutions\Db\Select;

class SelectDeNacionalidad extends Select
{
	public function _init()
	{
		$this->_select
			 ->from('dir_pais')
			 ->columns(array('nacionalidad'));
	}
	
	public function addSearchByDirPaisId($dirPaisId)
	{
		$this->_select
			 ->where("dir_pais_id = $dirPaisId");
	}
}