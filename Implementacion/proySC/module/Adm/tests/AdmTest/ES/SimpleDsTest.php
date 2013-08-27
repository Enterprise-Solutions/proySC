<?php
namespace AdmTest\ES;
use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;
use EnterpriseSolutions\Simple\Cambios\Cambios;
use EnterpriseSolutions\Simple\Repository\DataSource;
/**
 * test case.
 */
class SimpleDsTest extends PHPUnit_Framework_TestCase {
	public $dataSource;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$this->dataSource = new DataSource($dbAdapter);
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
	
	public function testInsert()
	{
		$cambios = new Cambios();
		$cambios = $cambios->cambiar(array(), array(array('nombre' => 'Catolica')));
		$this->dataSource->persistirCambiosADatos($cambios, array(), 'org_religion', 'org_religion_id');
	}
}

