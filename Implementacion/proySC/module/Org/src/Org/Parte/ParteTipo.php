<?php

namespace Org\Parte;
use Doctrine\ORM\Mapping as Orm;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_parte_tipo")
 */
class ParteTipo
{
	/**
	 * @Orm\Column(name="nombre")
	 */
	public $nombre;
	
    /**
     * @Orm\Id
     * @Orm\Column(name="org_parte_tipo_codigo")
     */
    public $codigo;

    public function getCodigo()
    {
    	return trim($this->codigo);
    }
}