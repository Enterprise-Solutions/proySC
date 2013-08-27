<?php

namespace Org\Parte\Service\Get;
use EnterpriseSolutions\Db\Dao\Get as GetDao;
class Dao extends GetDao
{
	public function _consultarDs()
	{
		$record = current($this->_select->execute()->toArray());
		if(!$record['documentos']){
			$documentos = array();
			//return $record;
		}else{
			$documentos = explode(';', $record['documentos']);
		}
		
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
						//$documento[$key] = $value;
						$documento[$key] = (in_array($key, array('org_documento_id','dir_pais_id','preferencia')))?(integer)$value:$value;
					}
					return $documento;
				},
				$documentos);
		$record['documentos'] = $documentos;
		
		if(!$record['contactos']){
			//$record['contactos'] = array();
			//return $record;
			$contactos = array();
		}else{
			$contactos = explode(';', $record['contactos']);
		}
		
		$contactos = array_map(
				function($documentoString){
					$keyValueTokens = explode(",",$documentoString);
					$documento = array();
					foreach($keyValueTokens as $token){
						//$tokens = explode(':', $keyValueToken);
						list($key,$value) = explode(':', $token);
						//$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
						$documento[$key] = (in_array($key, array('org_contacto_id')))?(integer)$value:$value;
					}
					return $documento;
				},
				$contactos);
		$record['contactos'] = $contactos;
		
		if(!$record['Direcciones']){
			//$record['Direcciones'] = array();
			//return $record;
			$direcciones = array();
		}else{
			$direcciones = explode(';', $record['Direcciones']);
		}
		//$contactos = explode(';', $record['Direcciones']);
		$direcciones = array_map(
				function($documentoString){
					$keyValueTokens = explode(",",$documentoString);
					$documento = array();
					foreach($keyValueTokens as $token){
						//$tokens = explode(':', $keyValueToken);
						list($key,$value) = explode(':', $token);
						//$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
						$documento[$key] = (in_array($key, array('dir_direccion_id','dir_barrio_id')))?(integer)$value:$value;
					}
					return $documento;
				},
				$direcciones);
		$record['Direcciones'] = $direcciones;
		
		return $record;
	} 
}