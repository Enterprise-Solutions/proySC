<?php
namespace AdmTest\Controller;

use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;
use Zend\Http\Request,Zend\Http\Response,Zend\Mvc\MvcEvent,Zend\Mvc\Router\RouteMatch;
use Adm\Controller\UsuarioController as TestController;

/**
 * test case.
 */
class UsuarioControllerTest extends PHPUnit_Framework_TestCase {
	
	protected $controller;
	protected $request;
	protected $response;
	protected $routeMatch;
	protected $event;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$serviceManager = Bootstrap::getServiceManager();
		//$serviceManager->setInvokableClass('submitParams','EnterpriseSolutions\Controller\Plugin\SubmitParams');
		
		$this->controller = new TestController();
		$this->controller->getPluginManager()->setInvokableClass('submitParams', 'EnterpriseSolutions\Controller\Plugin\SubmitParams');
		$this->request = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'usuario'));
		$this->event = new MvcEvent();
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/*public function testCrearUsuario()
	{
		$this->routeMatch->setParam('action', 'post');
		$this->request->setMethod('post');
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		$this->request->setContent('{"post":{"org_parte_id":5,"contrasenha":"JaJa_2013","confirmacion":"JaJa_2013"}}');
		$result = $this->controller->dispatch($this->request);
		print_r($result);
	}*/
	
	/*public function testUpdateUsuario()
	{
		$this->routeMatch->setParam('action', 'put');
		$this->request->setMethod('post');
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		$this->request->setContent('{"put":{"adm_usuario_id":5,"contrasenha":"JaJa_2013","confirmacion":"JaJa_2013"}}');
		$result = $this->controller->dispatch($this->request);
		print_r($result);
	}*/
	
	public function testBorradoDeUsuario()
	{
		$this->routeMatch->setParam('action', 'delete');
		$this->request->setMethod('post');
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		$this->request->setContent('{"delete":[6]}');
		$result = $this->controller->dispatch($this->request);
		print_r($result);
	}
}

