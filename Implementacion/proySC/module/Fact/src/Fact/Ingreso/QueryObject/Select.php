<?php

namespace Fact\Ingreso\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('fi' => 'fact_ingreso'))
             ->join(array('cm' => 'cont_moneda'), 'fi.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre', 'moneda_simbolo' => 'simbolo'))
             ->order('fi.doc_fecha');
    }
}