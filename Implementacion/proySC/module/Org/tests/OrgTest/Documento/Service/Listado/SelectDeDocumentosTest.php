<?php
namespace OrgTest\Documento\Service\Listado\Select;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;
use Org\Documento\Service\Listado\Select;

/**
 * test case.
 */
class SelectDeDocumentosTest extends PHPUnit_Framework_TestCase {
	
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
		$this->_select = null;
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testPorDefaultListaTodosLosDocumentos()
	{
		/*$rs = $this->_select->execute();
		print_r($rs->toArray());*/
	}
	
	public function testAddSearchByValorBuscaPorElValorDeDocumento()
	{
		/*$this->_select->addSearchByValor('1284');
		$rs = $this->_select->execute();
		print_r($rs->toArray());*/
	}
	
	public function testAddSearchByParteBuscaPorElNombreDeParte()
	{
		$this->_select->addSearchByParte('Islas');
		$rs = $this->_select->execute();
		print_r($rs->toArray());
	}
}

