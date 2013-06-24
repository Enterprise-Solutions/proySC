<?php

namespace EnterpriseSolutions\Db;
use EnterpriseSolutions\Db\Select;
use Zend\Paginator\Paginator as ZFPaginator;
//use Zend\Paginator\Adapter\DbSelect as Adapter;
use EnterpriseSolutions\Db\Paginator\Adapter;

class Paginator 
{
	public $_offset = 0;
	public $_cantidadPorPagina = 10;
	public $_cantidadFijaPorPagina = null;
	public $_numResults = 0;
	
	public $_select;
	public $_adapter;
	public $_zendPaginator;
	public function __construct(Select $select,Adapter $adapter = null)
	{
        $this->_select = $select;
        $this->_setAdapter($adapter);
        $this->_zendPaginator = new ZFPaginator($this->_adapter);
	}
	
	public function _setAdapter(Adapter $adapter = null)
	{
		if(!$adapter){
			$this->_adapter = new Adapter($this->_select->_select,$this->_select->_adapter);
		}else{
			$this->_adapter = $adapter;
		}
	}
	
	public function setOffset($offset = null)
	{
		if(!$offset){
			return;
		}
		$this->_offset = $offset;
	}
	
	public function setCantidadPorPagina($cantidadPorPagina = null)
	{
		if(!$cantidadPorPagina){
			return;
		}
		$this->_cantidadPorPagina = $cantidadPorPagina;
	}
	
	public function fijarCantidadPorPagina($cantidadPorPagina)
	{
		$this->_cantidadFijaPorPagina = $cantidadPorPagina;
	}
	
	public function execute()
	{
		$cantidadPorPagina = $this->_cantidadFijaPorPagina?$this->_cantidadFijaPorPagina:$this->_cantidadPorPagina;
		if($cantidadPorPagina == 'all'){
			$rs = $this->_select->execute();
			$this->_numResults = $rs->count();
		}else{
			$pageNumber = floor($this->_offset/$this->_cantidadPorPagina) +1;
			$rs = $this->_zendPaginator
			           ->setItemCountPerPage($cantidadPorPagina)
			           ->setCurrentPageNumber($pageNumber)
			           ->getCurrentItems();
			$this->_numResults = $this->_zendPaginator->getTotalItemCount();
		}
		return $rs;
	}
	
	public function getNumResults()
	{
		return $this->_numResults;
	}
}