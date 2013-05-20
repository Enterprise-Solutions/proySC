<?php
namespace OrgTest\Parte\Persona;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;
use Org\Parte\Persona\Repositorio;

/**
 * test case.
 */
class RepositorioTest extends PHPUnit_Framework_TestCase {
	
	protected $_repositorio;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->_repositorio = new Repositorio($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_repositorio = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testFindPersonaById()
	{
		$persona = $this->_repositorio->findById(1);
		$this->assertInstanceOf('Org\Parte\Persona\Persona', $persona);
		$this->assertEquals("per", $persona->getCodigoDeTipo());
	}
}

