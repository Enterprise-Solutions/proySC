<?php

namespace Org\Direccion;
use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="dir_direccion")
 */
class Direccion
{
	/**
	 * @Orm\Id
	 * @Orm\Column(name="dir_direccion_id")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 */
	protected $id;
	
	/**
	 * @Orm\Column(name="calle")
	 */
	public $direccion;
	
	/**
	 * @Orm\Column(name="dir_barrio_id")
	 */
	public $dir_barrio_id;
	
	/**
	 * @Orm\Column(name="dir_direccion_tipo_id")
	 */
	public $dir_direccion_tipo_id;
	
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
	
	public function __construct($dirDireccionTipoId = null)
	{
		if($dirDireccionTipoId){
			$this->dir_direccion_tipo_id = $dirDireccionTipoId;
		}
	}
	
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
	
	public function toArray()
	{
		return array(
				'dir_direccion_id' => $this->id,
				'direccion'            => $this->direccion,
				'dir_barrio_id'         => $this->dir_barrio_id, 
				'dir_direccion_tipo_id' => $this->dir_direccion_tipo_id
		);
	}
}