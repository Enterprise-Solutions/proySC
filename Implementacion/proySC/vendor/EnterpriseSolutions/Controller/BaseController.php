<?php

namespace EnterpriseSolutions\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController {
	
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
}