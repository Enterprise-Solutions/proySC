<?php

namespace Stock\Controller;

use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao;

use Stock\Combos\Categoria\Select as CategoriaSelect;
use Stock\Combos\Marca\Select as MarcaSelect;
use Stock\Combos\Moneda\Select as MonedaSelect;
use Stock\Combos\GarantiaTipo\Select as GarantiaTipoSelect;

class CombosController extends BaseController
{
    public function categoriaAction($overwritedParams = array())
    {
        $select = new CategoriaSelect($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function marcaAction($overwritedParams = array())
    {
        $select = new MarcaSelect($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function monedaAction($overwritedParams = array())
    {
        $select = new MonedaSelect($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
    
    public function garantiaTipoAction($overwritedParams = array())
    {
        $select = new GarantiaTipoSelect($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $overwritedParams);
    }
}