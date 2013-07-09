<?php

namespace Org\Parte\Service\Get;
use EnterpriseSolutions\Db\Dao\Get as GetDao;
class Dao extends GetDao
{
	public function _consultarDs()
	{
		$record = current($this->_select->execute()->toArray());
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
						$documento[$key] = $value;
					}
					return $documento;
				},
				$documentos);
		$record['documentos'] = $documentos;
		return $record;
	} 
}