<?php

namespace Org\Documento\Documento;

use Doctrine\ORM\Mapping as Orm;
use Org\Documento\Documento;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity
 */
class Cedula extends Documento
{
	protected $codigo = 'cedula';
	
	public function _esValidoParaParte(Parte $parte)
	{
		if($parte->getParteTipo()->getCodigo() == 'per'){
			return true;
		}
		return false;
	}
}