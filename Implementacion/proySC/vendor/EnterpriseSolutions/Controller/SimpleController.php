<?php
namespace EnterpriseSolutions\Controller;
use Zend\Db\TableGateway\Feature;
use Zend\Db\TableGateway\Feature\MetadataFeature;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\Adapter\Adapter;
class SimpleController  extends BaseController
{
	public $_tableGateway;
	public $_tableName;
	public $_pkName;
	

	public function indexAction()
	{
		$rs = $this->_getTableGateway()->select();
		$rs = $rs->toArray();
		return $this->_returnAsJson(array('records' => $rs,'numResults' => count($rs)));
	}
	
	public function postAction()
	{
		$postData = $this->submitParams()->getParam('post');
		$pkName = $this->_getTablePrimaryKey();
		$this->_getTableGateway()->insert($postData);
		$seq = $this->_getPkSequenceName();
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$rs = $dbAdapter->query("select currval('$seq') as id", Adapter::QUERY_MODE_EXECUTE)->toArray();
		$lastInsertedValue = $rs[0]['id'];
		$postData[$pkName] = $lastInsertedValue;
		return $this->_returnAsJson($postData);
		/*$rowGateway = new RowGateway($pkName,$this->_tableName,$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$rowGateway->populate($postData);
		$rowGateway->save();
		return $this->_returnAsJson($rowGateway->toArray());*/
	}
	
	public function putAction()
	{
		$putData = $this->submitParams()->getParam('put');
		$pkName = $this->_getTablePrimaryKey();
		$pk = $putData[$pkName];
		$rs = $this->_getTableGateway()->select(array($pkName => $pk));
		$rowGateway = $rs->current();
		$rowGateway->populate($putData,true);
		$rowGateway->save();
		return $this->_returnAsJson($rowGateway->toArray());
	}
	
	public function deleteAction()
	{
		$deleteData = $this->submitParams()->getParam('delete');
		$ids = join(",",$deleteData);
		$pkName = $this->_getTablePrimaryKey();
		$rows = $this->_getTableGateway()->select(function($select)use($pkName,$ids){$select->where("$pkName in ($ids)");});
		$rs = array();
		foreach($rows as $row){
			$row->delete();
			$rs[] = $row->toArray();
		}
		return $this->_returnAsJson($rs);
	}
	
	/**
	 * @return TableGateway
	 */
	public function _getTableGateway()
	{
		if(!$this->_tableGateway){
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
			
			$features = new Feature\FeatureSet();
			//$features->addFeature(new MetadataFeature());
			$features->addFeature(new RowGatewayFeature($this->_getTablePrimaryKey()));
			$this->_tableGateway = new TableGateway($this->_tableName, $dbAdapter,$features);
		}
		return $this->_tableGateway;
	}
	
	public function _getTablePrimaryKey()
	{
		//$metadata = $this->_getTableGateway()->featureSet->getFeatureByClassName('Zend\Db\TableGateway\Feature\MetadataFeature');
		//$metadata = $this->_getTableGateway()->getFeatureSet()->getFeatureByClassName('Zend\Db\TableGateway\Feature\MetadataFeature');
		/*$featureSet = $this->_getTableGateway()->getFeatureSet();
		$metadata = $featureSet->getFeatureByClassName('Zend\Db\TableGateway\Feature\MetadataFeature');
		
		$metadata->postInitialize();
		$primaryKey = $metadata->sharedData['metadata']['primaryKey'];
		return $primaryKey;*/
		if(!$this->_pkName){
			$this->_pkName = $this->_tableName . "_id";
		}
		return $this->_pkName;
	}
	
	public function _getPkSequenceName()
	{
		return $this->_tableName . "_" . $this->_getTablePrimaryKey() . "_seq";
	}
}