<?php

namespace Org\Rol;

use Doctrine\ORM\EntityManager;

class Repository
{
	public $_em;
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	public function getRol($orgRolCodigo)
	{
		return $this->_em->getRepository('Org\Rol\Rol')->find($orgRolCodigo);
	}
	
	public function persistir($rolDeParte)
	{
		$this->_em->persist($rolDeParte);
	}
}