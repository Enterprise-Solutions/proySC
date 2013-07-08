<?php

namespace Org\Documento;
use Org\Parte\Parte;

use Doctrine\ORM\Mapping as Orm;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_documento_tipo")
 */
class TipoDeDocumento
{
	/**
	 * @Orm\Column(name="nombre")
	 */
	public $nombre;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_documento_tipo_codigo")
	 */
	public $codigo;
	
	public function getCodigo()
	{
		return trim($this->codigo);
	}
	
}