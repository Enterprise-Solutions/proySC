<?php

namespace Fact\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use Fact\Ingreso\QueryObject\Get\Dao as DaoGet;

use Fact\Ingreso\QueryObject\Select;
use Fact\Ingreso\QueryObject\Get;

use Fact\Ingreso\Service\ValidarDetalle as ValidarDetalleService;
use Fact\Ingreso\Service\Crear as CrearIngresoService;
use Fact\Ingreso\Service\Editar as EditarIngresoService;

class CompraController extends BaseController
{
    /**
     * Valida los datos del detalle
     */
    public function validateAction()
    {
        $data = $this->SubmitParams()->getParams();
        
        $service = new ValidarDetalleService($this->getEntityManager());
        $service->validar($data);
        
        return $this->toJson($service->getResult());
    }
    
    /**
     * Ultimo costo del articulo comprado a un proveedor
     */
    public function getLastCostAction()
    {
        
    }
    
    public function indexAction($overwritedParams = array())
    {
        $select = new Select($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    /**
     * Detalle del Ingreso
     */
    public function getAction()
    {
        $query = new Get($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new DaoGet($query);
        $template = $this->_crearTemplateParaGet();
        return $template($dao, array());
    }
    
    /**
     * Crear Ingreso
     */
    public function postAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('post');
        
        $service = new CrearIngresoService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    /**
     * Editar Ingreso
     */
    public function putAction()
    {
        $em = $this->getEntityManager();
        $data = $this->SubmitParams()->getParam('put');
        
        $service = new EditarIngresoService($em);
        $service->ejecutar($data);
        $this->getEntityManager()->flush();
        
        return $this->toJson($service->getRespuesta());
    }
    
    /**
     * Eliminar Ingreso
     */
    public function deleteAction()
    {
        
    }
    
    protected function toJson($respuesta)
    {
        $viewModel = $this->_seleccionarViewModelSegunContexto(
            array('Zend\View\Model\JsonModel' => array('text/html', 'application/json'))
        );
        $viewModel->setVariables($respuesta);
        return $viewModel;
    }
    
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }
    
    protected function getServiceManager()
    {
        return new ServiceManager($this->getEntityManager());
    }
}