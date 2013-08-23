<?php
namespace Org\Documento\Documento;

use Org\Documento\Documento;
use Doctrine\ORM\Mapping as Orm;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity
 */
class Carnet extends Documento
{
	protected $codigo = 'carnet';
	
	public function _esValidoParaParte(Parte $parte)
	{
		if($parte->getParteTipo()->getCodigo() == 'per'){
			return true;
		}
		return false;
	}
}