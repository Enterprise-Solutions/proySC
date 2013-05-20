<?php

namespace EnterpriseSolutions\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Params;
use Zend\Json\Json;

class SubmitParams extends Params {
	
	public function getParam($name)
	{
	    $value = $this->fromQuery($name,false);
	    if(!$value){
	    	$value = $this->fromPost($name,false);
	    }
	    if(!$value){
	        $postData = $this->decodificarPostSegunContentType();
	        if(array_key_exists($name, $postData)){
	        	$value = $postData[$name];
	        }	
	    }
	    return $value;	
	}
	
	/**
	 * @return array
	 */
	public function decodificarPostSegunContentType()
	{
		$contentType = $this->getController()->getRequest()->getHeader("CONTENT_TYPE");
		$postData = $this->getController()->getRequest()->getContent();
		//$postData = $this->fromPost();
		if($contentType->value == 'application/json'){
			$postData = Json::decode($postData,Json::TYPE_ARRAY);
		}
		return $postData;
	}
}