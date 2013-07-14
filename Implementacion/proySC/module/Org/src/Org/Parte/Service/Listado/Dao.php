<?php

namespace Org\Parte\Service\Listado;

use EnterpriseSolutions\Db\Dao as EsDao;

class Dao extends EsDao
{
	public function _consultarDs()
	{
		$records = array_map(
			function($record){
				if(!$record['documentos']){
					$record['documentos'] = array();
					return $record;
				}
				$documentos = explode(';', $record['documentos']);
				$documentos = array_map(
					function($documentoString){
						/*return array_map(
							function($keyValueToken){
								$tokens = explode(':', $keyValueToken);
								$keyValueArray =  array($tokens[0] => $tokens[1]);
								return $keyValueArray;
							},
							explode(",", $documento));*/
						$keyValueTokens = explode(",",$documentoString);
						$documento = array();
						foreach($keyValueTokens as $token){
							//$tokens = explode(':', $keyValueToken);
							list($key,$value) = explode(':', $token);
							$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
						}
						return $documento; 
					}, 
				    $documentos);
				$record['documentos'] = $documentos;
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