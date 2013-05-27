<?php
namespace OrgTest\Parte\Persona;
use Org\Parte\Factory;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;
use Org\Parte\Persona\Repositorio;

/**
 * test case.
 */
class PersistenciaParteTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var EntityManager
	 */
	protected $_em;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$this->_em = $sm->get('doctrine.entitymanager.orm_default');
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
		//$persona = $this->_repositorio->findById(1);
		$persona = $this->_em->find('Org\Parte\Persona\Persona', 2);
		$this->assertInstanceOf('Org\Parte\Persona\Persona', $persona);
		//$this->assertEquals("per", $persona->getCodigoDeTipo());
	}
	
	public function testPersistirPersona()
	{
		$factory = new Factory($this->_em);
		$persona = $factory->crearPersona();
		$this->assertNull($persona->getId());
		$persona->nombre = 'Pedro';
		$persona->apellido = 'Picapiedras';
		$persona->fechaDeNacimiento = '25-12-1979';
		$persona->genero = 'H';
		$this->_em->persist($persona);
		$this->_em->flush();
		$this->assertNotNull($persona->getId());
	}
	
	public function testPersistirOrganizacion()
	{
		$factory = new Factory($this->_em);
		$org = $factory->crearOrganizacion();
		$this->assertNull($org->getId());
		$org->nombre = 'ProySc';
		$this->_em->persist($org);
		$this->_em->flush();
		$this->assertNotNull($org->getId());
	}
}

