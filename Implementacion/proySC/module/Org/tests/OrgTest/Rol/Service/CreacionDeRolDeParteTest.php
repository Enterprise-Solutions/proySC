<?php
namespace OrgTest\Rol\Service;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Rol\Service\CreacionDeRolDeParte;
use Org\Parte\Service\Transaccional;

/**
 * test case.
 */
class CreacionDeRolDeParteTest extends PHPUnit_Framework_TestCase {
	
	public $_service;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$service = new CreacionDeRolDeParte($em);
		$this->_service = new Transaccional($em,$service);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_service = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCrearPersonaConRol()
	{
		$datos = array(
			'org_rol_codigo' => 'cliente',
			'org_parte' => array('org_parte_id' => 22)
		);
		$rolDeParte = $this->_service->ejecutar($datos);
		$this->assertInstanceOf('Org\Rol\RolDeParte', $rolDeParte);
	}
}

