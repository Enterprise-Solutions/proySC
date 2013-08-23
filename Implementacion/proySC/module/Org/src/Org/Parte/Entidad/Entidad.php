<?php

namespace Org\Parte\Entidad;
use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;

class Entidad
{
	/**
	 * @var Parte
	 * @Orm\OneToOne(targetEntity="Org\Parte\Parte")
	 * @Orm\JoinColumn(name="org_parte_id",referencedColumnName="org_parte_id")
	 */
	protected $parte;
	
	/**
	 * @Orm\Column(name="org_parte_id")
	 */
	protected $org_parte_id;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setParte(Parte $parte)
	{
		if($this->id){
			return $this;
		}
	
		$this->parte = $parte;
		return $this;
	}
	
	public function crear($datos)
	{
		$this->_hydrado($datos);
	}
	
	public function editar($datos)
	{
		$this->_hydrado($datos);
	}
	
	public function _hydrado($datos)
	{
		$hydrator = new Hydrator();
		return $hydrator->hydrate($datos, $this);
	}
}