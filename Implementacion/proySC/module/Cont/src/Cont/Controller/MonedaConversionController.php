<?php

namespace Cont\Controller;

use Zend\View\Model\JsonModel;
use Zend\Json;
use Zend\Json\Decoder;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Cont\MonedaConversion\Listado\Select;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;

class MonedaConversionController extends BaseController
{
	public function indexAction($overwritedParams = array())
	{
		$select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$dao = new Dao($select);
		$template = $this->_crearTemplateParaListado();
		return $template($dao, array(), $overwritedParams);
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	//TODO validar no hayan tasa de cambios repetidas  (mismo origen destino(
	public function crearAction()
	{
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		
		$sql = new Sql($adapter);
		$insert = $sql->insert()
			->into('cont_moneda_conversion')
			//->columns(array('nombre'))
			->values((array)$jsonData->post);
		
		$result = $sql->prepareStatementForSqlObject($insert)->execute()->getGeneratedValue();
		
		return new JsonModel(array('id'=> $adapter->getDriver()->getLastGeneratedValue('cont_moneda_conversion_cont_moneda_conversion_id_seq')));
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	//TODO validar no hayan tasa de cambios repetidas  (mismo origen destino(
	public function editarAction()
	{
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		$id = $jsonData->id;
	
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
	
		$sql = new Sql($adapter);
		$update = $sql->update()
			->table('cont_moneda_conversion')
			->set((array)$jsonData->put)
			//->columns(array('nombre'))
			->where(array('cont_moneda_conversion_id'=>$id));
		
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
		->from('cont_moneda_conversion')
		//->set((array)$jsonData->put)
		//->columns(array('nombre'))
		->where(array('cont_moneda_conversion_id'=>$id));
	
		$result = $sql->prepareStatementForSqlObject($delete)->execute();
	
		return new JsonModel(array('id'=> $id));
	}
	
}