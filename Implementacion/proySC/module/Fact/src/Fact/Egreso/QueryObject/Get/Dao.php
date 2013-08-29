<?php

namespace Fact\Egreso\QueryObject\Get;

use EnterpriseSolutions\Db\Dao\Get as EsDao;

class Dao extends EsDao
{
    public function _consultarDs()
    {
        $records = $this->_select->execute()->toArray();
        
        $egreso   = array();
        $detalles = array();
        $parteRol = array();
        
        foreach ($records as $record) {
            $egreso = array(
                'fact_egreso_id'            => $record['fact_egreso_id'],
                'cont_moneda_id'            => $record['cont_moneda_id'],
                'moneda'                    => $record['moneda'],
                'moneda_simbolo'            => $record['moneda_simbolo'],
                'codigo'                    => $record['codigo'],
                'doc_nro'                   => $record['doc_nro'],
                'doc_fecha'                 => $record['doc_fecha'],
                'doc_tipo'                  => $record['doc_tipo'],
                'condicion'                 => $record['condicion'],
                'estado'                    => $record['estado'],
                'medio_de_pago'             => $record['medio_de_pago'],
                'fecha_vencimiento'         => $record['fecha_vencimiento'],
                'total_excenta'             => $record['total_excenta'],
                'total_iva_cinco_porciento' => $record['total_iva_cinco_porciento'],
                'total_iva_diez_porciento'  => $record['total_iva_diez_porciento'],
                'total_egreso'              => $record['total_egreso'],
            );
            
            $tarjeta = array(
                'tarjeta_tipo'       => $record['tarjeta_tipo'],
                'tarjeta_nombre'     => $record['tarjeta_nombre'],
                'entidad_financiera' => $record['entidad_financiera'],
            );
            
            $parteRol["{$record['rol']}"] = array(
                'nombre_persona'      => $record['nombre_persona'],
                'apellido_persona'    => $record['apellido_persona'],
                'nombre_organizacion' => $record['nombre_organizacion'],
                'documento'           => $record['documento'],
                'tipo_documento'      => $record['tipo'],
            );
            
            $detalles["{$record['fact_egreso_detalle_id']}"] = array(
                'fact_egreso_detalle_id' => $record['fact_egreso_detalle_id'],
                'cantidad'               => $record['cantidad'],
                'precio_unit'            => $record['precio_unit'],
                'porc_impuesto'          => $record['porc_impuesto'],
                'articulo'               => $record['articulo'],
                'articulo_codigo'        => $record['articulo_codigo'],
            );
        }
        
        if (count($records)) {
            $detalles = array_values($detalles);
            $records = array_merge($egreso, array('tarjeta' => $tarjeta), $parteRol, array('detalles' => $detalles));
        }
        return $records;
    }
}