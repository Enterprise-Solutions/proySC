<?php

namespace Application\Login\PerDocTipo;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from('org_documento_tipo')
             ->columns(array('orgDocumentoTipoCodigo' => 'org_documento_tipo_codigo', 'nombre'));
    }
}