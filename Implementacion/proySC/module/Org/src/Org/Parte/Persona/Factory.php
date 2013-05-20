<?php

namespace Org\Parte\Persona;

use Org\Parte\Persona\Persona;
use Org\Parte\ParteTipo;

use Doctrine\ORM\EntityManager;

class Factory
{
	protected $_em;
	protected $_tiposDePartes = array();
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	/**
	 * @return \Org\Parte\Persona\Persona
	 */
	public function crear()
	{
		$tipoDeParte = $this->_findTipoDeParte('per');
		$parte = new Persona();
		$parte->setTipo($tipoDeParte);
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