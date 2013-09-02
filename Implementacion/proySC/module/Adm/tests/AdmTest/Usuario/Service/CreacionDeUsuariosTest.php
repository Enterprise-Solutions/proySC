<?php
namespace AdmTest\Usuario\Service;
use Adm\Usuario\Service\Creacion;

use Adm\Usuario\Repository;

use EnterpriseSolutions\Simple\Repository\DataSource;

use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;
/**
 * test case.
 */
class CreacionDeUsuariosTest extends PHPUnit_Framework_TestCase {
	public $_service;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$ds = new DataSource($dbAdapter);
		$repository = new Repository($ds);
		$this->_service = new Creacion($repository);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated CreacionDeUsuariosTest::tearDown()
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCreacionDeUsuario()
	{
		$params = array('org_parte_id' => 5,'contrasenha' => 'JaJa_123','confirmacion' => 'JaJa_123','estado' => 'A');
		$rs = $this->_service->ejecutar($params);
		print_r($rs);
	}
}

