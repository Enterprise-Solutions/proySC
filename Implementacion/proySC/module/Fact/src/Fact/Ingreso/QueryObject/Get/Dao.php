<?php

namespace Fact\Ingreso\QueryObject\Get;

use EnterpriseSolutions\Db\Dao\Get as EsDao;

class Dao extends EsDao
{
    public function _consultarDs()
    {
        $records = $this->_select->execute()->toArray();
        
        $ingreso  = array();
        $detalles = array();
        $parteRol = array();
        
        foreach ($records as $record) {
            $ingreso = array(
                'fact_ingreso_id'           => $record['fact_ingreso_id'],
                'cont_moneda_id'            => $record['cont_moneda_id'],
                'moneda'                    => $record['moneda'],
                'moneda_simbolo'            => $record['moneda_simbolo'],
                'codigo'                    => $record['codigo'],
                'doc_nro'                   => $record['doc_nro'],
                'doc_fecha'                 => $record['doc_fecha'],
                'doc_tipo'                  => $record['doc_tipo'],
                'condicion'                 => $record['condicion'],
                'estado'                    => $record['estado'],
                'total_excenta'             => $record['total_excenta'],
                'total_iva_cinco_porciento' => $record['total_iva_cinco_porciento'],
                'total_iva_diez_porciento'  => $record['total_iva_diez_porciento'],
                'total_ingreso'             => $record['total_ingreso'],
            );
            
            $parteRol["{$record['rol']}"] = array(
                'nombre_persona'      => $record['nombre_persona'],
                'apellido_persona'    => $record['apellido_persona'],
                'nombre_organizacion' => $record['nombre_organizacion'],
                'documento'           => $record['documento'],
                'tipo_documento'      => $record['tipo'],
            );
            
            $detalles[] = array(
                'fact_ingreso_detalle_id' => $record['fact_ingreso_detalle_id'],
                'cantidad'                => $record['cantidad'],
                'costo_unit'              => $record['costo_unit'],
                'porc_impuesto'           => $record['porc_impuesto'],
                'articulo'                => $record['articulo'],
                'articulo_codigo'         => $record['articulo_codigo'],
            );
        }
        
        if (count($records)) {
            $records = array_merge($ingreso, $parteRol, array('detalles' => $detalles));
        }
        return $records;
    }
}