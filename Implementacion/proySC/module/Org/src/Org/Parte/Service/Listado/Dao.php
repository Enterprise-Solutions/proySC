<?php

namespace Org\Parte\Service\Listado;

use EnterpriseSolutions\Db\Dao as EsDao;

class Dao extends EsDao
{
	public function _consultarDs()
	{
		$records = array_map(
			function($record){
				$record['documentos'] = explode(',', $record['documentos']);
				return $record;		
			}, 
			$this->_paginator->execute()->toArray()
		);
		return array(
				'records'    => $records,
				'numResults' => $this->_paginator->getNumResults()
		);
	}
}