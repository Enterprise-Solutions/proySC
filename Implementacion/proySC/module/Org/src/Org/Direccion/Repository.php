<?php

namespace Org\Direccion;
use Org\Parte\Parte;

use Doctrine\ORM\EntityManager;

class Repository
{
	/**
	 * @var EntityManager
	 */
	public $_em;
	
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}
	
	public function findDireccionesDeParte(Parte $parte)
	{
		return $this->findDireccionesByOrgParteId($parte->getId());
	}
	
	public function findDireccionesByOrgParteId($orgParteId)
	{
		$direcciones = $this->_em
		->getRepository('Org\Direccion\Direccion')
		->findBy(array('org_parte_id' => $orgParteId));
		return $direcciones;
	}
	
	public function persistir($entidades)
	{
		$em = $this->_em;
		return array_map(
				function($entidad) use ($em){
					$em->persist($entidad);
					return $entidad;
				}, $entidades
		);
		//return array_map($this->_em->persist($entidad);
	}
	
	public function borrar($entidades)
	{
		$em = $this->_em;
		return array_map(
				function($entidad) use ($em){
					$em->remove($entidad);
					return $entidad;
				}, $entidades
		);
	}
}