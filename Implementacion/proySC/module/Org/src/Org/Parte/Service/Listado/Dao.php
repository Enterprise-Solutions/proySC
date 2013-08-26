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
					$record['documentos'] = '';
					//return $record;
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
							//$documento[$key] = ($key == 'org_documento_id')?(integer)$value:$value;
							$documento[$key] = (in_array($key, array('org_documento_id','dir_pais_id','preferencia')))?(integer)$value:$value;
						}
						return $documento; 
					}, 
				    $documentos);
				$record['documentos'] = $documentos;

				if(!$record['contactos']){
					$record['contactos'] = '';
					//return $record;
				}
				$contactos = explode(';', $record['contactos']);
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
					$record['Direcciones'] = '';
					return $record;
				}
				$contactos = explode(';', $record['Direcciones']);
				$contactos = array_map(
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
						$contactos);
				$record['Direcciones'] = $contactos;
				
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