<?php

namespace Org\Parte\Service;

use Doctrine\ORM\EntityManager;
use \Exception;

class Transaccional
{
	public $_service;
	public $_em;
	public function __construct(EntityManager $em,$service)
	{
		$this->_em = $em;
		$this->_service = $service;			
	}
	
	public function ejecutar($datos)
	{
		$this->_em->getConnection()->beginTransaction(); // suspend auto-commit
		try {
			$resultado = $this->_service->ejecutar($datos);
			$this->_em->flush();
			$this->_em->getConnection()->commit();
		} catch (Exception $e) {
			$this->_em->getConnection()->rollback();
			$this->_em->close();
			throw $e;
		
		}
		return $resultado;	
	}
	
	public function getRespuesta()
	{
		return $this->_service->getRespuesta();
	}
}