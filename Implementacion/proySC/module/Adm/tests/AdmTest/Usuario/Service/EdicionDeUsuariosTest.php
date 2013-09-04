<?php
namespace AdmTest\Usuario\Service;
use Adm\Usuario\Service\Edicion;
use Adm\Usuario\Repository;

use EnterpriseSolutions\Simple\Repository\DataSource;

use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;

/**
 * test case.
 */
class EdicionDeUsuariosTest extends PHPUnit_Framework_TestCase {
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
		$this->_service = new Edicion($repository);
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
	
	public function testEditar()
	{
		$resultados = $this->_service->ejecutar(array('adm_usuario_id' => 5,'estado' => 'A','contrasenha' => 'Vilma@2013','confirmacion' => 'Vilma@2013'));
		print_r($resultados);
	}
}

