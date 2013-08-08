<?php

namespace Fact\Ingreso\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Get extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('fi' => 'fact_ingreso'))
             
             ->join(array('fid' => 'fact_ingreso_detalle'), 'fi.fact_ingreso_id = fid.fact_ingreso_id', array('fact_ingreso_detalle_id', 'cantidad', 'costo_unit', 'porc_impuesto'))
             ->join(array('sa' => 'stock_articulo'), 'fid.stock_articulo_id = sa.stock_articulo_id', array('articulo' => 'nombre', 'articulo_codigo' => 'codigo'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
            ->where("fi.fact_ingreso_id = $id");
        }
    }
}