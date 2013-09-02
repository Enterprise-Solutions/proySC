<?php
namespace AdmTest\Usuario\Repository;
use PHPUnit_Framework_TestCase;
use AdmTest\Bootstrap;
use Adm\Usuario\Repository\FindDatosDePersonaParaCrearUsuario as Select;
use Adm\Usuario\Repository\SelectRequisitosDePassword as SelectRequisitos;
use Adm\Usuario\Service\Listado\Select as SelectUsuarios;
use Adm\Usuario\Service\PersonasDisponibles\Select as SelectPersonasDisponibles;
use Adm\Usuario\Repository\FindDatosDePersonaParaCrearUsuario as SelectParaCrearUsuario;

/**
 * test case.
 */
class FindDatosDePersonaParaCrearUsuarioTest extends PHPUnit_Framework_TestCase {
	public $_select;
	public $_selectRequisitos;
	public $_selectDeUsuarios;
	public $_selectPersonasDisponibles;
	public $_selectParaCrearUsuario;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sm = Bootstrap::getServiceManager();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$this->_select = new Select($dbAdapter);
		$this->_selectRequisitos = new SelectRequisitos($dbAdapter);
		$this->_selectDeUsuarios = new SelectUsuarios($dbAdapter);
		$this->_selectPersonasDisponibles = new SelectPersonasDisponibles($dbAdapter);
		$this->_selectParaCrearUsuario = new SelectParaCrearUsuario($dbAdapter);
		//$this->dataSource = new DataSource($dbAdapter);
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
	
	public function testEjecucionDeSelect()
	{
		$this->_select->addSearchByOrgParteId(2);
		$rs = $this->_select->execute()->toArray();
		//print_r($rs);
	}
	
	public function testEjecucionDeRequisitosDePassword()
	{
		$rs = $this->_selectRequisitos->execute()->toArray();
		//print_r($rs);
	}
	
	public function testEjecucionDeSelectDeUsuarios()
	{
		$this->_selectDeUsuarios->addSearchByNombre('1284');
		$rs = $this->_selectDeUsuarios->execute()->toArray();
		//print_r($rs);
	}
	
	public function testEjecucionDeSelectPersonasDisponibles()
	{
		$this->_selectPersonasDisponibles->addSearchByNombre('1234');
		$rs = $this->_selectPersonasDisponibles->execute()->toArray();
		//print_r($rs);
	}
	
	public function testEjecucionDeSelectParaCrearUsuario()
	{
		$rs = $this->_selectParaCrearUsuario->execute()->toArray();
		print_r($rs);
	}
}

