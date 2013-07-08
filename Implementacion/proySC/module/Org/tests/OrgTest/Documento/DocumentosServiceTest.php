<?php

namespace OrgTest\Documento;
use Org\Documento\Documento\Factory;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

use OrgTest\Bootstrap;
use Org\Documento\Repository;
use Org\Parte\Repository as repoDePartes;
use Org\Documento\Service;

/**
 * test case.
 */
class DocumentosServiceTest extends PHPUnit_Framework_TestCase {
	
	public $_service;
	public $_parte;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$repoDePartes = new repoDePartes($em);
		$this->_parte = $repoDePartes->get(42);
		$repository = new Repository($em);
		$factory = new Factory($repository);
		$this->_service = new Service($factory,$repository);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->_parte = null;
		$this->_service = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testBorrarDocumentos()
	{
		$datos = array(
			'org_parte' => $this->_parte,
			'Documentos' => array(
				'agregados' => array(),
				'editados'  => array(),
				'borrados'  => array(1)
			)		
	    );
		$this->_service->ejecutar($datos);
		$respuesta = $this->_service->getRespuesta();
		$this->assertFalse(isset($respuesta['agregados']));
		$this->assertFalse(isset($respuesta['editados']));
		$this->assertTrue(isset($respuesta['borrados']));
		$this->assertCount(1,$respuesta['borrados']);
		$this->_service->_docRepository->_em->flush();
	}
	
	public function testEditarDocumentos()
	{
		/*$datos = array(
				'org_parte' => $this->_parte,
				'Documentos' => array(
						'agregados' => array(),
						'editados'  => array(array('org_documento_id' => 1,'valor' => '1.284.047')),
						'borrados'  => array()
				)
		);
		$this->_service->ejecutar($datos);
		$respuesta = $this->_service->getRespuesta();
		$this->assertFalse(isset($respuesta['agregados']));
		$this->assertFalse(isset($respuesta['borrados']));
		$this->assertTrue(isset($respuesta['editados']));
		$this->assertCount(1,$respuesta['editados']);*/
	}
	
	public function testAgregarDocumentos()
	{
		/*$datos = array(
				'org_parte' => $this->_parte,
				'Documentos' => array(
						'agregados' => array(array('org_documento_tipo_codigo' => 'ruc','valor' => '1284047-5')),
						'editados'  => array(array('org_documento_id' => 1,'valor' => '1.284.047')),
						'borrados'  => array()
				)
		);
		$this->_service->ejecutar($datos);
		$respuesta = $this->_service->getRespuesta();
		$this->assertTrue(isset($respuesta['agregados']));
		$this->assertFalse(isset($respuesta['borrados']));
		$this->assertTrue(isset($respuesta['editados']));
		$this->assertCount(1,$respuesta['editados']);
		$this->assertCount(1,$respuesta['agregados']);
		$this->_service->_docRepository->_em->flush();*/
	}
}

