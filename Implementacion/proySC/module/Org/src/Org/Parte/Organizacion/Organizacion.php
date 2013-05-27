<?php

namespace Org\Parte\Organizacion;

use Org\Parte\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;

/**
 * @author pislas
 * @Orm\Entity
 */
class Organizacion extends Parte
{
	protected $codigo = 'org';
		
	/**
	 * @Orm\Column(name="nombre_organizacion")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Options({"label": "Nombre"})
	 */
	public $nombre; 
}