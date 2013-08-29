<?php

namespace Fact\Ingreso\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Get extends DbSelect
{
    public function _init()
    {
        $joinExpression = new Expression("op.org_parte_id = od.org_parte_id AND od.preferencia = 1");
        
        $this->_select
             // Ingreso
             ->from(array('fi' => 'fact_ingreso'))
             ->join(array('cm' => 'cont_moneda'), 'fi.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre', 'moneda_simbolo' => 'simbolo'))
             
             // Detalles del Ingreso
             ->join(array('fid' => 'fact_ingreso_detalle'), 'fi.fact_ingreso_id = fid.fact_ingreso_id', array('fact_ingreso_detalle_id', 'cantidad', 'costo_unit', 'porc_impuesto'))
             ->join(array('sa' => 'stock_articulo'), 'fid.stock_articulo_id = sa.stock_articulo_id', array('articulo' => 'nombre', 'articulo_codigo' => 'codigo'))
             
             // Proveedor
             ->join(array('fri' => 'fact_rol_ingreso'), 'fi.fact_ingreso_id = fri.fact_ingreso_id', array())
             ->join(array('opr' => 'org_parte_rol'), 'fri.org_parte_rol_id = opr.org_parte_rol_id', array('rol' => 'org_rol_codigo'))
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre_persona', 'apellido_persona', 'nombre_organizacion'))
             ->join(array('od' => 'org_documento'), $joinExpression, array('documento' => 'valor', 'tipo' => 'org_documento_tipo_codigo'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
            ->where("fi.fact_ingreso_id = $id");
        }
    }
}