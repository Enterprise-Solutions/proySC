<?php

namespace EnterpriseSolutions\Db;
use EnterpriseSolutions\Db\Select;
use EnterpriseSolutions\Db\Paginator;
use EnterpriseSolutions\Db\Dao\Dto;

class Dao {
	public $_select;
	public $_paginator;
	public $_parametrosDePaginacion = 'p';
	public function __construct(Select $select,Paginator $paginator = null)
	{
	    $this->_select = $select;
	    $this->_setPaginator($paginator);	
	}
	
	public function _setPaginator($paginator = null)
	{
		if(!$this->_paginator){
			$paginator = new Paginator($this->_select);
		}
		$this->_paginator = $paginator;
	}
	
	public function find(Dto $dto)
	{     
		return $this->_aplicarBusqueda($dto)
		     ->_aplicarOrdenamiento($dto)
		     ->_aplicarPaginacion($dto)
		     ->_consultarDs();		     
	}
	
	public function _aplicarBusqueda(Dto $dto)
	{
		$this->_select->addSearch($dto->getParametrosDeBusqueda());
		return $this;
	}
	
	public function _aplicarOrdenamiento(Dto $dto)
	{
		$this->_select->addOrder($dto->getParametrosDeOrdenamiento());
		return $this;
	}
	
	public function _aplicarPaginacion(Dto $dto)
	{
		$this->_paginator->setOffset($dto->getOffset());
		$this->_paginator->setCantidadPorPagina($dto->getCantidadPorPagina());
		return $this;
	}
	
	public function _consultarDs()
	{
		return array(
				'records'    => $this->_paginator->execute(),
				'numResults' => $this->_paginator->getNumResults()
		);
	}
}