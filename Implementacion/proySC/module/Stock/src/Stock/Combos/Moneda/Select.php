<?php

namespace Stock\Combos\Moneda;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('cm' => 'cont_moneda'))
             ->columns(array('cont_moneda_id', 'moneda' => 'nombre'));
    }
}