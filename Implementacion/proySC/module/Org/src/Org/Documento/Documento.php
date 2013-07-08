<?php

namespace Org\Documento;
use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use Org\Documento\TipoDeDocumento;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_documento")
 * @Orm\InheritanceType("SINGLE_TABLE")
 * @Orm\DiscriminatorColumn(name="org_documento_tipo_codigo", type="string")
 * @Orm\DiscriminatorMap({"cedula" = "Org\Documento\Documento\Cedula","ruc" = "Org\Documento\Documento\Ruc"}) 
 */
class Documento
{
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_documento_id")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 */
	protected $id;
	
	/**
	 * 
	 */
	protected $codigo;
	
	/**
	 * @Orm\Column(name="valor")
	 */
	public $valor;
	
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
	 * @var TipoDeDocumento
	 * @Orm\OneToOne(targetEntity="Org\Documento\TipoDeDocumento")
	 * @Orm\JoinColumn(name="org_documento_tipo_codigo",referencedColumnName="org_documento_tipo_codigo")
	 */
	protected $tipoDeDocumento;
	
	public function __construct(TipoDeDocumento $tipoDeDocumento = null)
	{
		$this->setTipo($tipoDeDocumento);
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setTipo(TipoDeDocumento $tipoDeDocumento)
	{
		if($tipoDeDocumento && $tipoDeDocumento->getCodigo() == $this->codigo){
			$this->tipoDeDocumento = $tipoDeDocumento;
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
		
		if(!$this->_esValidoParaParte($parte)){
			//lanzar exception
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
			'org_documento_id' => $this->id,
			'valor'            => $this->valor,
			'org_documento_tipo_codigo' => $this->codigo	
		);
	}
	
}