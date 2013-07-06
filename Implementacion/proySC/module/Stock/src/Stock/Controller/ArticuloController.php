<?php

namespace Stock\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;
use EnterpriseSolutions\Db\Dao\Get as DaoGet;

use Stock\Articulo\QueryObject\Select;
use Stock\Articulo\QueryObject\Get;

class ArticuloController extends BaseController
{
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
        return $template($dao, array('id' => 1));
    }
}