<?php

namespace Stock\Articulo\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sa' => 'stock_articulo'))
             ->columns(array('stock_articulo_id', 'nombre', 'codigo', 'descripcion', 'modelo', 'precio_venta', 'tiempo_garantia', 'porcentaje_impuesto', 'descuento_maximo', 'estado', 'tipo'))
             
             ->join(array('sm' => 'stock_marca'), 'sa.stock_marca_id = sm.stock_marca_id', array('stock_marca_id', 'marca' => 'nombre'))
             ->join(array('sc' => 'stock_categoria'), 'sa.stock_categoria_id = sc.stock_categoria_id', array('stock_categoria_id', 'categoria' => 'nombre'))
             ->join(array('cm' => 'cont_moneda'), 'sa.cont_moneda_id = cm.cont_moneda_id', array('cont_moneda_id', 'moneda' => 'nombre', 'simbolo'))
             ->join(array('sgt' => 'stock_garantia_tipo'), 'sa.stock_garantia_tipo_id = sgt.stock_garantia_tipo_id', array('stock_garantia_tipo_id', 'garantia_tipo' => 'nombre'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
                 ->where("sa.stock_articulo_id = $id");
        }
    }
}