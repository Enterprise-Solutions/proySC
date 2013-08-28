<?php

namespace EnterpriseSolutions\Exceptions;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\Model\JsonModel;
use EnterpriseSolutions\Exceptions\Exception as ESException;

class Listener implements ListenerAggregateInterface
{
	protected $listeners = array();
	
	public function attach(EventManagerInterface $events, $priority = 1)
	{
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatch'), -2);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onDispatch'), -2);
	}
	
	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
	
	public function onDispatch(MvcEvent $e)
	{
		$error = $e->getError();
		$exception = $e->getParam('exception');
		if (!$error) {
			// No error? nothing to do.
			return;
		}
		
		$request = $e->getRequest();
		$headers = $request->getHeaders();
		if (!$headers->has('Accept')) {
			// nothing to do; can't determine what we can accept
			return;
		}
		
		$accept = $headers->get('Accept');
		if (!$accept->match('application/json')) {
			// nothing to do; does not match JSON
			return;
		}
		
		if(!$exception instanceof ESException){
			return;
		}
		$model = new JsonModel(array(
			'status' => false,
			'mensaje' => $exception->getMensaje(),
			'datos'   => $exception->getDatos()		
		));
		$e->setResult($model);
		$response = $e->getResponse();
		if(!$response){
			$response = new HttpResponse();
			$e->setResponse($response);
		}
		$response->setStatusCode($exception->getCodigoDeRespuesta());
				//$model = new JsonModel();
				//$model->setTerminal(true);
				/*$model = new JsonModel(array(
						'message'            => 'An error occurred during execution; please try again later.',
						'exception'          => 'expection',
						'display_exceptions' => 's',
				));*/
				//$model->setTemplate($this->getExceptionTemplate());
				
				
				
				/*$response = $e->getResponse();
				if (!$response) {
					$response = new HttpResponse();
					$response->setStatusCode(500);
					$e->setResponse($response);
				} else {
					$statusCode = $response->getStatusCode();
					if ($statusCode === 200) {
						$response->setStatusCode(400);
						
					}
				}*/
				// inject as needed with error/exception information.
				// maybe set HTTP response codes based on type of error.
				// etc.
				
				//$e->setResult($model);
				//$e->stopPropagation();
				//return $model;
				//$e->getResult()->setTerminal(true);
				//return $model->setTerminal(true);
	}
}