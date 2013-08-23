<?php

namespace Org\Parte;

use Org\Parte\Repository\SelectDeNacionalidad;

use Zend\Db\Adapter\Adapter;

use Doctrine\ORM\EntityManager;

class Repository
{
	public $_em;
	public $_adapter;
	public function __construct(EntityManager $em,Adapter $adapter = null)
	{
		$this->_em = $em;
		$this->_adapter = $adapter;
	}
	
	/**
	 * @param integer $id
	 * @return Org\Parte\Parte
	 */
	public function get($id)
	{
		$parte =  $this->_em
		            ->getRepository('Org\Parte\Parte')
					->find($id);
		$parte->setRepository($this);
		return $parte;
	}
	
	public function find($ids)
	{
		$partes = $this->_em->getRepository('Org\Parte\Parte')->findBy(array('id' => $ids));
		$self = $this;
		return array_map(
			function($parte){
				$parte->setRepository($self);
				return $parte;
			},
			$partes
		);
		//return $partes;
	}
	
	public function findNacionalidadDeDirPaisId($dirPaisId)
	{
		$select = new SelectDeNacionalidad($this->_adapter);
		$select->addSearchByDirPaisId($dirPaisId);
		$rs = $select->execute()->toArray();
		if(count($rs) == 1){
			return $rs[0]['nacionalidad'];
		}
		return false;
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