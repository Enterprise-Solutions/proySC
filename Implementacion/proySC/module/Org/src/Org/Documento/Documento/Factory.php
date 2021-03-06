<?php

namespace Org\Documento\Documento;

use Org\Documento\Repository;
use Org\Documento\Documento;

class Factory
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	/**
	 * @param unknown_type $codigoTipoDeDocumento
	 * @return \Org\Documento\Documento
	 */
	public function crearDocumento($codigoTipoDeDocumento)
	{
		$tipoDeDocumento = $this->_repository
							    ->getTipoDeDocumento($codigoTipoDeDocumento);
		if(!$tipoDeDocumento){
			//lanzar excepcion	
		}
		
		switch ($codigoTipoDeDocumento){
			case 'cedula':
				$documento = new Cedula($tipoDeDocumento);
				break;
			case 'ruc':
				$documento = new Ruc($tipoDeDocumento);
				break;
			case 'pasaporte':
				$documento = new Pasaporte($tipoDeDocumento);
				break;
			case 'carnet':
				$documento = new Carnet($tipoDeDocumento);
				break;
		}
		//
		$documento->dir_pais_id = 1;
		$documento->preferencia = 1;
		return $documento;	
	}

}