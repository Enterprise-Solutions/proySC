<?php

namespace Stock\Articulo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sa' => 'stock_articulo'))
             ->columns(array('stock_articulo_id', 'nombre', 'codigo', 'precio_venta', 'existencia', 'rcap', 'porcentaje_impuesto'))
             
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
                 ->where("(sa.nombre || ' ' || sa.codigo) ILIKE '%$cadena%'");
        }
    }
    
    public function addSearchByMedioDePago($medio)
    {
        $articulo = array('stock_articulo_id', 'nombre', 'codigo', 'precio_venta', 'existencia', 'rcap', 'porcentaje_impuesto');
        switch ($medio) {
        	case 'E':  // Efectivo
        	    $this->_select
        	         ->columns(array_merge($articulo, array('precio_venta_final' => 'precio_venta')));
        	    break;
        	case 'C':  // Credito
        	    $this->_select
        	         ->columns(array_merge($articulo, array('precio_venta_final' => new Expression("sa.precio_venta * 1.04"))));
        	    break;
        	case 'D':  // Debito
        	    $this->_select
        	         ->columns(array_merge($articulo, array('precio_venta_final' => new Expression("sa.precio_venta * 1.08"))));
        	    break;
        	default:   // Defecto: Efectivo
        	    $this->_select
        	         ->columns(array_merge($articulo, array('precio_venta_final' => 'precio_venta')));
        	    break;
        }
    }
}