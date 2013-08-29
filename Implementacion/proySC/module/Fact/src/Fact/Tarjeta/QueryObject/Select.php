<?php

namespace Fact\Tarjeta\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('ft' => 'fact_tarjeta'))
             ->columns(array('nombre_titular', 'codigo_seguridad', 'fecha_vencimiento'))
             
             ->join(array('ftt' => 'fact_tarjeta_tipo'), 'ft.fact_tarjeta_tipo_id = ftt.fact_tarjeta_tipo_id', array('tarjeta_tipo' => 'nombre'))
             ->join(array('ftn' => 'fact_tarjeta_nombre'), 'ft.fact_tarjeta_nombre_id = ftn.fact_tarjeta_nombre_id', array('tarjeta_nombre' => 'nombre'))
             ->join(array('feb' => 'fact_entidad_financiera'), 'ft.fact_entidad_financiera_id = feb.fact_entidad_financiera_id', array('entidad_financiera' => 'nombre'));
    }
    
    public function addSearchByTarjetaId($id)
    {
        if ($id) {
            $this->_select
                 ->where("ft.fact_tarjeta_id = $id");
        }
    }
    
    public function addSearchByTarjetaTipo($tipo)
    {
        if ($tipo && $tipo != "") {
            $this->_select
                 ->where("ftt.nombre ILIKE '%$tipo%'");
        }
    }
    
    public function addSearchByCadena($cadena)
    {
        if ($cadena && $cadena != "") {
            $this->_select
                 ->where("(feb.nombre || ' ' || ftn.nombre) ILIKE '%$cadena%'");
        }
    }
}