<?php

namespace Adm\Usuario\Service\PersonasDisponibles;

use Zend\Db\Sql\Expression;

use Zend\Db\Sql\Select as ZfSelect;

use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{	
		$this->_select
			 ->from(array('op' => 'org_parte'))
			 ->columns(array(
			 		'org_parte_id',
			 		'nombre' => 'nombre_persona',
			 		'apellido' => 'apellido_persona',
			 		'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' ")
			 ))
			 ->join(array('od' => 'org_documento'),new Expression('op.org_parte_id = od.org_parte_id and od.preferencia = 1'),array())
			 ->join(array('dp' => 'dir_pais'),'od.dir_pais_id = dp.dir_pais_id',array())
			 ->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array())
			 ->join(array('odu' => 'org_documento'),'op.org_parte_id = odu.org_parte_id',array())
			 ->join(array('au'  => 'adm_usuario'),'odu.org_documento_id = au.org_documento_id',array(),ZfSelect::JOIN_LEFT)
			 ->where("op.org_parte_tipo_codigo = 'per'")
			 ->group(array('op.org_parte_id','op.nombre_persona','op.apellido_persona','od.valor','odt.nombre','dp.nombre'))
			 ->having("count(au.adm_usuario_id) = 0");
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select->where("((op.nombre_persona ~* '$nombre') or (op.apellido_persona ~* '$nombre') or (od.valor ~* '$nombre'))");
	}
}
