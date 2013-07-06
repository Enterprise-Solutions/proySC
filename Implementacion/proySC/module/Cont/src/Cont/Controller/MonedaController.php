<?php

namespace Cont\Controller;

use Zend\View\Model\JsonModel;
use Zend\Json;
use Zend\Json\Decoder;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Cont\Moneda\Listado\Select;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;

class MonedaController extends BaseController
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
		
		/*
		 * $this->_select
             ->from(array('cm' => 'cont_moneda'))
             ->columns(array('cont_moneda_id', 'nombre', 'nombre_plural', 'simbolo', 'descripcion','permite_decimal'));
		 */
		
		
		$selectString = $sql->getSqlStringForSqlObject($select);
		$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		
		return new JsonModel($results);
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	public function crearAction()
	{
		/*$allPostValues = $this->params()->fromPost();
		$allGetValues = $this->params()->fromQuery();
		$allRouteValues = $this->params()->fromRoute();
		$allHeaderValues = $this->params()->fromHeader();
		*/
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		//var_dump($jsonData->post);
		
		/*
		var_dump($jsonData,$rawData);
		
		var_dump($this->getRequest()->getContent(), $this->getRequest()->getMetadata(),$this->getRequest()->getContent(),
			$this->params()->fromQuery(),
			$this->getRequest()->getQuery(), $this->params()->fromQuery(), $this->params()->fromRoute(),$this->params()->fromHeader(),
			$this->getEvent()->getRouteMatch()->getParams(), $this->getRequest()->getPost()
		);*/
		//print_r($this->params()->);
	
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		
		//$objInsert = new Insert('cont_moneda');
		//$objInsert->values(array( 'nombre' => 'reloco'));
		
		$sql = new Sql($adapter);
		$insert = $sql->insert()
			->into('cont_moneda')
			//->columns(array('nombre'))
			->values((array)$jsonData->post);
		/*
		
		 * $this->_select
		->from(array('cm' => 'cont_moneda'))
		->columns(array('cont_moneda_id', 'nombre', 'nombre_plural', 'simbolo', 'descripcion','permite_decimal'));
		*/
	
	
		$result = $sql->prepareStatementForSqlObject($insert)->execute()->getGeneratedValue();
		
		//print_r($result);
		//$results = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
		
		
		return new JsonModel(array('id'=> $adapter->getDriver()->getLastGeneratedValue('cont_moneda_cont_moneda_id_seq')));
	}
	
	//TODO implementacion rudimentaria / modificar para el get de datos de una moneda
	public function editarAction()
	{
		/*$allPostValues = $this->params()->fromPost();
			$allGetValues = $this->params()->fromQuery();
		$allRouteValues = $this->params()->fromRoute();
		$allHeaderValues = $this->params()->fromHeader();
		*/
		$rawData =  $this->getRequest()->getContent();
		$jsonData = json_decode($rawData);
		
		$id = $jsonData->id;
	
		//var_dump($jsonData->post);
	
		/*
			var_dump($jsonData,$rawData);
	
		var_dump($this->getRequest()->getContent(), $this->getRequest()->getMetadata(),$this->getRequest()->getContent(),
				$this->params()->fromQuery(),
				$this->getRequest()->getQuery(), $this->params()->fromQuery(), $this->params()->fromRoute(),$this->params()->fromHeader(),
				$this->getEvent()->getRouteMatch()->getParams(), $this->getRequest()->getPost()
		);*/
		//print_r($this->params()->);
	
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
	
		//$objInsert = new Insert('cont_moneda');
		//$objInsert->values(array( 'nombre' => 'reloco'));
	
		$sql = new Sql($adapter);
		$update = $sql->update()
			->table('cont_moneda')
			->set((array)$jsonData->put)
			//->columns(array('nombre'))
			->where(array('cont_moneda_id'=>$id));
		
		/*
	
		* $this->_select
		->from(array('cm' => 'cont_moneda'))
		->columns(array('cont_moneda_id', 'nombre', 'nombre_plural', 'simbolo', 'descripcion','permite_decimal'));
		*/
	
	
		$result = $sql->prepareStatementForSqlObject($update)->execute();
	
		//print_r($result);
		//$results = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
	
	
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
		->from('cont_moneda')
		//->set((array)$jsonData->put)
		//->columns(array('nombre'))
		->where(array('cont_moneda_id'=>$id));
	
		$result = $sql->prepareStatementForSqlObject($delete)->execute();
	
		return new JsonModel(array('id'=> $id));
	}
	
}