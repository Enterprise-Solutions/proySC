<?php

namespace Org\Contacto;
use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_contacto")
 * @Orm\InheritanceType("SINGLE_TABLE")
 * @Orm\DiscriminatorColumn(name="org_contacto_tipo_codigo", type="string")
 * @Orm\DiscriminatorMap({"celularpart" = "Org\Contacto\Contacto\CelularPart","celularlab" = "Org\Contacto\Contacto\CelularLab","email" = "Org\Contacto\Contacto\Email","telefonolab" = "Org\Contacto\Contacto\TelefonoLab","telefonopart" = "Org\Contacto\Contacto\TelefonoPart","facebook" = "Org\Contacto\Contacto\Facebook","linkedIn" = "Org\Contacto\Contacto\LinkedIn","twitter" = "Org\Contacto\Contacto\Twitter"}) 
 */
class Contacto
{
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_contacto_id")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 */
	protected $id;
	
	/**
	 *
	 */
	protected $codigo;
	
	/**
	 * @Orm\Column(name="contacto")
	 */
	public $contacto;
	
	/**
	 * @Orm\Column(name="org_parte_id")
	 */
	protected $orgParteId;
	
	/**
	 * @var Parte
	 * @Orm\OneToOne(targetEntity="Org\Parte\Parte")
	 * @Orm\JoinColumn(name="org_parte_id",referencedColumnName="org_parte_id")
	 */
	protected $parte;
	
	/**
	 * @var TipoDeContacto
	 * @Orm\OneToOne(targetEntity="Org\Contacto\TipoDeContacto")
	 * @Orm\JoinColumn(name="org_contacto_tipo_codigo",referencedColumnName="org_contacto_tipo_codigo")
	 */
	protected $tipoDeContacto;
	
	public function __construct(TipoDeContacto $tipoDeContacto = null)
	{
		$this->setTipo($tipoDeContacto);
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setTipo(TipoDeContacto $tipoDeContacto)
	{
		if($tipoDeContacto && $tipoDeContacto->getCodigo() == $this->codigo){
			$this->tipoDeContacto = $tipoDeContacto;
		}
		return $this;
	}
	
	public function getParte()
	{
		return $this->parte;
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
	
	/**
	 * @param Parte $parte
	 * @return boolean
	 */
	public function _esValidoParaParte(Parte $parte)
	{
	
	}
	
	public function toArray()
	{
		return array(
				'org_contacto_id' => $this->id,
				'contacto'            => $this->contacto,
				'org_contacto_tipo_codigo' => $this->codigo
		);
	}
}