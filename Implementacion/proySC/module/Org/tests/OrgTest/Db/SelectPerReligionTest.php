<?php
namespace OrgTest\Db;
use OrgTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Org\Db\SelectPerReligion;
//require_once 'PHPUnit/Framework/TestCase.php';

/**
 * test case.
 */
class SelectPerReligionTest extends \PHPUnit_Framework_TestCase {
	protected $_select;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
		$this->_select  = new SelectPerReligion($adapter); 
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_select = null;
		parent::tearDown ();
		ob_flush();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testHelloPhpUnit()
	{
		$this->assertTrue(true);
	}
	
	public function testEjecutarSelectConsultaBd()
	{
		$rs = $this->_select->execute();
		print_r($rs->toArray());
		//$this->assertNotNull($rs);
	}
}

