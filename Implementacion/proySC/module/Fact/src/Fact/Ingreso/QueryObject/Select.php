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
    
    public function addSearchByDocNro($doc_nro)
    {
        if ($doc_nro && $doc_nro != "") {
            $this->_select
                 ->where("fi.doc_nro ILIKE '%$doc_nro%'");
        }
    }
    
    public function addSearchByDocFechaDesde($doc_fecha)
    {
        if ($doc_fecha && $doc_fecha != "") {
            $this->_select
                 ->where("fi.doc_fecha >= '$doc_fecha'");
        }
    }
    
    public function addSearchByDocFechaHasta($doc_fecha)
    {
        if ($doc_fecha && $doc_fecha != "") {
            $this->_select
                 ->where("fi.doc_fecha <= '$doc_fecha'");
        }
    }
    
    public function addSearchByDocTipo($doc_tipo)
    {
        if ($doc_tipo && $doc_tipo != "") {
            $this->_select
                 ->where("fi.doc_tipo = '$doc_tipo'");
        }
    }
}