<?php

namespace Org\Contacto;
use Doctrine\ORM\Mapping as Orm;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_contacto_tipo")
 */
class TipoDeContacto
{
	/**
	 * @Orm\Column(name="nombre")
	 */
	public $nombre;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_contacto_tipo_codigo")
	 */
	public $codigo;
	
	public function getCodigo()
	{
		return trim($this->codigo);
	}
}