<?php

namespace Org\Parte\Persona;

use Doctrine\ORM\EntityManager;
use Org\Parte\Persona\Persona;

class Repositorio
{
	protected $_em;
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	/**
	 * @param unknown_type $id
	 * @return Persona
	 */
	public function findById($id)
	{
		$query = $this->_em->createQuery("SELECT p FROM Org\\Parte\\Persona\\Persona p JOIN p._tipo pt WHERE pt.codigo = 'per' and p._id = $id");
		$personas = $query->getResult();
		return current($personas);
	}
}