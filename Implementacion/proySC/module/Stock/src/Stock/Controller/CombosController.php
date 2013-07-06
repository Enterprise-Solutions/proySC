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
    protected function getDbAdapter()
    {
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
    
    protected function listData($select, $defaultParams = array())
    {
        $dao = new Dao($select);
        $template = $this->_crearTemplateParaListado();
        return $template($dao, array(), $defaultParams);
    }
    
    public function categoriaAction()
    {
        $select = new CategoriaSelect($this->getDbAdapter());
        return $this->listData($select);
    }
    
    public function marcaAction($overwritedParams = array())
    {
        $select = new MarcaSelect($this->getDbAdapter());
        return $this->listData($select);
    }
    
    public function monedaAction($overwritedParams = array())
    {
        $select = new MonedaSelect($this->getDbAdapter());
        return $this->listData($select);
    }
    
    public function garantiaTipoAction($overwritedParams = array())
    {
        $select = new GarantiaTipoSelect($this->getDbAdapter());
        return $this->listData($select);
    }
}