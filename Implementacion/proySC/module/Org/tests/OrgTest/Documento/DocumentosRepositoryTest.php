<?php

namespace OrgTest\Documento;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;
use Org\Documento\Repository;
use Org\Parte\Repository as repoDePartes;

/**
 * test case.
 */
class DocumentosRepositoryTest extends PHPUnit_Framework_TestCase {
	
	public $_repository;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->_repository = new Repository($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_repository = null;
		ob_flush();
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testGetDocumentosByOrgParteid()
	{
		$documentos = $this->_repository->findDocumentosByOrgParteId(42);
		foreach($documentos as $doc){
			$this->assertEquals(42, $doc->getParte()->getId());
		}
	}
	
	public function testGetDocumentosDeParte()
	{
		$repoDePartes = new repoDePartes($this->_repository->_em);
		$parte = $repoDePartes->get(42);
		$documentos = $this->_repository->findDocumentosDeParte($parte);
		foreach($documentos as $doc){
			$this->assertEquals(42, $doc->getParte()->getId());
		}
	}
}

