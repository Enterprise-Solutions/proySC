<?php

namespace Cont\Moneda\Listado;

use EnterpriseSolutions\Db\Select as DbSelect;

class Select extends DbSelect
{
    public function _init()
    {
        $this->_select
             ->from(array('cm' => 'cont_moneda'));
             //->columns(array('cont_moneda_id', 'nombre', 'nombre_plural', 'simbolo', 'descripcion','permite_decimal','cnt_decimales'));
             
             //->join(array('sm' => 'stock_marca'), 'sa.stock_marca_id = sm.stock_marca_id', array('marca' => 'nombre'))
             //->join(array('sc' => 'stock_categoria'), 'sa.stock_categoria_id = sc.stock_categoria_id', array('categoria' => 'nombre'));
    }
    
    public function addSearchByNombre($nombre = null)
    {
        if ($nombre && is_string($nombre)) {
            $this->_select
                 ->where("cm.nombre ILIKE '%$nombre%'");
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