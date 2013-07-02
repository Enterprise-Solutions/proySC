<?php

namespace Stock\Combos\Categoria;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('sc' => 'stock_categoria'))
             ->columns(array('stock_categoria_id', 'categoria' => 'nombre'));
    }
}