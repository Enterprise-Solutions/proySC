<?php
namespace OrgTest;
use Org\Parte\Factory;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class ParteFactoryTest extends PHPUnit_Framework_TestCase {
	protected $_factory;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->_factory = new Factory($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_factory = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCrearPersona()
	{
		$persona = $this->_factory->crearPersona();
		$this->assertInstanceOf("Org\\Parte\\Persona\\Persona", $persona);
		$parteTipo = $persona->getParteTipo();
		$this->assertInstanceOf('Org\Parte\ParteTipo', $parteTipo);
		$this->assertEquals('per',$parteTipo->getCodigo());
	}
	
	public function testCrearOrganizacion()
	{
		$organizacion = $this->_factory->crearOrganizacion();
		$this->assertInstanceOf('Org\Parte\Organizacion\Organizacion', $organizacion);
		$parteTipo = $organizacion->getParteTipo();
		$this->assertInstanceOf('Org\Parte\ParteTipo', $parteTipo);
		$this->assertEquals('org',$parteTipo->getCodigo());
	}
}

