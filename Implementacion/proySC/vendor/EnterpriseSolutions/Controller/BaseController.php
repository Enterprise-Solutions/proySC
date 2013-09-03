<?php

namespace EnterpriseSolutions\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use EnterpriseSolutions\Db\Dao\Dto;

class BaseController extends AbstractActionController {
	
	/**
	 * @param unknown_type $acceptCriteria
	 */
	public function _seleccionarViewModelSegunContexto($acceptCriteria = array())
	{
		if(!$acceptCriteria){
			$acceptCriteria = array(
					'Zend\View\Model\ViewModel' => array(
							'text/html',
					),
					'Zend\View\Model\JsonModel' => array(
							'application/json',
		    ));
		}

		return $this->acceptableViewModelSelector($acceptCriteria);
	}
	
	public function _crearTemplateParaListado()
	{
		$self = $this;
		return function($dao,$params = array(),$overwritedParams = array()) use($self){
			$params = array_merge_recursive(
			    $params,
				$self->SubmitParams()->getParams(),
				$overwritedParams
			);
			$rs = $dao->find(new Dto($params));
			$viewModel = $self->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
					'text/html','application/json'
			)));
			$viewModel->setVariables($rs);
			return $viewModel;
		};
	}
	
	public function _crearTemplateParaGet($idParam = 'id')
	{
		$self = $this;
		return function($dao,$overwritedParams) use($self,$idParam){
			$params = array_merge_recursive(
				$self->SubmitParams()->getParams(),
				$overwritedParams
			);
			$rs = $dao->get(new Dto($params,$idParam));
			$viewModel = $self->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
					'text/html','application/json'
			)));
			$viewModel->setVariables($rs);
			return $viewModel;
		};
	}
	
	public function indexUIAction()
	{
		
	}
	
	public function listUIAction()
	{
		
	}
	
	public function crearUIAction()
	{
	
	}
	
	public function getUIAction()
	{
	
	}
	
	public function editarUIAction()
	{
	
	}
	
	public function _returnAsJson($respuesta)
	{
		$viewModel = $this->_seleccionarViewModelSegunContexto(array('Zend\View\Model\JsonModel' => array(
				'text/html','application/json'
		)));
		$viewModel->setVariables($respuesta);
		return $viewModel;
	}
}
