<?php
namespace OrgTest;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Parte\Service\Borrado;
use Org\Parte\Service\Transaccional;
use Org\Parte\Repository;

/**
 * test case.
 */
class BorrarTest extends PHPUnit_Framework_TestCase {
	
	public $_service;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$repository = new Repository($em);
		$service = new Borrado($repository);
		$this->_service = new Transaccional($em,$service);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated BorrarTest::tearDown()
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testBorrar()
	{
		$this->_service->ejecutar(array(19,20));
	}
}

