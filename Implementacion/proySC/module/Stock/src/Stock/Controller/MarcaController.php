<?php

namespace Stock\Controller;

use Zend\View\Model\JsonModel;
use Zend\Json;
use Zend\Json\Decoder;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Stock\Marca\Listado\Select;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;

class MarcaController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao, array(), $overwritedParams);
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	public function getAction()
	{
		$allGetValues = $this->params()->fromQuery();
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$sql = new Sql($adapter);
		$select = $sql->select()
					->from(array('m'=>'cont_moneda'))
					//->columns(array('nombre'))
					->where(array('cont_moneda_id' => $allGetValues[id]));
		
		
		$selectString = $sql->getSqlStringForSqlObject($select);
		$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		
		return new JsonModel($results);
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	public function crearAction()
	{
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		
		$sql = new Sql($adapter);
		$insert = $sql->insert()
			->into('stock_marca')
			//->columns(array('nombre'))
			->values((array)$jsonData->post);
		
	
		$result = $sql->prepareStatementForSqlObject($insert)->execute()->getGeneratedValue();
		
		
		return new JsonModel(array('id'=> $adapter->getDriver()->getLastGeneratedValue('stock_marca_stock_marca_id_seq')));
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	public function editarAction()
	{
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		$id = $jsonData->id;
	
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
	
		$sql = new Sql($adapter);
		$update = $sql->update()
			->table('stock_marca')
			->set((array)$jsonData->put)
			//->columns(array('nombre'))
			->where(array('stock_marca_id'=>$id));
		
		
		$result = $sql->prepareStatementForSqlObject($update)->execute();
	
		return new JsonModel(array('id'=> $id));
	}
	
	public function borrarAction()
	{
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
	
		$id = $jsonData->id;
	
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
	
		$sql = new Sql($adapter);
		$delete = $sql->delete()
		->from('stock_marca')
		//->set((array)$jsonData->put)
		//->columns(array('nombre'))
		->where(array('stock_marca_id'=>$id));
	
		$result = $sql->prepareStatementForSqlObject($delete)->execute();
	
		return new JsonModel(array('id'=> $id));
	}
	
}