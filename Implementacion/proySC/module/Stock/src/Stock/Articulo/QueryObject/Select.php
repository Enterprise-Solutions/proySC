<?php

namespace Stock\Articulo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sa' => 'stock_articulo'))
             ->columns(array('stock_articulo_id', 'nombre', 'codigo', 'precio_venta', 'existencia', 'rcap'))
             
             ->join(array('sm' => 'stock_marca'), 'sa.stock_marca_id = sm.stock_marca_id', array('marca' => 'nombre'))
             ->join(array('sc' => 'stock_categoria'), 'sa.stock_categoria_id = sc.stock_categoria_id', array('categoria' => 'nombre'))
             ->join(array('cm' => 'cont_moneda'), 'sa.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre', 'simbolo'));
    }
    
    public function addSearchById($id = null)
    {
    	if ($id) {
    		$this->_select
    		->where("sa.stock_articulo_id = $id");
    	}
    }
    
    public function addSearchByArticulo($articulo = null)
    {
        if ($articulo && is_string($articulo)) {
            $this->_select
                 ->where("sa.nombre ILIKE '%$articulo%'");
        }
    }
    
    public function addSearchByCodigo($codigo = null)
    {
        if ($codigo && is_string($codigo)) {
            $this->_select
                 ->where("sa.codigo ILIKE '%$codigo%'");
        }
    }
    
    public function addSearchByRcap($rcap = null)
    {
        if ($rcap) {
        	$this->_select
        	     ->where("sa.rcap ILIKE '%$rcap%'");
        }
    }
    
    public function addSearchByMarca($marca = null)
    {
        if ($marca) {
            $this->_select
                 ->where("sm.stock_marca_id = $marca");
        }
    }
    
    public function addSearchByCategoria($categoria = null)
    {
        if ($categoria) {
            $this->_select
                 ->where("sc.stock_categoria_id = $categoria");
        }
    }
    
    public function addSearchByCadena($cadena = null)
    {
        if ($cadena) {
            $this->_select
                 ->where("(sa.nombre || ' ' || sa.codigo) ILIKE ''%$cadena%");
        }
    }
}