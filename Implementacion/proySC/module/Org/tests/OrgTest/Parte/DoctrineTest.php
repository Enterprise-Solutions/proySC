<?php
namespace OrgTest;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;


/**
 * test case.
 */
class DoctrineTest extends PHPUnit_Framework_TestCase {
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
		$this->_em = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testGetEntidadConDoctrine()
	{
		$entidad = $this->_em->find('Org\Parte\ParteTipo', 2);
		$this->assertInstanceOf('Org\Parte\ParteTipo', $entidad);
	}
}

