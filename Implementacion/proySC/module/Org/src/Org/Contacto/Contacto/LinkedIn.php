<?php

namespace Org\Contacto\Contacto;

use Org\Contacto\Contacto;
use Doctrine\ORM\Mapping as Orm;
/**
 * @author pislas
 * @Orm\Entity
 */
class LinkedIn extends Contacto
{
	protected $codigo = 'linkedIn';
	
}