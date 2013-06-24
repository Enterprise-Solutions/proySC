<?php

namespace EnterpriseSolutions\Db\Paginator;
use Zend\Paginator\Adapter\DbSelect as ZFAdapter;
use Zend\Db\Sql\Select;
class Adapter extends ZFAdapter
{
	/**
	 * Returns the total number of rows in the result set.
	 *
	 * @return integer
	 */
	public function count()
	{
		if ($this->rowCount !== null) {
			return $this->rowCount;
		}
	
		/**
		 * If the query hasn't got 'GROUP BY' just try and use the old method
		 */
		$stateGroup = $this->select->getRawState('group');
		if( ! isset($stateGroup) || empty($stateGroup)) {
			return parent::count();
		}
	
		$select = clone $this->select;
		$select->reset(Select::LIMIT);
		$select->reset(Select::OFFSET);
	
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$result    = $statement->execute();
	
		$this->rowCount = $result->count();
	
		return $this->rowCount;
	}	
}