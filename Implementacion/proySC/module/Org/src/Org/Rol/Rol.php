<?php

namespace Org\Rol;
use Doctrine\ORM\Mapping as Orm;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_rol")
 */
class Rol
{
	/**
	 * @Orm\Column(name="nombre")
	 */
	public $nombre;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_rol_codigo")
	 */
	public $codigo;
	
	public function getCodigo()
	{
		return trim($this->codigo);
	}
}