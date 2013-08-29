<?php

namespace Fact\Egreso\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Expression;

class Get extends DbSelect
{
    public function _init()
    {
        $joinExpression = new Expression("op.org_parte_id = od.org_parte_id AND od.preferencia = 1");
        
        $this->_select
             // Ingreso
             ->from(array('fe' => 'fact_egreso'))
             ->join(array('cm' => 'cont_moneda'), 'fe.cont_moneda_id = cm.cont_moneda_id', array('moneda' => 'nombre', 'moneda_simbolo' => 'simbolo'))
             
             // Tarjeta
             ->join(array('ft' => 'fact_tarjeta'), 'fe.fact_tarjeta_id = ft.fact_tarjeta_id', array())
             ->join(array('ftt' => 'fact_tarjeta_tipo'), 'ft.fact_tarjeta_tipo_id = ftt.fact_tarjeta_tipo_id', array('tarjeta_tipo' => 'nombre'))
             ->join(array('ftn' => 'fact_tarjeta_nombre'), 'ft.fact_tarjeta_nombre_id = ftn.fact_tarjeta_nombre_id', array('tarjeta_nombre' => 'nombre'))
             ->join(array('fef' => 'fact_entidad_financiera'), 'ft.fact_entidad_financiera_id = fef.fact_entidad_financiera_id', array('entidad_financiera' => 'nombre'))
             
             // Detalles del Ingreso
             ->join(array('fed' => 'fact_egreso_detalle'), 'fe.fact_egreso_id = fed.fact_egreso_id', array('fact_egreso_detalle_id', 'cantidad', 'precio_unit', 'porc_impuesto'))
             ->join(array('sa' => 'stock_articulo'), 'fed.stock_articulo_id = sa.stock_articulo_id', array('articulo' => 'nombre', 'articulo_codigo' => 'codigo'))
             
             // Partes
             ->join(array('fre' => 'fact_rol_egreso'), 'fe.fact_egreso_id = fre.fact_egreso_id', array())
             ->join(array('opr' => 'org_parte_rol'), 'fre.org_parte_rol_id = opr.org_parte_rol_id', array('rol' => 'org_rol_codigo'))
             ->join(array('op' => 'org_parte'), 'opr.org_parte_id = op.org_parte_id', array('nombre_persona', 'apellido_persona', 'nombre_organizacion'))
             ->join(array('od' => 'org_documento'), $joinExpression, array('documento' => 'valor', 'tipo' => 'org_documento_tipo_codigo'));
    }
    
    public function addSearchById($id = null)
    {
        if ($id) {
            $this->_select
            ->where("fe.fact_egreso_id = $id");
        }
    }
}