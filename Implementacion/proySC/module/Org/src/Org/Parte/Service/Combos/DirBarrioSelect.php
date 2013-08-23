<?php

namespace Org\Parte\Service\Combos;

use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as EsSelect;

class DirBarrioSelect extends EsSelect
{
	public function _init()
	{
		$this->_select
		     ->columns(array('dir_barrio_id','barrio' => 'nombre','search' => new Expression("dp.nombre||'/'||dc.nombre||'/'||db.nombre")))
		     
			 ->from(array('db' => 'dir_barrio'))
			 ->join(
			 	array('dc' => 'dir_ciudad'),
			 	'db.dir_ciudad_id = dc.dir_ciudad_id',
			 	array('ciudad' => 'nombre')	
			 )
			 ->join(
			 	array('dto' => 'dir_departamento'),
			 	'dc.dir_departamento_id = dto.dir_departamento_id',
			    array('dpto' => 'nombre')	
			 )
			 ->join(
			 	array('dp' => 'dir_pais'),
			 	'dto.dir_pais_id = dp.dir_pais_id',
			 	array('pais' => 'nombre')
			 );
	}
	
	public function addSearchByBarrio($barrio)
	{
		$this->_select
			 ->where("
			( db.nombre ~* '$barrio' or dc.nombre ~* '$barrio' or dp.nombre ~* '$barrio' )		
	    ");
	}
}