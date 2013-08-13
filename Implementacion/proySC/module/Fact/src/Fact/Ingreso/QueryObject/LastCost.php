<?php

namespace Fact\Ingreso\QueryObject;

use EnterpriseSolutions\Db\Select as DbSelect;

class LastCost extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('fid' => 'fact_ingreso_detalle'))
			 ->columns(array('fact_ingreso_detalle_id', 'cantidad', 'costo_unit'))
			 
			 ->join(array('fi' => 'fact_ingreso'), 'fid.fact_ingreso_id = fi.fact_ingreso_id', array())
			 ->join(array('fri' => 'fact_rol_ingreso'), 'fi.fact_ingreso_id = fri.fact_ingreso_id', array())
			 
			 ->order(array('fi.doc_fecha DESC'))
			 ->limit(1);
	}
	
	public function addSearchByArticulo($articulo = null)
	{
		if ($articulo && $articulo != "") {
			$this->_select
				 ->where("fid.stock_articulo_id = $articulo");
		}
	}
	
	public function addSearchByParteRol($parteRol = null)
	{
		if ($parteRol && $parteRol != "") {
			$this->_select
				 ->where("fri.org_parte_rol_id = $parteRol");
		}
	}
}