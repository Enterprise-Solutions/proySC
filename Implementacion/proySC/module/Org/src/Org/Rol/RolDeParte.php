<?php

namespace Org\Rol;
use Org\Parte\Parte;

use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_parte_rol")
 */
class RolDeParte
{
	/**
	 * @var unknown_type
	 * @Orm\Id
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 * @Orm\Column(name="org_parte_rol_id")
	 */
	protected $id;
	
	/**
	 * @var Org\Parte\Parte
	 * 
     * @Orm\ManyToOne(targetEntity="Org\Parte\Parte")
     * @Orm\JoinColumn(name="org_parte_id", referencedColumnName="org_parte_id")
     **/
	protected $parte;
	
	/**
	 * @var Org\Rol\Rol
	 * @Orm\ManyToOne(targetEntity="Org\Rol\Rol")
     * @Orm\JoinColumn(name="org_rol_codigo", referencedColumnName="org_rol_codigo")
	 */
	protected $rol;
	
	public function setParte(Parte $parte)
	{
		if(!$this->id){
			$this->_parteSeteada($parte);
		}
	}
	
	public function setRol(Rol $rol)
	{
		if(!$this->id){
			$this->_rolSeteado($rol);
		}
	}
	
	public function _parteSeteada(Parte $parte)
	{
		$this->parte = $parte;
	}
	
	public function _rolSeteado(Rol $rol)
	{
		$this->rol = $rol;
	}
	
	public function toArray()
	{
		return array('org_parte_rol_id' => $this->id,'org_parte_id' => $this->parte->getId(),'org_rol' => $this->rol->getCodigo());
	}
}