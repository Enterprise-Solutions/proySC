<?php

namespace EnterpriseSolutions\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Params;
use Zend\Json\Json;
use Zend\Http\Header\ContentType;
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
	
	public function getParams()
	{
		return array_merge(
		    $this->fromQuery(),
		    $this->fromPost(),
			$this->decodificarPostSegunContentType()
		);
	}
	
	/**
	 * @return array
	 */
	public function decodificarPostSegunContentType()
	{
		$contentType = $this->getController()->getRequest()->getHeader("CONTENT_TYPE");
		$postData = $this->getController()->getRequest()->getContent();
		//$postData = $this->fromPost();
		if($contentType instanceof ContentType && preg_match('/(application\/json)/',$contentType->value) > 0){
			$postData = Json::decode($postData,Json::TYPE_ARRAY);
		}else{
			$postData = array();
		}
		/*if($contentType && $contentType['value'] == 'application/json'){
			$postData = Json::decode($postData,Json::TYPE_ARRAY);
		}*/
		/*if(!$postData){
			$postData = array();
		}*/
		return $postData;
	}
}