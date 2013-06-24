<?php

namespace Org\Parte;
use Doctrine\ORM\EntityManager;
use Org\Parte\Persona\Persona;
use Org\Parte\Organizacion\Organizacion;

class Factory
{
	protected $_em;
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	/**
	 * @param unknown_type $orgParteTipoCodigo
	 * @return \Org\Parte\Parte
	 */
	public function crear($orgParteTipoCodigo)
	{
		switch ($orgParteTipoCodigo){
			case 'per':
				return $this->crearPersona();
		        break;
			case 'org':
				return $this->crearOrganizacion();
				break;
		}
	}
	
	/**
	 * @return \Org\Parte\Persona\Persona
	 */
	public function crearPersona()
	{
		$parteTipo = $this->_findTipoDeParte('per');
		$parte = new Persona();
		$parte->setParteTipo($parteTipo);
		return $parte;
	}
	
	/**
	 * @return \Org\Parte\Organizacion\Organizacion
	 */
	public function crearOrganizacion()
	{
		$parteTipo = $this->_findTipoDeParte('org');
		$parte = new Organizacion();
		$parte->setParteTipo($parteTipo);
		return $parte;
	}
	

	/**
	 * @param string $codigo
	 * @return ParteTipo
	 */
	public function _findTipoDeParte($codigo)
	{
		$tipoDeParte = $this->_em->getRepository('Org\Parte\ParteTipo')->findOneBy(array('codigo' => $codigo));
		return $tipoDeParte;
	}
}