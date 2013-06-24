<?php
namespace Org\Controller;
use OrgTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Org\Controller\EmpresasController;
use Zend\Http\Request,Zend\Http\Response,Zend\Mvc\MvcEvent,Zend\Mvc\Router\RouteMatch;
//require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class SkeletonControllerTest extends PHPUnit_Framework_TestCase {
	
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
		
		$this->controller = new EmpresasController();
		$this->controller->getPluginManager()->setInvokableClass('submitParams', 'EnterpriseSolutions\Controller\Plugin\SubmitParams');
		$this->request = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'empresas'));
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
	
	public function testIndex()
	{
		$this->routeMatch->setParam('action', 'empresas');
		$this->request->setMethod('get');
		
		//$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		//$this->request->setContent('{"param1":"hello"}');
		//$this->request->getPost()->set('param1','hello1');
		//$this->request->setPost('{"param1":"hello"}');
		//$this->request->setContent('{"param1":"hello"}');
		//$result = $this->controller->dispatch($this->request);
		//print_r($result);
	}
	
	public function testCrear()
	{
		$this->routeMatch->setParam('action', 'crear');
		$this->request->setMethod('post');
		
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		$this->request->setContent('{"post":{"nombre":"BBSoft"}}');
		//$this->request->getPost()->set('param1','hello1');
		//$this->request->setPost('{"param1":"hello"}');
		//$this->request->setContent('{"param1":"hello"}');
		$result = $this->controller->dispatch($this->request);
		print_r($result);
	}
}

