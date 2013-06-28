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
		return $this->_em->getRepository('Org\Rol\Rol')->findOneBy(array('codigo' => $orgRolCodigo));
	}
	
	public function findRolDeParte($orgRolCodigo,$orgParteId = null)
	{
		if(!$orgParteId){
			return false;
		}
		$rolDeParte = $this->_em
						   ->getRepository('Org\Rol\RolDeParte')
						   ->findOneBy(array('orgRolCodigo' => $orgRolCodigo,'orgParteId' => $orgParteId));
		return $rolDeParte;
	}
	
	public function persistir($rolDeParte)
	{
		$this->_em->persist($rolDeParte);
	}
}