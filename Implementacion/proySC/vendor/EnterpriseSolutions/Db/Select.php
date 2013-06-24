<?php

namespace EnterpriseSolutions\Db;
use Zend\Filter\Word\UnderscoreToCamelCase;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select as zdb_select;
use Zend\Db\ResultSet\ResultSet;


class Select {
	public $_sql;
	public $_select;
	public $_adapter;
	
	/**
	 * @param Adapter $adapter
	 */
	public function __construct(Adapter $adapter)
	{
		$this->_adapter = $adapter;
		$this->_sql = new Sql($adapter);
		$this->_select = $this->_sql->select();
		$this->_init();
	}
	
	public function _init()
	{
		
	}
	

	/**
	 * @return Zend\Db\ResultSet\ResultSet
	 */
	public function execute()
	{
		$selectString = $this->_sql->getSqlStringForSqlObject($this->_select);
		$results = $this->_adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		return $results;
	}
	
	public function addSearch($searchParams)
	{
		//$filter = new Zend_Filter_Word_UnderscoreToCamelCase();
		$filter = new UnderscoreToCamelCase();
		foreach($searchParams as $name => $value){
			$searchFunctionName = 'addSearchBy'. $filter->filter($name);
			if(method_exists($this,$searchFunctionName)){
				$this->{$searchFunctionName}($value);
			}
		}
	}
	
	public function addOrder($orderParams)
	{
		$this->_select->reset('order');
		$default = array(
				'campo' => null,
				'dir'   => zdb_select::ORDER_DESCENDING
		);
		foreach($orderParams as $orden){
			$orden = array_merge($default,$orden);
			if($orden['campo']){
				$campo = $orden['campo'];
				$dir   = $orden['dir'];
				$this->_select->order(array($campo => $dir));
			}
		}
	}
}
