<?php

namespace Stock\Combos\GarantiaTipo;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sgt' => 'stock_garantia_tipo'))
             ->columns(array('stock_garantia_tipo_id', 'garantia_tipo' => 'nombre'));
    }
}