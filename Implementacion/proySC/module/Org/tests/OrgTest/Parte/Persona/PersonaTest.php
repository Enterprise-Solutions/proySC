<?php

namespace OrgTest\Parte\Persona;
use Zend\Form\Annotation\AnnotationBuilder;

use Org\Parte\Factory;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;

use OrgTest\Bootstrap;

/**
 * test case.
 */
class PersonaTest extends PHPUnit_Framework_TestCase {
	public $factory;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$em = $sm->get('doctrine.entitymanager.orm_default');
		$this->factory = new Factory($em);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->factory = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCrearFormMedianteAnotacionesPersonaYValidarDatos()
	{
		/*$persona = $this->factory->crear();
		$builder = new AnnotationBuilder();
		$form = $builder->createForm($persona);
		$datos = array('genero' => 's','fechaDeNacimiento' => '01/12/1979');
		$form->setData($datos);
		$this->assertFalse($form->isValid());
		$mensajesDeError = $form->getMessages();
		$this->assertFalse($form->isValid());*/
		$persona = $this->factory->crearPersona();
		//$if = $persona->_getInputFilter('creacion');
		//$if->setData(array('nombre' => 'Pablo','apellido' => 'Islas','fechaDeNacimiento' => '01-12-1979','genero' => 'H'));
		//$this->assertTrue($if->isValid());
		//$hidrator = new Hydrator();
		//$persona = $hidrator->hydrate(array_filter($if->getValues()), $persona);
		$persona->crear(array('nombre' => 'Pablo','apellido' => 'Islas','fechaDeNacimiento' => '01-12-1979','genero' => 'H'));
		$this->assertEquals('Pablo',$persona->nombre);
	}
}

