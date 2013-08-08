<?php

namespace Fact\Ingreso\QueryObject\Get;

use EnterpriseSolutions\Db\Dao\Get as EsDao;

class Dao extends EsDao
{
    public function _consultarDs()
    {
        $records = array_map(function ($record) {
            $detalle = array(
                $record['fact_ingreso_detalle_id'],
                $record['cantidad'],
                $record['costo_unit'],
                $record['porc_impuesto'],
                $record['articulo'],
                $record['articulo_codigo'],
            );
            
            return array(
                'fact_ingreso_id' => $record['fact_ingreso_id'],
                'cont_moneda_id'  => $record['cont_moneda_id'],
                'codigo'          => $record['codigo'],
                'doc_nro'         => $record['doc_nro'],
                'doc_fecha'       => $record['doc_fecha'],
                'doc_tipo'        => $record['doc_tipo'],
                'condicion'       => $record['condicion'],
                'estado'          => $record['estado'],
                'total_excenta'   => $record['total_excenta'],
                'total_iva_cinco_porciento' => $record['total_iva_cinco_porciento'],
                'total_iva_diez_porciento'  => $record['total_iva_diez_porciento'],
                'total_ingreso'             => $record['total_ingreso'],
                'detalle'                   => array($detalle),
            );
        }, $this->_select->execute()->toArray());
        
        return $records;
    }
}