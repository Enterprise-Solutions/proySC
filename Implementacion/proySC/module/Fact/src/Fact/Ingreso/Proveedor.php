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
	 * @ORM\ManyToOne(targetEntity="Org\Rol\RolDeParte")
	 * @ORM\JoinColumn(name="org_parte_rol_id", referencedColumnName="org_parte_rol_id")
	 */
	protected $proveedor;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Fact\Ingreso\Ingreso")
	 * @ORM\JoinColumn(name="fact_ingreso_id", referencedColumnName="fact_ingreso_id")
	 */
	protected $ingreso;
	
	public function setIngreso($ingreso)
	{
	    $this->ingreso = $ingreso;
	}
	
	public function setProveedor($proveedor)
	{
	    $this->proveedor = $proveedor;
	}
}