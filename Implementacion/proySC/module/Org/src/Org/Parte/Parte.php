<?php

namespace Org\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;
use Org\Parte\ParteTipo;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_parte")
 * @Orm\InheritanceType("SINGLE_TABLE")
 * @Orm\DiscriminatorColumn(name="org_parte_tipo_codigo", type="string")
 * @Orm\DiscriminatorMap({"per" = "Org\Parte\Persona\Persona","org" = "Org\Parte\Organizacion\Organizacion"})
 */
class Parte
{
	protected $codigo;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_parte_id")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 * @Zf\Exclude()
	 */
	protected $id;
	
	/**
	 * @Orm\OneToOne(targetEntity="Org\Parte\ParteTipo")
	 * @Orm\JoinColumn(name="org_parte_tipo_codigo",referencedColumnName="codigo")
	 */
	protected $_tipo;
	
	/**
	 * @param ParteTipo $parteTipo
	 */
	public function setParteTipo($parteTipo)
	{
		if($this->_tipo){
			return;
		}
		
		if($parteTipo->getCodigo() == $this->codigo){
			$this->_tipo = $parteTipo;
		}
	}
	
	/**
	 * @return \Org\Parte\ParteTipo
	 */
	public function getParteTipo()
	{
		return $this->_tipo;
	}
	
	public function getId()
	{
		return $this->id;
	}
}