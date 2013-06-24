<?php

namespace Org\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;
use Org\Parte\ParteTipo;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use \Exception;

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
	 * 
	 */
	protected $id;
	
	/**
	 * @Orm\OneToOne(targetEntity="Org\Parte\ParteTipo")
	 * @Orm\JoinColumn(name="org_parte_tipo_codigo",referencedColumnName="org_parte_tipo_codigo")
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
	
	public function crear($datos)
	{
		$if = $this->_getInputFilter('creacion', $datos);
		if(!$if->isValid()){
			throw new Exception("Error de creacion");
		}
		$this->_creado(array_filter($if->getValues()));
	}
	
	public function editar($datos)
	{
		$if = $this->_getInputFilter('edicion', $datos);
		if(!$if->isValid()){
			throw new Exception("Error de edicion");
		}
		$this->_editado(array_filter($if->getValues()));
	}
	
	public function _creado($datos)
	{
		$this->_hydrado($datos);
	}
	
	public function _editado($datos)
	{
		$this->_hydrado($datos);
	}
	
	/**
	 * @param creacion|update $operacion
	 * @param $datos
	 * @return InputFilter
	 */
	public function _getInputFilter($operacion,$datos)
	{
					
	}
	
	public function _hydrado($datos)
	{
		$hydrator = new Hydrator();
		return $hydrator->hydrate($datos, $this);
	}
	
	public function toArray()
	{
		$hydrator = new Hydrator();
		return array_merge($hydrator->extract($this),array('id' => $this->id,'org_parte_tipo_codigo' => $this->codigo));
	}
}