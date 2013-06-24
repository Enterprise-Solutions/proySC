<?php
namespace OrgTest\Rol;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Org\Rol\Repository;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class RepositoryTest extends PHPUnit_Framework_TestCase {
	
	public $_repository;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->_repository = new Repository($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_repository = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		
	}
	
	public function testGetRolExistente()
	{
		$rol = $rol = $this->_repository->getRol('cliente');
		$this->assertInstanceOf('Org\Rol\Rol', $rol);
		$this->assertEquals('cliente',$rol->getCodigo());
	}
}

