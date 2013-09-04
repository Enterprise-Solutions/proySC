<?php
namespace AdmTest\Usuario\Service;
use Adm\Usuario\Service\Edicion;
use Adm\Usuario\Service\Borrado;
use Adm\Usuario\Repository;

use EnterpriseSolutions\Simple\Repository\DataSource;

use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;

/**
 * test case.
 */
class EdicionDeUsuariosTest extends PHPUnit_Framework_TestCase {
	public $_service;
	public $_borrado;
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
		$this->_borrado = new Borrado($repository);
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
	
	/*public function testEditar()
	{
		$resultados = $this->_service->ejecutar(array('adm_usuario_id' => 5,'estado' => 'A','contrasenha' => 'Vilma@2013','confirmacion' => 'Vilma@2013'));
		print_r($resultados);
	}*/
	
	public function testBorrado()
	{
		$resultados = $this->_borrado->ejecutar(array(2,5));
		print_r($resultados);
	}
}

