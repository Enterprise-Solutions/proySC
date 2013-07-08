<?php

namespace Org\Documento\Documento;

use Org\Documento\Documento;
use Doctrine\ORM\Mapping as Orm;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity
 */
class Ruc extends Documento
{
	protected $codigo = 'ruc';
	
	public function _esValidoParaParte(Parte $parte)
	{
		$orgParteTipoCodigo = $parte->getParteTipo()->getCodigo();
		if(in_array($orgParteTipoCodigo, array('per','org'))){
			return true;
		}
		return false;
	}
}