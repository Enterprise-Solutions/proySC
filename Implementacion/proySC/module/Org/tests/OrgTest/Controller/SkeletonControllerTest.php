<?php
namespace Org\Controller;
use OrgTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Org\Controller\SkeletonController;
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
		
		$this->controller = new SkeletonController();
		$this->controller->getPluginManager()->setInvokableClass('submitParams', 'EnterpriseSolutions\Controller\Plugin\SubmitParams');
		$this->request = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'skeleton'));
		$this->event = new MvcEvent();
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated SkeletonControllerTest::tearDown()
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
		$this->routeMatch->setParam('action', 'index');
		$this->request->setMethod('post');
		
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		$this->request->setContent('{"param1":"hello"}');
		//$this->request->getPost()->set('param1','hello1');
		//$this->request->setPost('{"param1":"hello"}');
		//$this->request->setContent('{"param1":"hello"}');
		$result = $this->controller->dispatch($this->request);
	}
}

