<?php

namespace Org\Parte;

use Doctrine\ORM\EntityManager;

class Repository
{
	public $_em;
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	/**
	 * @param integer $id
	 * @return Org\Parte\Parte
	 */
	public function get($id)
	{
		return $this->_em
		            ->getRepository('Org\Parte\Parte')
					->find($id);
	}
	
	public function find($ids)
	{
		$partes = $this->_em->getRepository('Org\Parte\Parte')->findBy(array('id' => $ids));
		return $partes;
	}
	
	public function persistir($entidad)
	{
		$this->_em->persist($entidad);
	}
	
	public function borrar($entidad)
	{
		$this->_em->remove($entidad);
	}
}