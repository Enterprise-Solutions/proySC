<?php

namespace Stock\Combos\Marca;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sm' => 'stock_marca'))
             ->columns(array('stock_marca_id', 'marca' => 'nombre'));
    }
}