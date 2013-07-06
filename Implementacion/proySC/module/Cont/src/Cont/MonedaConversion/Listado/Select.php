<?php

namespace Cont\MonedaConversion\Listado;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('cmc' => 'cont_moneda_conversion'))
             //->columns(array('cont_moneda_id', 'nombre', 'nombre_plural', 'simbolo', 'descripcion','permite_decimal'));
             
             ->join(array('origen' => 'cont_moneda'), 'cmc.cont_moneda_origen_id = origen.cont_moneda_id', array('moneda_origen' => 'nombre', 'simbolo_origen' => 'simbolo'))
             ->join(array('destino' => 'cont_moneda'), 'cmc.cont_moneda_destino_id = destino.cont_moneda_id', array('moneda_destino' => 'nombre', 'simbolo_destino' => 'simbolo'));
    }
    
    public function addSearchByContMonedaOrigenId($ContMonedaOrigenId)
    {
    	if ($ContMonedaOrigenId) {
            $this->_select
                 ->where("cmc.cont_moneda_origen_id = $ContMonedaOrigenId OR cmc.cont_moneda_destino_id = $ContMonedaOrigenId");
            	 
        }
    }
    
    /*public function addSearchByCodigo($codigo = null)
    {
        if ($codigo && is_string($codigo)) {
            $this->_select
                 ->where("sa.codigo ILIKE '%$codigo%'");
        }
    }
    
    public function addSearchByMarca($marca = null)
    {
        if ($marca && is_int($marca)) {
            $this->_select
                 ->where("sm.stock_marca_id = $marca");
        }
    }
    
    public function addSearchByCategoria($categoria = null)
    {
        if ($categoria && is_int($categoria)) {
            $this->_select
                 ->where("sc.stock_categoria_id = $categoria");
        }
    }*/
}