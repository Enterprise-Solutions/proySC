<?php

namespace Stock\Articulo\Listado;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sa' => 'stock_articulo'))
             ->columns(array('stock_articulo_id', 'nombre', 'codigo', 'precio_venta', 'existencia'))
             
             ->join(array('sm' => 'stock_marca'), 'sa.stock_marca_id = sm.stock_marca_id', array('marca' => 'nombre'))
             ->join(array('sc' => 'stock_categoria'), 'sa.stock_categoria_id = sc.stock_categoria_id', array('categoria' => 'nombre'));
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
    
    public function addSearchByMarca($marca = null)
    {
        if ($marca && is_int($marca)) {
            $this->_select
                 ->where("sm.stock_marca_id = $marca");
        }
    }
    
    public function addSearchByCategoria($categoria = null)
    {
        if ($categoria && is_int($categoria)) {
            $this->_select
                 ->where("sc.stock_categoria_id = $categoria");
        }
    }
}