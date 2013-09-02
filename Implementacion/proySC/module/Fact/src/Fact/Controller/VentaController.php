<?php

namespace Fact\Controller;

use Doctrine\ORM\EntityManager;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Fact\Egreso\QueryObject\Get\Dao as DaoGet;
use Fact\Egreso\QueryObject\Select;
use Fact\Egreso\QueryObject\Get;
use Fact\Egreso\Service\ValidarDetalle as ValidarDetalleService;
use Fact\Egreso\Service\Crear as CrearEgresoService;
use Fact\Egreso\Service\CargarNroDocumento as CargarNroDocumentoService;

class VentaController extends BaseController
{
    public function validateAction()
    {
        $data = $this->SubmitParams()->getParams();
        
        $service = new ValidarDetalleService($this->getEntityManager());
        $service->validar($data);
        
        return $this->toJson($service->getResult());
    }
    
	public function indexAction($overwritedParams = array())
	{
	    $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
	    $dao = new Dao($select);
	    $template = $this->_crearTemplateParaListado();
	    return $template($dao, array(), $overwritedParams);
	}
	
	public function getAction()
	{
	    $query = new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
	    $dao = new DaoGet($query);
	    $template = $this->_crearTemplateParaGet();
	    return $template($dao, array());
	}
	
	/**
	 * Crear Egreso
	 */
	public function postAction()
	{
	    $em = $this->getEntityManager();
	    $data = $this->SubmitParams()->getParam('post');
	    
	    $service = new CrearEgresoService($em);
	    $service->ejecutar($data);
	    $service->persistir();
	
	    return $this->toJson($service->getRespuesta());
	}
	
	public function setNroDocumentoAction()
	{
	    $em = $this->getEntityManager();
	    $data = $this->SubmitParams()->getParams();
	    
	    $service = new CargarNroDocumentoService($em);
	    $service->ejecutar($data);
	    $service->persistir();
	    
	    return $this->toJson($service->getResult());
	}
	
	/**
	 * Convierte un array a json
	 * @param array $respuesta
	 */
	protected function toJson($respuesta)
	{
	    $viewModel = $this->_seleccionarViewModelSegunContexto(
	            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
	    );
	    $viewModel->setVariables($respuesta);
	    return $viewModel;
	}
	
	/**
	 * Obtiene el Doctrine Entity Manager
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
	    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    return $em;
	}
}