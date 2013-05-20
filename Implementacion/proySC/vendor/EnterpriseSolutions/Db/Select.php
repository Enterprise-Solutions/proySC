<?php

namespace EnterpriseSolutions\Db;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select as zdb_select;
use Zend\Db\ResultSet\ResultSet;


class Select {
	protected $_sql;
	protected $_select;
	protected $_adapter;
	
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
}
