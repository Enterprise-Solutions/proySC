<?php

namespace Fact\Ingreso;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="fact_rol_ingreso")
 */
class Proveedor
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $fact_rol_ingreso_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $org_parte_rol_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $fact_ingreso_id;
	
	public function addDocumento($documento_id)
	{
		$this->fact_ingreso_id = $documento_id;
	}
	
	public function addRol($rol_id)
	{
		$this->org_parte_rol_id = $rol_id;
	}
}