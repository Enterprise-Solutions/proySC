<?php
namespace OrgTest\Listado;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use OrgTest\Bootstrap;
use Org\Parte\Service\Listado\Select;

/**
 * test case.
 */
class SelectTest extends PHPUnit_Framework_TestCase {
	
	public $_select;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$this->_select = new Select($dbAdapter);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated SelectTest::tearDown()
		ob_flush();
		$this->_select = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testEjecucion()
	{
		/*$rs = $this->_select->execute();
		print_r($rs->toArray());*/
	}
	
	public function testBusquedaPorOrgParteTipoCodigo()
	{
		/*$this->_select->addSearchByOrgParteTipoCodigo('org');
		$rs = $this->_select->execute();
		print_r($rs->toArray());*/
	}
	
	public function testBusquedaPorNombre()
	{
		$this->_select->addSearchByNombre('Islas Pablo');
		$rs = $this->_select->execute();
		print_r($rs->toArray());
	}
}

