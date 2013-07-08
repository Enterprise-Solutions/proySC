<?php

namespace Org\Documento;
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
	 * @param string $codigo
	 * @return Org\Documento\TipoDeDocumento
	 */
	public function getTipoDeDocumento($codigo)
	{
		$tipoDeDocumento = $this->_em->getRepository('Org\Documento\TipoDeDocumento')->find($codigo);
		return $tipoDeDocumento;
	}
	
	public function findDocumentosDeParte(Parte $parte)
	{
		return $this->findDocumentosByOrgParteId($parte->getId());
	}
	
	public function findDocumentosByOrgParteId($orgParteId)
	{
		$documentos = $this->_em
						   ->getRepository('Org\Documento\Documento')
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