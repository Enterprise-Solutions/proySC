<?php

namespace Application\Login\DirPais;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from('dir_pais')
             ->columns(array('dirPaisId' => 'dir_pais_id', 'nombre'));
    }
}