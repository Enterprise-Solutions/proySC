<?php

namespace Org\Contacto;
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
	
	/**
	 * @param Org\Contacto\TipoDeContacto $codigo
	 * @return object
	 */
	public function getTipoDeContacto($codigo)
	{
		$tipoDeContacto = $this->_em->getRepository('Org\Contacto\TipoDeContacto')->find($codigo);
		return $tipoDeContacto;
	}
	
	public function findContactosDeParte(Parte $parte)
	{
		return $this->findContactosByOrgParteId($parte->getId());
	}
	
	public function findContactosByOrgParteId($orgParteId)
	{
		$documentos = $this->_em
		->getRepository('Org\Contacto\Contacto')
		->findBy(array('orgParteId' => $orgParteId));
		return $documentos;
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