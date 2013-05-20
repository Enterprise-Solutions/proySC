<?php
namespace OrgTest\Parte\Persona;
use Org\Parte\Persona\Factory;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class FactoryTest extends PHPUnit_Framework_TestCase {
	protected $factory;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->factory = new Factory($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->factory = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testFindParteTipoByCodigoCargaParteTipo()
	{
		$parteTipo = $this->factory->_findTipoDeParte('per');
		$this->assertEquals('per',$parteTipo->getCodigo());
	}
	
	public function testCrearPartePersona()
	{
		$parte = $this->factory->crear();
		$this->assertInstanceOf('Org\Parte\Persona\Persona', $parte);
		$this->assertInstanceOf('Org\Parte\Parte', $parte);
		$this->assertEquals('per',$parte->getCodigoDeTipo());
	}
}

